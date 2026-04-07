<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <div class="flex items-center space-x-3 mb-2">
                    <div class="w-10 h-10 bg-gradient-to-br from-violet-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                    </div>
                    <h2 class="font-bold text-2xl bg-gradient-to-r from-violet-600 to-purple-600 bg-clip-text text-transparent">
                        {{ __('AI Chatbot Test') }}
                    </h2>
                </div>
                <p class="text-sm text-gray-600 dark:text-gray-400 ml-13">Test and interact with the AI chatbot API</p>
            </div>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="max-w-[1400px] mx-auto sm:px-6 lg:px-8">
            <!-- Form view (visible by default) -->
            <div id="chatbot-form-view">
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-5 xl:gap-6 items-start">
                <!-- Input Section -->
                <div class="xl:col-span-2">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-2xl border border-gray-200 dark:border-gray-700">
                        <!-- Header -->
                        <div class="p-5 sm:p-6 border-b border-gray-200 dark:border-gray-700 bg-gray-50/80 dark:bg-gray-900/40">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-violet-600 rounded-xl flex items-center justify-center shadow-sm">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">{{ __('Chat with AI') }}</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-0.5">{{ __('Ask questions, follow up, and resume later.') }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <form id="chatbot-form" class="p-5 sm:p-6 space-y-5">
                            @csrf
                            <input type="hidden" id="conversation_id" name="conversation_id" value="">
                            
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 rounded-xl border border-gray-200 dark:border-gray-700 p-4 bg-gray-50/60 dark:bg-gray-900/30">
                            <!-- Model Select -->
                            <div class="group">
                                <label for="model_id" class="flex items-center justify-between mb-1.5">
                                    <span class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                        <span class="inline-flex items-center">
                                            <svg class="w-4 h-4 mr-1.5 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                                            </svg>
                                            AI Model
                                        </span>
                                    </span>
                                </label>
                                <select
                                    id="model_id" 
                                    name="model_id" 
                                    class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-violet-500 dark:focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20 shadow-sm transition-all duration-200 font-medium"
                                >
                                    @forelse($models as $model)
                                        <option value="{{ $model->id }}" {{ ($defaultModel && $defaultModel->id === $model->id) ? 'selected' : '' }}>
                                            {{ $model->name }}
                                            @if($model->is_default)
                                                (Default)
                                            @endif
                                        </option>
                                    @empty
                                        <option value="">— No models configured —</option>
                                    @endforelse
                                </select>
                                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">{{ __('Choose model') }}</p>
                            </div>
                            
                            <!-- System Prompt -->
                            <div class="group">
                                <label for="system_prompt" class="flex items-center justify-between mb-1.5">
                                    <span class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                        <span class="inline-flex items-center">
                                            <svg class="w-4 h-4 mr-1.5 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                            </svg>
                                            System Prompt
                                        </span>
                                    </span>
                                    <span class="text-xs text-gray-400 dark:text-gray-500 bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded-full">Optional</span>
                                </label>
                                <textarea 
                                    id="system_prompt" 
                                    name="system_prompt" 
                                    rows="3" 
                                    class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-violet-500 dark:focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20 shadow-sm transition-all duration-200 resize-none font-medium"
                                    placeholder="You are a helpful AI assistant. Be descriptive and helpful."
                                ></textarea>
                                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">{{ __('Optional behavior instructions') }}</p>
                            </div>
                            </div>
                            
                            <!-- Conversation -->
                            <div class="group">
                                <label class="flex items-center justify-between mb-2">
                                    <span class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                        <span class="inline-flex items-center">
                                            <svg class="w-4 h-4 mr-1.5 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                            </svg>
                                            {{ __('Conversation') }}
                                        </span>
                                    </span>
                                </label>
                                <div id="conversation-scroll" class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900/50 min-h-[360px] max-h-[62vh] overflow-y-auto p-4 space-y-3 shadow-inner">
                                    <div id="conversation-hint" class="flex flex-col items-center justify-center py-12 text-center text-sm text-gray-500 dark:text-gray-400">
                                        <p class="font-medium text-gray-600 dark:text-gray-300 mb-1">{{ __('Start a conversation') }}</p>
                                        <p class="max-w-sm">{{ __('Type a message below and send. Each reply stays in the thread so you can follow up naturally.') }}</p>
                                    </div>
                                    <div id="conversation-thread" class="space-y-3 hidden pb-1"></div>
                                </div>
                            </div>

                            <!-- Message input -->
                            <div class="group">
                                <label for="prompt" class="flex items-center justify-between mb-2">
                                    <span class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                        <span class="inline-flex items-center">
                                            <svg class="w-4 h-4 mr-1.5 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                            {{ __('Your message') }}
                                        </span>
                                    </span>
                                    <span class="text-xs text-gray-400 dark:text-gray-500">{{ __('Shift+Enter for new line') }}</span>
                                </label>
                                <div class="relative rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/30 p-2">
                                    <textarea
                                        id="prompt"
                                        name="prompt"
                                        rows="4"
                                        class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-violet-500 dark:focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20 shadow-sm transition-all duration-200 resize-y font-medium placeholder-gray-400 min-h-[110px]"
                                        placeholder="{{ __('Type your message…') }}"
                                        required
                                    ></textarea>
                                    <div class="absolute bottom-5 right-5 flex items-center space-x-2 pointer-events-none">
                                        <div id="char-count" class="text-xs font-semibold text-gray-400 dark:text-gray-500 bg-white dark:bg-gray-800 px-2 py-1 rounded-md border border-gray-200 dark:border-gray-700">
                                            0
                                        </div>
                                        <span class="text-xs text-gray-300 dark:text-gray-600">/ 5000</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex flex-wrap items-center justify-between gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                                <button
                                    type="button"
                                    id="clear-btn"
                                    class="inline-flex items-center px-4 py-2.5 text-sm font-semibold text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg transition-colors"
                                >
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    {{ __('Clear conversation') }}
                                </button>

                                <button
                                    type="submit"
                                    id="submit-btn"
                                    class="inline-flex items-center px-7 py-2.5 bg-violet-600 hover:bg-violet-700 text-white font-semibold rounded-lg shadow-sm transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                                >
                                    <svg id="submit-icon" class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                    </svg>
                                    <span id="submit-text">{{ __('Send') }}</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Response Section -->
                <div class="xl:col-span-1">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-2xl border border-gray-200 dark:border-gray-700 sticky top-6">
                        <!-- Header -->
                        <div class="p-5 sm:p-6 border-b border-gray-200 dark:border-gray-700 bg-gray-50/80 dark:bg-gray-900/40">
                            <div class="flex items-center space-x-3">
                                <div class="w-11 h-11 bg-emerald-600 rounded-xl flex items-center justify-center shadow-sm">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('Last reply') }}</h3>
                                    <p class="text-xs text-gray-600 dark:text-gray-400">{{ __('Usage & raw API output') }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="p-5 sm:p-6">
                            <div id="response-container" class="min-h-[440px]">
                                <!-- Loading State -->
                                <div id="loading-indicator" class="hidden">
                                    <div class="flex flex-col items-center justify-center py-16">
                                        <div class="relative">
                                            <div class="w-16 h-16 border-4 border-violet-200 dark:border-violet-800 rounded-full"></div>
                                            <div class="w-16 h-16 border-4 border-violet-600 dark:border-violet-400 border-t-transparent rounded-full animate-spin absolute top-0 left-0"></div>
                                        </div>
                                        <p class="mt-6 text-sm font-medium text-gray-600 dark:text-gray-400 animate-pulse">Processing your request...</p>
                                        <p class="mt-2 text-xs text-gray-500 dark:text-gray-500">This may take a few seconds</p>
                                    </div>
                                </div>
                                
                                <!-- Error State -->
                                <div id="error-message" class="hidden">
                                    <div class="p-4 bg-gradient-to-br from-red-50 to-pink-50 dark:from-red-900/20 dark:to-pink-900/20 border-2 border-red-200 dark:border-red-800 rounded-2xl mb-4 animate-fade-in">
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0">
                                                <div class="w-10 h-10 bg-red-100 dark:bg-red-900/50 rounded-xl flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="ml-3 flex-1">
                                                <h4 class="text-sm font-bold text-red-800 dark:text-red-200 mb-1">Error Occurred</h4>
                                                <p id="error-text" class="text-sm text-red-700 dark:text-red-300"></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Success Response (preview of last assistant message) -->
                                <div id="response-content" class="hidden animate-fade-in">
                                    <div class="bg-gray-50 dark:bg-gray-900/50 rounded-xl p-4 border border-gray-200 dark:border-gray-700">
                                        <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">{{ __('Preview') }}</p>
                                        <div id="response-text" class="text-gray-800 dark:text-gray-200 whitespace-pre-wrap leading-relaxed text-sm font-medium max-h-48 overflow-y-auto"></div>
                                    </div>

                                    <div id="response-details" class="mt-5 pt-5 border-t border-gray-200 dark:border-gray-700">
                                        <div id="usage-info" class="mb-4 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-xl border border-blue-200 dark:border-blue-800">
                                            <div class="flex items-center space-x-2">
                                                <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                                </svg>
                                                <span id="usage-text" class="text-xs font-semibold text-blue-700 dark:text-blue-300"></span>
                                            </div>
                                        </div>
                                        
                                        <button 
                                            type="button" 
                                            id="toggle-details"
                                            class="w-full flex items-center justify-center px-4 py-2 text-xs font-semibold text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-xl transition-colors duration-200"
                                        >
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                            <span id="toggle-text">Show Raw Response</span>
                                        </button>
                                        <div id="raw-response" class="hidden mt-3 p-4 bg-gray-900 dark:bg-black rounded-xl border border-gray-700">
                                            <pre class="text-xs text-gray-300 overflow-auto max-h-64"><code id="raw-response-content" class="font-mono"></code></pre>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Empty State -->
                                <div id="empty-state" class="flex flex-col items-center justify-center py-16 text-center">
                                    <div class="w-20 h-20 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 rounded-3xl flex items-center justify-center mb-4 shadow-inner">
                                        <svg class="w-10 h-10 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                        </svg>
                                    </div>
                                    <p class="text-base font-semibold text-gray-600 dark:text-gray-400 mb-2">{{ __('No reply yet') }}</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-500 max-w-xs">{{ __('After you send a message, the latest assistant text, token usage, and raw JSON appear here.') }}</p>
                                </div>
                            </div>

                            <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                                <div class="flex items-center justify-between mb-3">
                                    <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-200">{{ __('Saved conversations') }}</h4>
                                    <button
                                        type="button"
                                        id="new-chat-btn"
                                        class="text-xs font-semibold text-violet-600 dark:text-violet-400 hover:text-violet-700 dark:hover:text-violet-300"
                                    >
                                        {{ __('New chat') }}
                                    </button>
                                </div>
                                <div id="conversation-list" class="space-y-2 max-h-72 overflow-y-auto pr-1">
                                    <p id="conversation-list-empty" class="text-xs text-gray-500 dark:text-gray-400">{{ __('No saved conversations yet.') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            <!-- /chatbot-form-view -->
        </div>
    </div>

    <style>
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fade-in 0.3s ease-out;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('chatbot-form');
            const promptInput = document.getElementById('prompt');
            const charCount = document.getElementById('char-count');
            const submitBtn = document.getElementById('submit-btn');
            const submitIcon = document.getElementById('submit-icon');
            const submitText = document.getElementById('submit-text');
            const clearBtn = document.getElementById('clear-btn');
            const loadingIndicator = document.getElementById('loading-indicator');
            const errorMessage = document.getElementById('error-message');
            const errorText = document.getElementById('error-text');
            const responseContent = document.getElementById('response-content');
            const responseText = document.getElementById('response-text');
            const emptyState = document.getElementById('empty-state');
            const toggleDetails = document.getElementById('toggle-details');
            const toggleText = document.getElementById('toggle-text');
            const rawResponse = document.getElementById('raw-response');
            const rawResponseContent = document.getElementById('raw-response-content');
            const conversationScroll = document.getElementById('conversation-scroll');
            const conversationHint = document.getElementById('conversation-hint');
            const conversationThread = document.getElementById('conversation-thread');
            const conversationIdInput = document.getElementById('conversation_id');
            const modelSelect = document.getElementById('model_id');
            const systemPromptInput = document.getElementById('system_prompt');
            const conversationList = document.getElementById('conversation-list');
            const conversationListEmpty = document.getElementById('conversation-list-empty');
            const newChatBtn = document.getElementById('new-chat-btn');

            const sendLabel = @json(__('Send'));
            const sendingLabel = @json(__('Sending…'));
            const thinkingLabel = @json(__('Thinking…'));
            const showRawLabel = @json(__('Show Raw Response'));
            const hideRawLabel = @json(__('Hide Raw Response'));
            const resumeLabel = @json(__('Resume'));
            const untitledLabel = @json(__('Untitled chat'));
            const nowLabel = @json(__('Just now'));
            @php
                $savedConversationsData = $conversations->map(function ($conversation) {
                    return [
                        'id' => $conversation->id,
                        'title' => $conversation->title,
                        'model_id' => $conversation->model_id,
                        'system_prompt' => $conversation->system_prompt,
                        'last_message_at' => optional($conversation->last_message_at)->toIso8601String(),
                        'latest_preview' => optional($conversation->latestMessage)->content,
                        'messages' => $conversation->messages
                            ->sortBy('id')
                            ->map(function ($message) {
                                return [
                                    'role' => $message->role,
                                    'content' => $message->content,
                                ];
                            })
                            ->values()
                            ->all(),
                    ];
                })->values()->all();
            @endphp
            const savedConversations = @json($savedConversationsData);

            /** @type { { role: string, content: string }[] } */
            let conversationHistory = [];
            let pendingUserRow = null;
            let typingRow = null;
            let currentConversationId = null;
            const conversationStore = new Map(savedConversations.map((item) => [item.id, item]));

            function syncThreadVisibility() {
                const has = conversationThread.children.length > 0;
                conversationHint.classList.toggle('hidden', has);
                conversationThread.classList.toggle('hidden', !has);
            }

            function scrollConversationToBottom() {
                conversationScroll.scrollTop = conversationScroll.scrollHeight;
            }

            function appendBubble(role, text) {
                const wrap = document.createElement('div');
                wrap.className = role === 'user' ? 'flex justify-end animate-fade-in' : 'flex justify-start animate-fade-in';
                const bubble = document.createElement('div');
                bubble.className = role === 'user'
                    ? 'max-w-[82%] rounded-2xl rounded-br-md px-4 py-3 bg-violet-600 text-white shadow-sm whitespace-pre-wrap text-sm font-medium leading-relaxed'
                    : 'max-w-[82%] rounded-2xl rounded-bl-md px-4 py-3 bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-800 dark:text-gray-200 shadow-sm whitespace-pre-wrap text-sm leading-relaxed';
                bubble.textContent = text;
                wrap.appendChild(bubble);
                conversationThread.appendChild(wrap);
                syncThreadVisibility();
                scrollConversationToBottom();
                return wrap;
            }

            function appendTypingRow() {
                const wrap = document.createElement('div');
                wrap.className = 'flex justify-start animate-fade-in';
                wrap.dataset.typing = '1';
                const bubble = document.createElement('div');
                bubble.className = 'rounded-2xl rounded-bl-md px-4 py-3 bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-300 text-sm italic';
                bubble.textContent = thinkingLabel;
                wrap.appendChild(bubble);
                conversationThread.appendChild(wrap);
                scrollConversationToBottom();
                return wrap;
            }

            function removeTypingRow() {
                if (typingRow && typingRow.parentNode) {
                    typingRow.remove();
                }
                typingRow = null;
            }

            function updateCharCount() {
                const count = promptInput.value.length;
                charCount.textContent = count.toLocaleString();
                if (count > 5000) {
                    charCount.classList.remove('text-gray-400', 'dark:text-gray-500');
                    charCount.classList.add('text-red-600', 'dark:text-red-400', 'animate-pulse');
                } else if (count > 4500) {
                    charCount.classList.remove('text-gray-400', 'dark:text-gray-500', 'text-red-600', 'dark:text-red-400');
                    charCount.classList.add('text-yellow-600', 'dark:text-yellow-400');
                } else {
                    charCount.classList.remove('text-red-600', 'dark:text-red-400', 'text-yellow-600', 'dark:text-yellow-400', 'animate-pulse');
                    charCount.classList.add('text-gray-400', 'dark:text-gray-500');
                }
            }

            function formatListTime(iso) {
                if (!iso) {
                    return nowLabel;
                }
                const date = new Date(iso);
                if (Number.isNaN(date.getTime())) {
                    return nowLabel;
                }
                return date.toLocaleString([], {
                    month: 'short',
                    day: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit',
                });
            }

            function escapeHtml(value) {
                return String(value)
                    .replaceAll('&', '&amp;')
                    .replaceAll('<', '&lt;')
                    .replaceAll('>', '&gt;')
                    .replaceAll('"', '&quot;')
                    .replaceAll("'", '&#039;');
            }

            function renderConversationList() {
                const ordered = Array.from(conversationStore.values()).sort((a, b) => {
                    const aTime = a.last_message_at ? Date.parse(a.last_message_at) : 0;
                    const bTime = b.last_message_at ? Date.parse(b.last_message_at) : 0;
                    return bTime - aTime || b.id - a.id;
                });

                conversationList.innerHTML = '';
                if (ordered.length === 0) {
                    conversationList.appendChild(conversationListEmpty);
                    conversationListEmpty.classList.remove('hidden');
                    return;
                }
                conversationListEmpty.classList.add('hidden');

                ordered.forEach((item) => {
                    const button = document.createElement('button');
                    button.type = 'button';
                    button.dataset.id = String(item.id);
                    button.className = 'w-full text-left p-3 rounded-xl border transition-colors ' + (
                        currentConversationId === item.id
                            ? 'border-violet-400 bg-violet-50 dark:bg-violet-900/20 dark:border-violet-500'
                            : 'border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/40'
                    );

                    const title = item.title && item.title.trim() ? item.title : untitledLabel;
                    const preview = item.latest_preview && item.latest_preview.trim()
                        ? item.latest_preview
                        : resumeLabel;

                    button.innerHTML =
                        '<div class="flex items-start justify-between gap-2">' +
                        '<p class="text-sm font-semibold text-gray-800 dark:text-gray-200 line-clamp-1">' + escapeHtml(title) + '</p>' +
                        '<span class="text-[10px] text-gray-500 dark:text-gray-400 shrink-0">' + formatListTime(item.last_message_at) + '</span>' +
                        '</div>' +
                        '<p class="mt-1 text-xs text-gray-500 dark:text-gray-400 line-clamp-2">' + escapeHtml(preview) + '</p>';

                    button.addEventListener('click', function() {
                        loadConversation(item.id);
                    });
                    conversationList.appendChild(button);
                });
            }

            function resetComposerAndSidebar() {
                promptInput.value = '';
                updateCharCount();
                errorMessage.classList.add('hidden');
                responseContent.classList.add('hidden');
                emptyState.classList.remove('hidden');
                document.getElementById('usage-info').classList.add('hidden');
                rawResponse.classList.add('hidden');
                toggleText.textContent = showRawLabel;
                responseText.textContent = '';
                rawResponseContent.textContent = '';
            }

            function renderConversationThreadFromHistory() {
                conversationThread.innerHTML = '';
                conversationHistory.forEach((message) => {
                    appendBubble(message.role, message.content);
                });
                syncThreadVisibility();
            }

            function loadConversation(id) {
                const selected = conversationStore.get(id);
                if (!selected) {
                    return;
                }
                currentConversationId = selected.id;
                conversationIdInput.value = String(selected.id);
                if (selected.system_prompt !== null && selected.system_prompt !== undefined) {
                    systemPromptInput.value = selected.system_prompt;
                }
                if (selected.model_id) {
                    modelSelect.value = String(selected.model_id);
                }

                conversationHistory = Array.isArray(selected.messages) ? selected.messages.slice() : [];
                renderConversationThreadFromHistory();

                const lastAssistant = [...conversationHistory].reverse().find((msg) => msg.role === 'assistant');
                if (lastAssistant) {
                    responseText.textContent = lastAssistant.content;
                    responseContent.classList.remove('hidden');
                    emptyState.classList.add('hidden');
                } else {
                    responseContent.classList.add('hidden');
                    emptyState.classList.remove('hidden');
                }
                renderConversationList();
            }

            function startNewConversation(resetSystemPrompt = false) {
                currentConversationId = null;
                conversationIdInput.value = '';
                conversationHistory = [];
                conversationThread.innerHTML = '';
                pendingUserRow = null;
                typingRow = null;
                if (resetSystemPrompt) {
                    systemPromptInput.value = '';
                }
                syncThreadVisibility();
                resetComposerAndSidebar();
                renderConversationList();
            }

            promptInput.addEventListener('input', updateCharCount);

            promptInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    if (!submitBtn.disabled) {
                        form.requestSubmit();
                    }
                }
            });

            form.addEventListener('submit', async function(e) {
                e.preventDefault();

                const prompt = promptInput.value.trim();
                if (!prompt) {
                    return;
                }

                loadingIndicator.classList.remove('hidden');
                errorMessage.classList.add('hidden');
                responseContent.classList.add('hidden');
                emptyState.classList.add('hidden');
                submitBtn.disabled = true;
                submitText.textContent = sendingLabel;
                submitIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>';

                pendingUserRow = appendBubble('user', prompt);
                typingRow = appendTypingRow();
                promptInput.value = '';
                updateCharCount();

                try {
                    const systemPrompt = document.getElementById('system_prompt').value.trim();
                    const modelId = document.getElementById('model_id').value;
                    const formData = new FormData();
                    formData.append('prompt', prompt);
                    formData.append('conversation', JSON.stringify(conversationHistory));
                    if (conversationIdInput.value) {
                        formData.append('conversation_id', conversationIdInput.value);
                    }
                    if (systemPrompt) {
                        formData.append('system_prompt', systemPrompt);
                    }
                    if (modelId) {
                        formData.append('model_id', modelId);
                    }
                    formData.append('_token', '{{ csrf_token() }}');

                    const response = await fetch('{{ route("chatbot.test.submit") }}', {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        },
                        body: formData
                    });

                    const data = await response.json();

                    loadingIndicator.classList.add('hidden');
                    submitBtn.disabled = false;
                    submitText.textContent = sendLabel;
                    submitIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>';
                    removeTypingRow();

                    if (data.success) {
                        const responseTextContent = data.response || JSON.stringify(data.raw, null, 2);
                        conversationHistory.push({ role: 'user', content: prompt });
                        conversationHistory.push({ role: 'assistant', content: responseTextContent });
                        appendBubble('assistant', responseTextContent);

                        if (data.conversation_id) {
                            currentConversationId = Number(data.conversation_id);
                            conversationIdInput.value = String(data.conversation_id);
                        }
                        if (currentConversationId) {
                            const existing = conversationStore.get(currentConversationId) || { id: currentConversationId, messages: [] };
                            const updatedMessages = conversationHistory.slice();
                            conversationStore.set(currentConversationId, {
                                ...existing,
                                id: currentConversationId,
                                title: data.conversation_title || existing.title || prompt.slice(0, 90),
                                model_id: modelSelect.value ? Number(modelSelect.value) : existing.model_id,
                                system_prompt: systemPromptInput.value || existing.system_prompt || '',
                                last_message_at: new Date().toISOString(),
                                latest_preview: responseTextContent,
                                messages: updatedMessages,
                            });
                            renderConversationList();
                        }

                        responseText.textContent = responseTextContent;
                        rawResponseContent.textContent = JSON.stringify(data.raw, null, 2);
                        const usageInfo = document.getElementById('usage-info');
                        const usageText = document.getElementById('usage-text');
                        if (data.usage) {
                            const usage = data.usage;
                            usageText.textContent = 'Tokens: ' + (usage.prompt_tokens || 0).toLocaleString() + ' prompt + ' + (usage.completion_tokens || 0).toLocaleString() + ' completion = ' + (usage.total_tokens || 0).toLocaleString() + ' total';
                            usageInfo.classList.remove('hidden');
                        } else {
                            usageInfo.classList.add('hidden');
                        }
                        responseContent.classList.remove('hidden');
                        rawResponse.classList.add('hidden');
                        toggleText.textContent = showRawLabel;
                        pendingUserRow = null;
                        scrollConversationToBottom();
                    } else {
                        if (pendingUserRow && pendingUserRow.parentNode) {
                            pendingUserRow.remove();
                        }
                        pendingUserRow = null;
                        promptInput.value = prompt;
                        updateCharCount();
                        errorMessage.classList.remove('hidden');
                        responseContent.classList.add('hidden');
                        emptyState.classList.add('hidden');
                        errorText.textContent = data.error || data.message || 'An error occurred';
                        rawResponseContent.textContent = JSON.stringify(data, null, 2);
                        syncThreadVisibility();
                    }
                } catch (error) {
                    loadingIndicator.classList.add('hidden');
                    submitBtn.disabled = false;
                    submitText.textContent = sendLabel;
                    submitIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>';
                    removeTypingRow();
                    if (pendingUserRow && pendingUserRow.parentNode) {
                        pendingUserRow.remove();
                    }
                    pendingUserRow = null;
                    promptInput.value = prompt;
                    updateCharCount();
                    errorMessage.classList.remove('hidden');
                    responseContent.classList.add('hidden');
                    emptyState.classList.add('hidden');
                    errorText.textContent = 'Network error: ' + error.message;
                    syncThreadVisibility();
                }
            });

            clearBtn.addEventListener('click', function() {
                startNewConversation(true);
            });

            toggleDetails.addEventListener('click', function() {
                const isHidden = rawResponse.classList.contains('hidden');
                rawResponse.classList.toggle('hidden');
                toggleText.textContent = isHidden ? hideRawLabel : showRawLabel;
            });

            newChatBtn.addEventListener('click', function() {
                startNewConversation(false);
            });

            renderConversationList();
            syncThreadVisibility();
        });
    </script>
</x-app-layout>
