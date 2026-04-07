<?php

namespace App\Http\Controllers;

use App\Models\ChatbotConversation;
use App\Models\ChatbotMessage;
use App\Models\ChatbotModel;
use App\Models\ChatbotSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ChatbotTestController extends Controller
{
    public function index()
    {
        $models = ChatbotModel::ordered()->get();
        $defaultModel = ChatbotModel::getDefault();
        $conversations = ChatbotConversation::query()
            ->where('user_id', auth()->id())
            ->with([
                'latestMessage' => function ($query) {
                    $query->select([
                        'chatbot_messages.id',
                        'chatbot_messages.conversation_id',
                        'chatbot_messages.role',
                        'chatbot_messages.content',
                        'chatbot_messages.created_at',
                    ]);
                },
                'messages:id,conversation_id,role,content,created_at',
            ])
            ->orderByDesc('last_message_at')
            ->orderByDesc('id')
            ->limit(30)
            ->get();

        return view('chatbot.test', compact('models', 'defaultModel', 'conversations'));
    }

    public function test(Request $request)
    {
        $request->validate([
            'prompt' => 'required|string|max:5000',
            'system_prompt' => 'nullable|string|max:1000',
            'model_id' => 'nullable|exists:chatbot_models,id',
            'conversation_id' => 'nullable|integer|exists:chatbot_conversations,id',
            'conversation' => 'nullable|string|max:512000',
        ]);

        $userPrompt = $request->input('prompt');
        $systemPrompt = $request->input('system_prompt', 'You are a helpful AI assistant. Be descriptive and helpful.');
        $conversation = $this->resolveConversation($request, $systemPrompt);
        $history = $conversation
            ? $this->historyFromConversation($conversation)
            : $this->parseConversationJson($request->input('conversation'));

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
        if (! $model) {
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
            $apiUrl = rtrim($baseUrl, '/').'/chat/completions';

            // Prepare messages: system + prior turns + latest user message
            $messages = [];
            if (! empty($systemPrompt)) {
                $messages[] = [
                    'role' => 'system',
                    'content' => $systemPrompt,
                ];
            }
            $messages = array_merge($messages, $history);
            $messages[] = [
                'role' => 'user',
                'content' => $userPrompt,
            ];

            // Make API call using OpenAI-compatible format
            $response = Http::timeout(60)
                ->withHeaders([
                    'Authorization' => 'Bearer '.$apiKey,
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

                if (! $conversation) {
                    $conversation = $this->createConversation($request, $systemPrompt, $userPrompt);
                }
                ChatbotMessage::create([
                    'conversation_id' => $conversation->id,
                    'role' => 'user',
                    'content' => $userPrompt,
                ]);
                ChatbotMessage::create([
                    'conversation_id' => $conversation->id,
                    'role' => 'assistant',
                    'content' => $aiResponse ?? 'No response content found',
                ]);
                $conversation->update([
                    'last_message_at' => now(),
                    'title' => $conversation->title ?: Str::limit(trim($userPrompt), 90, ''),
                ]);

                return response()->json([
                    'success' => true,
                    'response' => $aiResponse ?? 'No response content found',
                    'raw' => $data,
                    'usage' => $data['usage'] ?? null,
                    'conversation_id' => $conversation?->id,
                    'conversation_title' => $conversation?->title,
                ]);
            } else {
                $errorBody = $response->json();
                $errorMessage = $errorBody['error']['message'] ?? $errorBody['error'] ?? $response->body();

                return response()->json([
                    'success' => false,
                    'error' => 'API request failed: '.$response->status(),
                    'message' => $errorMessage,
                    'raw' => $errorBody,
                ], $response->status());
            }
        } catch (\Exception $e) {
            Log::error('Chatbot API Error: '.$e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'error' => 'Failed to connect to chatbot API',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    private function resolveConversation(Request $request, string $systemPrompt): ?ChatbotConversation
    {
        if ($request->filled('conversation_id')) {
            $conversation = ChatbotConversation::findOrFail((int) $request->input('conversation_id'));
            if ($conversation->user_id !== auth()->id()) {
                abort(403);
            }

            $updates = [];
            if ($request->filled('model_id')) {
                $updates['model_id'] = (int) $request->input('model_id');
            }
            if ($request->filled('system_prompt')) {
                $updates['system_prompt'] = $systemPrompt;
            }
            if (! empty($updates)) {
                $conversation->update($updates);
            }

            return $conversation;
        }

        return null;
    }

    private function createConversation(Request $request, string $systemPrompt, string $userPrompt): ChatbotConversation
    {
        return ChatbotConversation::create([
            'user_id' => auth()->id(),
            'model_id' => $request->filled('model_id') ? (int) $request->input('model_id') : null,
            'system_prompt' => $systemPrompt,
            'title' => Str::limit(trim($userPrompt), 90, ''),
            'last_message_at' => now(),
        ]);
    }

    /**
     * @return array<int, array{role: string, content: string}>
     */
    private function historyFromConversation(ChatbotConversation $conversation): array
    {
        $messages = $conversation->messages()
            ->orderBy('id')
            ->limit(80)
            ->get(['role', 'content']);

        return $messages
            ->map(fn ($message) => [
                'role' => $message->role,
                'content' => $message->content,
            ])
            ->all();
    }

    /**
     * @return array<int, array{role: string, content: string}>
     */
    private function parseConversationJson(?string $json): array
    {
        if ($json === null || $json === '') {
            return [];
        }
        $decoded = json_decode($json, true);
        if (! is_array($decoded)) {
            return [];
        }
        $out = [];
        foreach ($decoded as $msg) {
            if (! is_array($msg) || ! isset($msg['role'], $msg['content'])) {
                continue;
            }
            $role = $msg['role'];
            if (! in_array($role, ['user', 'assistant'], true)) {
                continue;
            }
            $content = is_string($msg['content']) ? $msg['content'] : '';
            if (mb_strlen($content) > 8000) {
                $content = mb_substr($content, 0, 8000);
            }
            $out[] = ['role' => $role, 'content' => $content];
        }

        return array_slice($out, -40);
    }
}
