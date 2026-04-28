<?php

namespace App\Http\Controllers;

use App\Models\ChatbotModel;
use App\Models\ChatbotSetting;
use App\Models\CustomerSupportSquad;
use App\Models\CustomerSupportSquadModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CustomerSupportSquadController extends Controller
{
    public function index()
    {
        $query = CustomerSupportSquad::query()->with(['squadModels.chatbotModel'])->latest();
        if (! Auth::user()->isAdmin()) {
            $query->where('is_active', true);
        }
        $squads = $query->get();

        return view('customer-support-squads.index', compact('squads'));
    }

    public function create()
    {
        $models = ChatbotModel::ordered()->get();
        $taskRoles = CustomerSupportSquad::getTaskRoles();

        return view('customer-support-squads.create', compact('models', 'taskRoles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'models' => 'required|array|min:1',
            'models.*.model_id' => 'required|exists:chatbot_models,id',
            'models.*.task_role' => 'required|string',
            'models.*.system_prompt' => 'nullable|string|max:2000',
        ]);

        $squad = CustomerSupportSquad::create([
            'user_id' => Auth::id(),
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'is_active' => true,
        ]);

        foreach ($validated['models'] as $index => $modelData) {
            CustomerSupportSquadModel::create([
                'customer_support_squad_id' => $squad->id,
                'chatbot_model_id' => $modelData['model_id'],
                'task_role' => $modelData['task_role'],
                'system_prompt' => $modelData['system_prompt'] ?? null,
                'sort_order' => $index,
            ]);
        }

        return redirect()->route('customer-support-squads.index')->with('success', 'Customer Support Squad created successfully!');
    }

    public function show(CustomerSupportSquad $customerSupportSquad)
    {
        $this->ensureCanUseSquad($customerSupportSquad);

        $customerSupportSquad->load(['squadModels.chatbotModel']);
        $taskRoles = CustomerSupportSquad::getTaskRoles();

        return view('customer-support-squads.show', compact('customerSupportSquad', 'taskRoles'));
    }

    public function edit(CustomerSupportSquad $customerSupportSquad)
    {
        $customerSupportSquad->load(['squadModels.chatbotModel']);
        $models = ChatbotModel::ordered()->get();
        $taskRoles = CustomerSupportSquad::getTaskRoles();

        return view('customer-support-squads.edit', compact('customerSupportSquad', 'models', 'taskRoles'));
    }

    public function update(Request $request, CustomerSupportSquad $customerSupportSquad)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'is_active' => 'boolean',
            'models' => 'required|array|min:1',
            'models.*.model_id' => 'required|exists:chatbot_models,id',
            'models.*.task_role' => 'required|string',
            'models.*.system_prompt' => 'nullable|string|max:2000',
        ]);

        $customerSupportSquad->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'is_active' => $validated['is_active'] ?? true,
        ]);

        $customerSupportSquad->squadModels()->delete();

        foreach ($validated['models'] as $index => $modelData) {
            CustomerSupportSquadModel::create([
                'customer_support_squad_id' => $customerSupportSquad->id,
                'chatbot_model_id' => $modelData['model_id'],
                'task_role' => $modelData['task_role'],
                'system_prompt' => $modelData['system_prompt'] ?? null,
                'sort_order' => $index,
            ]);
        }

        return redirect()->route('customer-support-squads.show', $customerSupportSquad)->with('success', 'Customer Support Squad updated successfully!');
    }

    public function destroy(CustomerSupportSquad $customerSupportSquad)
    {
        $customerSupportSquad->delete();

        return redirect()->route('customer-support-squads.index')->with('success', 'Customer Support Squad deleted successfully!');
    }

    public function test(Request $request, CustomerSupportSquad $customerSupportSquad)
    {
        $this->ensureCanUseSquad($customerSupportSquad);

        if (! $customerSupportSquad->is_active && ! Auth::user()->isAdmin()) {
            return response()->json(['success' => false, 'error' => 'Squad is not active'], 400);
        }

        $request->validate([
            'customer_message' => 'required|string|max:5000',
            'customer_context' => 'nullable|string|max:3000',
            'policy_context' => 'nullable|string|max:3000',
        ]);

        $customerSupportSquad->load(['squadModels.chatbotModel']);
        if ($customerSupportSquad->squadModels->isEmpty()) {
            return response()->json(['success' => false, 'error' => 'No models assigned to this squad'], 400);
        }

        $chatbotSettings = ChatbotSetting::get();
        $baseUrl = $chatbotSettings->base_url ?: config('services.chatbot.base_url', 'https://api.ai.cc/v1');
        $apiKey = $chatbotSettings->api_key ?: config('services.chatbot.api_key');
        $temperature = $chatbotSettings->temperature ?? config('services.chatbot.temperature', 0.5);
        $maxTokens = $chatbotSettings->max_tokens ?? config('services.chatbot.max_tokens', 256);

        if (empty($apiKey)) {
            return response()->json(['success' => false, 'error' => 'API key not configured'], 400);
        }

        $results = [];
        $apiUrl = rtrim($baseUrl, '/').'/chat/completions';

        foreach ($customerSupportSquad->squadModels as $squadModel) {
            $taskRole = $squadModel->task_role;
            $taskRoleName = CustomerSupportSquad::getTaskRoles()[$taskRole] ?? $taskRole;
            $model = $squadModel->chatbotModel;

            $userPrompt = $this->buildTaskPrompt(
                $taskRole,
                $request->input('customer_message'),
                $request->input('customer_context'),
                $request->input('policy_context')
            );
            $systemPrompt = $squadModel->system_prompt ?: $this->getDefaultSystemPrompt($taskRole);

            try {
                $messages = [];
                if (! empty($systemPrompt)) {
                    $messages[] = ['role' => 'system', 'content' => $systemPrompt];
                }
                $messages[] = ['role' => 'user', 'content' => $userPrompt];

                $response = Http::timeout(120)
                    ->withHeaders([
                        'Authorization' => 'Bearer '.$apiKey,
                        'Content-Type' => 'application/json',
                    ])
                    ->post($apiUrl, [
                        'model' => $model->api_name,
                        'messages' => $messages,
                        'temperature' => (float) $temperature,
                        'max_tokens' => (int) $maxTokens,
                    ]);

                if ($response->successful()) {
                    $data = $response->json();
                    $results[] = [
                        'task_role' => $taskRole,
                        'task_role_name' => $taskRoleName,
                        'model_name' => $model->name,
                        'response' => $data['choices'][0]['message']['content'] ?? 'No response content found',
                        'usage' => $data['usage'] ?? null,
                        'success' => true,
                    ];
                } else {
                    $errorBody = $response->json();
                    $errorMessage = $errorBody['error']['message'] ?? $errorBody['error'] ?? $response->body();
                    $results[] = [
                        'task_role' => $taskRole,
                        'task_role_name' => $taskRoleName,
                        'model_name' => $model->name,
                        'success' => false,
                        'error' => 'API request failed: '.$response->status(),
                        'message' => $errorMessage,
                    ];
                }
            } catch (\Exception $e) {
                Log::error('Customer Support Squad API Error: '.$e->getMessage(), [
                    'squad_id' => $customerSupportSquad->id,
                    'task_role' => $taskRole,
                ]);
                $results[] = [
                    'task_role' => $taskRole,
                    'task_role_name' => $taskRoleName,
                    'model_name' => $model->name,
                    'success' => false,
                    'error' => 'Failed to connect to API',
                    'message' => $e->getMessage(),
                ];
            }
        }

        return response()->json([
            'success' => true,
            'squad_name' => $customerSupportSquad->name,
            'results' => $results,
        ]);
    }

    private function buildTaskPrompt(string $taskRole, string $message, ?string $context, ?string $policy): string
    {
        $base = "Customer message:\n{$message}\n\n";
        if ($context) {
            $base .= "Customer/account context:\n{$context}\n\n";
        }
        if ($policy) {
            $base .= "Company policy / knowledge base:\n{$policy}\n\n";
        }

        return match ($taskRole) {
            'intent_detection' => $base.'Identify the customer intent, urgency level, and key entities.',
            'sentiment_analysis' => $base.'Assess customer sentiment, frustration risk, and empathy guidance.',
            'response_drafting' => $base.'Draft a clear support reply with concise steps and friendly tone.',
            'escalation_risk' => $base.'Evaluate escalation/churn risk and recommend escalation path if needed.',
            'policy_compliance' => $base.'Check the response against policy and identify compliance risks.',
            'qa_reviewer' => $base.'Perform final QA and provide improved final response to send.',
            default => $base.'Provide actionable customer support recommendations.',
        };
    }

    private function getDefaultSystemPrompt(string $taskRole): string
    {
        $roles = [
            'intent_detection' => 'You are a support triage analyst. Detect intent and priority precisely.',
            'sentiment_analysis' => 'You are a customer sentiment specialist. Be practical and empathetic.',
            'response_drafting' => 'You are a senior support agent. Draft concise and accurate responses.',
            'escalation_risk' => 'You are a support escalation manager. Flag risk and next best action.',
            'policy_compliance' => 'You are a policy compliance reviewer. Ensure safe and compliant support output.',
            'qa_reviewer' => 'You are a QA lead for support. Return polished final response and checklist.',
        ];

        return $roles[$taskRole] ?? 'You are an expert customer support assistant.';
    }

    private function ensureCanUseSquad(CustomerSupportSquad $customerSupportSquad): void
    {
        if (Auth::user()->isAdmin()) {
            return;
        }

        if (! $customerSupportSquad->is_active) {
            abort(403, 'This squad is not available.');
        }
    }
}
