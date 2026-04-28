<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class AgentRuntimeClient
{
    public function invoke(
        string $input,
        ?string $flowId,
        ?int $agentId,
        int $userId,
        ?string $langsmithProject,
    ): array {
        $secret = config('agent_runtime.secret');
        $baseUrl = config('agent_runtime.url');

        if ($secret === '' || $baseUrl === '') {
            throw new RuntimeException('Agent runtime is not configured (AGENT_RUNTIME_URL / AGENT_RUNTIME_SECRET).');
        }

        $response = Http::timeout(125)
            ->withHeaders([
                'X-Agent-Runtime-Secret' => $secret,
                'Accept' => 'application/json',
            ])
            ->post($baseUrl.'/invoke', [
                'flow_id' => $flowId,
                'input' => $input,
                'agent_id' => $agentId,
                'user_id' => $userId,
                'langsmith_project' => $langsmithProject,
            ]);

        if (! $response->successful()) {
            Log::warning('agent_runtime_invoke_failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            throw new RuntimeException('Agent runtime returned HTTP '.$response->status());
        }

        return $response->json();
    }

    public function isConfigured(): bool
    {
        return config('agent_runtime.secret') !== '' && config('agent_runtime.url') !== '';
    }
}
