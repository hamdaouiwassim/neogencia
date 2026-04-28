<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\AgentInvocation;
use App\Services\AgentRuntimeClient;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RuntimeException;
use Throwable;

class AgentInvokeController extends Controller
{
    public function __construct(
        private readonly AgentRuntimeClient $runtimeClient
    ) {}

    public function invoke(Request $request, Agent $agent): JsonResponse
    {
        $this->authorizeInvoke($agent);

        $validated = $request->validate([
            'input' => 'required|string|max:32000',
        ]);

        if ($agent->execution_mode !== 'hosted') {
            return response()->json(['success' => false, 'error' => 'Agent is not a hosted agent.'], 422);
        }

        if (! $this->runtimeClient->isConfigured()) {
            return response()->json(['success' => false, 'error' => 'Hosted execution is not configured on this server.'], 503);
        }

        $t0 = microtime(true);
        $status = 'failed';
        $output = '';
        $traceUrl = null;
        $langsmithRunId = null;
        $runtimeSource = null;
        $errorMessage = null;

        try {
            $payload = $this->runtimeClient->invoke(
                $validated['input'],
                $agent->langflow_flow_id,
                $agent->id,
                (int) Auth::id(),
                $agent->langsmith_project,
            );
            $status = ($payload['success'] ?? false) ? 'completed' : 'failed';
            $output = (string) ($payload['output'] ?? '');
            $traceUrl = $payload['trace_url'] ?? null;
            $langsmithRunId = $payload['langsmith_run_id'] ?? null;
            $runtimeSource = $payload['source'] ?? null;
            $errorMessage = $payload['error'] ?? null;
        } catch (RuntimeException $e) {
            $errorMessage = $e->getMessage();
        } catch (Throwable $e) {
            report($e);
            $errorMessage = 'Unexpected error while invoking agent.';
        }

        $latencyMs = (int) round((microtime(true) - $t0) * 1000);

        AgentInvocation::create([
            'agent_id' => $agent->id,
            'user_id' => Auth::id(),
            'status' => $status,
            'langsmith_run_id' => $langsmithRunId,
            'trace_url' => $traceUrl,
            'latency_ms' => $latencyMs,
            'runtime_source' => $runtimeSource,
            'output' => $output !== '' ? $output : null,
            'error' => $errorMessage,
        ]);

        if ($status !== 'completed') {
            return response()->json([
                'success' => false,
                'error' => $errorMessage ?? 'Invocation failed.',
            ], 502);
        }

        return response()->json([
            'success' => true,
            'output' => $output,
            'trace_url' => $traceUrl,
            'langsmith_run_id' => $langsmithRunId,
            'source' => $runtimeSource,
            'latency_ms' => $latencyMs,
        ]);
    }

    private function authorizeInvoke(Agent $agent): void
    {
        $user = Auth::user();
        if (! $user) {
            abort(401);
        }

        $isOwner = (int) $agent->user_id === (int) $user->id;

        if ($isOwner || $user->isAdmin()) {
            return;
        }

        if ($agent->is_approved) {
            return;
        }

        abort(403, 'You cannot run this agent yet.');
    }
}
