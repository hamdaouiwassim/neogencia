<?php

namespace App\Http\Controllers;

use App\Models\ChatbotModel;
use App\Models\ChatbotSetting;
use App\Models\SeoSquad;
use App\Models\SeoSquadModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SeoSquadController extends Controller
{
    public function index()
    {
        $squads = SeoSquad::where('user_id', Auth::id())
            ->with(['squadModels.chatbotModel'])
            ->latest()
            ->get();
        
        return view('seo-squads.index', compact('squads'));
    }

    public function create()
    {
        $models = ChatbotModel::ordered()->get();
        $taskRoles = SeoSquad::getTaskRoles();
        
        return view('seo-squads.create', compact('models', 'taskRoles'));
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

        $squad = SeoSquad::create([
            'user_id' => Auth::id(),
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'is_active' => true,
        ]);

        foreach ($validated['models'] as $index => $modelData) {
            SeoSquadModel::create([
                'seo_squad_id' => $squad->id,
                'chatbot_model_id' => $modelData['model_id'],
                'task_role' => $modelData['task_role'],
                'system_prompt' => $modelData['system_prompt'] ?? null,
                'sort_order' => $index,
            ]);
        }

        return redirect()->route('seo-squads.index')->with('success', 'SEO Squad created successfully!');
    }

    public function show(SeoSquad $seoSquad)
    {
        // Ensure user owns this squad
        if ($seoSquad->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        $seoSquad->load(['squadModels.chatbotModel']);
        $taskRoles = SeoSquad::getTaskRoles();
        
        return view('seo-squads.show', compact('seoSquad', 'taskRoles'));
    }

    public function edit(SeoSquad $seoSquad)
    {
        // Ensure user owns this squad
        if ($seoSquad->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        $seoSquad->load(['squadModels.chatbotModel']);
        $models = ChatbotModel::ordered()->get();
        $taskRoles = SeoSquad::getTaskRoles();
        
        return view('seo-squads.edit', compact('seoSquad', 'models', 'taskRoles'));
    }

    public function update(Request $request, SeoSquad $seoSquad)
    {
        // Ensure user owns this squad
        if ($seoSquad->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'is_active' => 'boolean',
            'models' => 'required|array|min:1',
            'models.*.model_id' => 'required|exists:chatbot_models,id',
            'models.*.task_role' => 'required|string',
            'models.*.system_prompt' => 'nullable|string|max:2000',
        ]);

        $seoSquad->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'is_active' => $validated['is_active'] ?? true,
        ]);

        // Delete existing squad models
        $seoSquad->squadModels()->delete();

        // Create new squad models
        foreach ($validated['models'] as $index => $modelData) {
            SeoSquadModel::create([
                'seo_squad_id' => $seoSquad->id,
                'chatbot_model_id' => $modelData['model_id'],
                'task_role' => $modelData['task_role'],
                'system_prompt' => $modelData['system_prompt'] ?? null,
                'sort_order' => $index,
            ]);
        }

        return redirect()->route('seo-squads.show', $seoSquad)->with('success', 'SEO Squad updated successfully!');
    }

    public function destroy(SeoSquad $seoSquad)
    {
        // Ensure user owns this squad
        if ($seoSquad->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        $seoSquad->delete();

        return redirect()->route('seo-squads.index')->with('success', 'SEO Squad deleted successfully!');
    }

    public function analyze(Request $request, SeoSquad $seoSquad)
    {
        // Ensure user owns this squad
        if ($seoSquad->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        if (!$seoSquad->is_active) {
            return response()->json([
                'success' => false,
                'error' => 'Squad is not active',
            ], 400);
        }

        $request->validate([
            'url' => 'required|url|max:500',
            'target_keywords' => 'nullable|string|max:500',
            'content' => 'nullable|string|max:10000',
        ]);

        $seoSquad->load(['squadModels.chatbotModel']);
        
        if ($seoSquad->squadModels->isEmpty()) {
            return response()->json([
                'success' => false,
                'error' => 'No models assigned to this squad',
            ], 400);
        }

        // Get API configuration
        $chatbotSettings = ChatbotSetting::get();
        $baseUrl = $chatbotSettings->base_url ?: config('services.chatbot.base_url', 'https://api.ai.cc/v1');
        $apiKey = $chatbotSettings->api_key ?: config('services.chatbot.api_key');
        $temperature = $chatbotSettings->temperature ?? config('services.chatbot.temperature', 0.7);
        $maxTokens = $chatbotSettings->max_tokens ?? config('services.chatbot.max_tokens', 256);

        if (empty($apiKey)) {
            return response()->json([
                'success' => false,
                'error' => 'API key not configured',
                'message' => 'Please set the API key in Admin → Chatbot Settings or in your .env file (CHATBOT_API_KEY).',
            ], 400);
        }

        $results = [];
        $apiUrl = rtrim($baseUrl, '/') . '/chat/completions';

        // Process each model in the squad
        foreach ($seoSquad->squadModels as $squadModel) {
            $taskRole = $squadModel->task_role;
            $taskRoleName = SeoSquad::getTaskRoles()[$taskRole] ?? $taskRole;
            $model = $squadModel->chatbotModel;
            
            // Build task-specific prompt
            $userPrompt = $this->buildTaskPrompt($taskRole, $request->input('url'), $request->input('target_keywords'), $request->input('content'));
            $systemPrompt = $squadModel->system_prompt ?: $this->getDefaultSystemPrompt($taskRole);

            try {
                $messages = [];
                if (!empty($systemPrompt)) {
                    $messages[] = ['role' => 'system', 'content' => $systemPrompt];
                }
                $messages[] = ['role' => 'user', 'content' => $userPrompt];

                $response = Http::timeout(120)
                    ->withHeaders([
                        'Authorization' => 'Bearer ' . $apiKey,
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
                    $aiResponse = $data['choices'][0]['message']['content'] ?? 'No response content found';
                    
                    $results[] = [
                        'task_role' => $taskRole,
                        'task_role_name' => $taskRoleName,
                        'model_name' => $model->name,
                        'response' => $aiResponse,
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
                        'error' => 'API request failed: ' . $response->status(),
                        'message' => $errorMessage,
                    ];
                }
            } catch (\Exception $e) {
                Log::error('SEO Squad API Error: ' . $e->getMessage(), [
                    'squad_id' => $seoSquad->id,
                    'task_role' => $taskRole,
                    'trace' => $e->getTraceAsString(),
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
            'squad_name' => $seoSquad->name,
            'url' => $request->input('url'),
            'results' => $results,
        ]);
    }

    private function buildTaskPrompt(string $taskRole, string $url, ?string $keywords, ?string $content): string
    {
        $base = "Analyze the following URL for SEO: {$url}\n\n";
        
        if ($keywords) {
            $base .= "Target Keywords: {$keywords}\n\n";
        }
        
        if ($content) {
            $base .= "Page Content:\n{$content}\n\n";
        }

        switch ($taskRole) {
            case 'keyword_research':
                return $base . "Provide keyword research recommendations including primary keywords, long-tail keywords, search volume estimates, and keyword difficulty analysis.";
            
            case 'content_optimization':
                return $base . "Analyze the content and provide specific recommendations for optimization including keyword placement, content structure, readability improvements, and content gaps.";
            
            case 'meta_tags':
                return $base . "Generate optimized meta tags including title tag (50-60 characters), meta description (150-160 characters), Open Graph tags, and schema markup suggestions.";
            
            case 'competitor_analysis':
                return $base . "Analyze competitors for this URL/keyword and provide insights on their SEO strategies, backlink profiles, content strategies, and opportunities to outperform them.";
            
            case 'technical_seo':
                return $base . "Perform technical SEO analysis including page speed, mobile-friendliness, crawlability, indexability, structured data, and technical recommendations.";
            
            case 'link_building':
                return $base . "Provide link building strategy recommendations including target domains, outreach opportunities, content ideas for linkable assets, and link acquisition tactics.";
            
            case 'content_audit':
                return $base . "Perform a comprehensive content audit including content quality assessment, duplicate content issues, content gaps, and recommendations for improvement or removal.";
            
            case 'performance_analysis':
                return $base . "Analyze SEO performance metrics and provide insights on rankings, traffic trends, conversion opportunities, and actionable recommendations for improvement.";
            
            default:
                return $base . "Provide comprehensive SEO analysis and recommendations.";
        }
    }

    private function getDefaultSystemPrompt(string $taskRole): string
    {
        $roleDescriptions = [
            'keyword_research' => 'You are an expert SEO keyword researcher. Provide detailed, actionable keyword recommendations.',
            'content_optimization' => 'You are an expert SEO content optimizer. Provide specific, actionable content optimization recommendations.',
            'meta_tags' => 'You are an expert in SEO meta tags and structured data. Generate optimized, compelling meta tags.',
            'competitor_analysis' => 'You are an expert SEO competitor analyst. Provide strategic insights and competitive advantages.',
            'technical_seo' => 'You are an expert technical SEO specialist. Identify technical issues and provide actionable fixes.',
            'link_building' => 'You are an expert link building strategist. Provide creative, ethical link building recommendations.',
            'content_audit' => 'You are an expert content auditor. Identify content issues and provide improvement strategies.',
            'performance_analysis' => 'You are an expert SEO performance analyst. Provide data-driven insights and recommendations.',
        ];

        return $roleDescriptions[$taskRole] ?? 'You are an expert SEO specialist. Provide comprehensive, actionable SEO recommendations.';
    }
}
