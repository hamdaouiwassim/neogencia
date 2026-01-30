<?php

namespace App\Http\Controllers;

use App\Models\ChatbotModel;
use App\Models\ChatbotSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatbotTestController extends Controller
{
    public function index()
    {
        $models = ChatbotModel::ordered()->get();
        $defaultModel = ChatbotModel::getDefault();
        return view('chatbot.test', compact('models', 'defaultModel'));
    }

    public function test(Request $request)
    {
        $request->validate([
            'prompt' => 'required|string|max:5000',
            'system_prompt' => 'nullable|string|max:1000',
            'model_id' => 'nullable|exists:chatbot_models,id',
        ]);

        $userPrompt = $request->input('prompt');
        $systemPrompt = $request->input('system_prompt', 'You are a helpful AI assistant. Be descriptive and helpful.');
        
        // Get API configuration from database settings (fallback to config)
        $chatbotSettings = ChatbotSetting::get();
        $baseUrl = $chatbotSettings->base_url ?: config('services.chatbot.base_url', 'https://api.ai.cc/v1');
        $apiKey = $chatbotSettings->api_key ?: config('services.chatbot.api_key');
        $temperature = $chatbotSettings->temperature ?? config('services.chatbot.temperature', 0.7);
        $maxTokens = $chatbotSettings->max_tokens ?? config('services.chatbot.max_tokens', 256);

        // Resolve model from database or fallback to config
        $model = null;
        if ($request->filled('model_id')) {
            $chatbotModel = ChatbotModel::find($request->model_id);
            if ($chatbotModel) {
                $model = $chatbotModel->api_name;
            }
        }
        if (!$model) {
            $defaultModel = ChatbotModel::getDefault();
            $model = $defaultModel ? $defaultModel->api_name : config('services.chatbot.model', 'mistralai/Mistral-7B-Instruct-v0.2');
        }
        
        // Check if API key is configured
        if (empty($apiKey)) {
            return response()->json([
                'success' => false,
                'error' => 'API key not configured',
                'message' => 'Please set the API key in Admin → Chatbot Settings or in your .env file (CHATBOT_API_KEY).',
            ], 400);
        }
        
        try {
            // Build the API endpoint
            $apiUrl = rtrim($baseUrl, '/') . '/chat/completions';
            
            // Prepare messages array
            $messages = [];
            
            // Add system prompt if provided
            if (!empty($systemPrompt)) {
                $messages[] = [
                    'role' => 'system',
                    'content' => $systemPrompt,
                ];
            }
            
            // Add user prompt
            $messages[] = [
                'role' => 'user',
                'content' => $userPrompt,
            ];
            
            // Make API call using OpenAI-compatible format
            $response = Http::timeout(60)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $apiKey,
                    'Content-Type' => 'application/json',
                ])
                ->post($apiUrl, [
                    'model' => $model,
                    'messages' => $messages,
                    'temperature' => (float) $temperature,
                    'max_tokens' => (int) $maxTokens,
                ]);

            if ($response->successful()) {
                $data = $response->json();
                
                // Extract the response from OpenAI-compatible format
                $aiResponse = null;
                if (isset($data['choices'][0]['message']['content'])) {
                    $aiResponse = $data['choices'][0]['message']['content'];
                } elseif (isset($data['choices'][0]['text'])) {
                    $aiResponse = $data['choices'][0]['text'];
                }
                
                return response()->json([
                    'success' => true,
                    'response' => $aiResponse ?? 'No response content found',
                    'raw' => $data,
                    'usage' => $data['usage'] ?? null,
                ]);
            } else {
                $errorBody = $response->json();
                $errorMessage = $errorBody['error']['message'] ?? $errorBody['error'] ?? $response->body();
                
                return response()->json([
                    'success' => false,
                    'error' => 'API request failed: ' . $response->status(),
                    'message' => $errorMessage,
                    'raw' => $errorBody,
                ], $response->status());
            }
        } catch (\Exception $e) {
            Log::error('Chatbot API Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
            
            return response()->json([
                'success' => false,
                'error' => 'Failed to connect to chatbot API',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
