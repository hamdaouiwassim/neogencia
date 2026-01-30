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

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Form view (visible by default) -->
            <div id="chatbot-form-view">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Input Section -->
                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-2xl sm:rounded-3xl border border-gray-200/50 dark:border-gray-700/50 backdrop-blur-sm">
                        <!-- Header -->
                        <div class="relative p-6 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-br from-violet-50 via-purple-50 to-indigo-50 dark:from-violet-900/30 dark:via-purple-900/30 dark:to-indigo-900/30 overflow-hidden">
                            <div class="absolute inset-0 bg-grid-pattern opacity-5"></div>
                            <div class="relative flex items-center space-x-4">
                                <div class="w-14 h-14 bg-gradient-to-br from-violet-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-xl transform hover:scale-105 transition-transform duration-200">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Chat with AI</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 flex items-center mt-1">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                        </svg>
                                        Powered by AICC API
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <form id="chatbot-form" class="p-6 space-y-6">
                            @csrf
                            
                            <!-- Model Select -->
                            <div class="group">
                                <label for="model_id" class="flex items-center justify-between mb-2">
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
                                    class="block w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-900/50 dark:text-gray-300 focus:border-violet-500 dark:focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20 dark:focus:ring-violet-500/30 shadow-sm transition-all duration-200 font-medium"
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
                                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400 flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Choose the model to use for this request. Admins can add models in Chatbot Models.
                                </p>
                            </div>
                            
                            <!-- System Prompt -->
                            <div class="group">
                                <label for="system_prompt" class="flex items-center justify-between mb-2">
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
                                    class="block w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-900/50 dark:text-gray-300 focus:border-violet-500 dark:focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20 dark:focus:ring-violet-500/30 shadow-sm transition-all duration-200 resize-none font-medium"
                                    placeholder="You are a helpful AI assistant. Be descriptive and helpful."
                                ></textarea>
                                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400 flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Define the AI's role and behavior
                                </p>
                            </div>
                            
                            <!-- User Prompt -->
                            <div class="group">
                                <label for="prompt" class="flex items-center justify-between mb-2">
                                    <span class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                        <span class="inline-flex items-center">
                                            <svg class="w-4 h-4 mr-1.5 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                            Your Prompt
                                        </span>
                                    </span>
                                    <span class="text-xs text-red-500 font-medium">Required</span>
                                </label>
                                <div class="relative">
                                    <textarea 
                                        id="prompt" 
                                        name="prompt" 
                                        rows="8" 
                                        class="block w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-900/50 dark:text-gray-300 focus:border-violet-500 dark:focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20 dark:focus:ring-violet-500/30 shadow-sm transition-all duration-200 resize-none font-medium placeholder-gray-400"
                                        placeholder="Type your message here...&#10;&#10;Examples:&#10;• What is artificial intelligence?&#10;• Explain machine learning in simple terms&#10;• Write a short story about space exploration"
                                        required
                                    ></textarea>
                                    <div class="absolute bottom-3 right-3 flex items-center space-x-2">
                                        <div id="char-count" class="text-xs font-semibold text-gray-400 dark:text-gray-500 bg-white/80 dark:bg-gray-800/80 px-2 py-1 rounded-md backdrop-blur-sm">
                                            0
                                        </div>
                                        <span class="text-xs text-gray-300 dark:text-gray-600">/ 5000</span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-700">
                                <button 
                                    type="button" 
                                    id="clear-btn"
                                    class="inline-flex items-center px-5 py-2.5 text-sm font-semibold text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-xl shadow-md hover:shadow-lg transition-all duration-200 transform hover:scale-105 active:scale-95"
                                >
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    Clear All
                                </button>
                                
                                <button 
                                    type="submit" 
                                    id="submit-btn"
                                    class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-violet-600 via-purple-600 to-indigo-600 hover:from-violet-700 hover:via-purple-700 hover:to-indigo-700 text-white font-bold rounded-xl shadow-xl hover:shadow-2xl transition-all duration-200 transform hover:scale-105 active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none"
                                >
                                    <svg id="submit-icon" class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                    </svg>
                                    <span id="submit-text">Send Message</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Response Section -->
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-2xl sm:rounded-3xl border border-gray-200/50 dark:border-gray-700/50 backdrop-blur-sm sticky top-6">
                        <!-- Header -->
                        <div class="relative p-6 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-br from-emerald-50 via-teal-50 to-cyan-50 dark:from-emerald-900/30 dark:via-teal-900/30 dark:to-cyan-900/30 overflow-hidden">
                            <div class="absolute inset-0 bg-grid-pattern opacity-5"></div>
                            <div class="relative flex items-center space-x-4">
                                <div class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl flex items-center justify-center shadow-xl">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">AI Response</h3>
                                    <p class="text-xs text-gray-600 dark:text-gray-400">Chatbot reply</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="p-6">
                            <div id="response-container" class="min-h-[500px]">
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
                                
                                <!-- Success Response -->
                                <div id="response-content" class="hidden animate-fade-in">
                                    <div class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900/50 dark:to-gray-800/50 rounded-2xl p-5 border border-gray-200 dark:border-gray-700">
                                        <div id="response-text" class="text-gray-800 dark:text-gray-200 whitespace-pre-wrap leading-relaxed text-sm font-medium"></div>
                                    </div>
                                    
                                    <div id="response-details" class="mt-5 pt-5 border-t border-gray-200 dark:border-gray-700">
                                        <div id="usage-info" class="mb-4 p-3 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-xl border border-blue-200 dark:border-blue-800">
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
                                    <p class="text-base font-semibold text-gray-600 dark:text-gray-400 mb-2">Ready to Chat</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-500 max-w-xs">Enter your prompt and click Send Message to get started</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            <!-- /chatbot-form-view -->

            <!-- Full-page result view (hidden until success) -->
            <div id="chatbot-result-view" class="hidden">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-2xl sm:rounded-3xl border border-gray-200/50 dark:border-gray-700/50 backdrop-blur-sm">
                    <div class="p-6 sm:p-8 lg:p-10">
                        <!-- Your prompt -->
                        <div class="mb-8">
                            <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Your prompt</p>
                            <div class="bg-gray-50 dark:bg-gray-900/50 rounded-2xl p-5 border border-gray-200 dark:border-gray-700">
                                <p id="fullpage-prompt" class="text-gray-800 dark:text-gray-200 whitespace-pre-wrap leading-relaxed"></p>
                            </div>
                        </div>
                        <!-- AI Response -->
                        <div class="mb-8">
                            <div class="flex items-center space-x-3 mb-4">
                                <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl flex items-center justify-center shadow-lg">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">AI Response</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Chatbot reply</p>
                                </div>
                            </div>
                            <div class="bg-gradient-to-br from-emerald-50 via-teal-50 to-cyan-50 dark:from-emerald-900/20 dark:via-teal-900/20 dark:to-cyan-900/20 rounded-2xl p-6 sm:p-8 border-2 border-emerald-200 dark:border-emerald-800">
                                <div id="fullpage-response" class="text-gray-800 dark:text-gray-200 whitespace-pre-wrap leading-relaxed text-base sm:text-lg"></div>
                            </div>
                        </div>
                        <!-- Usage & Raw -->
                        <div class="flex flex-wrap items-center gap-4 mb-8">
                            <div id="fullpage-usage" class="hidden px-4 py-2 bg-blue-100 dark:bg-blue-900/30 rounded-xl border border-blue-200 dark:border-blue-800">
                                <span id="fullpage-usage-text" class="text-sm font-semibold text-blue-700 dark:text-blue-300"></span>
                            </div>
                            <button type="button" id="fullpage-toggle-raw" class="px-4 py-2 text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-xl transition-colors">
                                <span id="fullpage-toggle-text">Show Raw Response</span>
                            </button>
                        </div>
                        <div id="fullpage-raw" class="hidden mb-8 p-4 bg-gray-900 dark:bg-black rounded-xl border border-gray-700">
                            <pre class="text-xs text-gray-300 overflow-auto max-h-80"><code id="fullpage-raw-content" class="font-mono"></code></pre>
                        </div>
                        <!-- Try another prompt -->
                        <div class="pt-6 border-t border-gray-200 dark:border-gray-700 flex justify-center">
                            <button type="button" id="try-another-btn" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-violet-600 via-purple-600 to-indigo-600 hover:from-violet-700 hover:via-purple-700 hover:to-indigo-700 text-white font-bold text-lg rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-200 transform hover:scale-105 active:scale-95">
                                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                Try another prompt
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /chatbot-result-view -->

            <!-- API Configuration Info (show only when form view is visible) -->
            <div id="api-config-info" class="mt-8">
            <div class="mt-8 bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 dark:from-blue-900/20 dark:via-indigo-900/20 dark:to-purple-900/20 border-2 border-blue-200 dark:border-blue-800 rounded-3xl p-6 shadow-lg">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4 flex-1">
                        <h4 class="text-lg font-bold text-blue-900 dark:text-blue-200 mb-2">API Configuration</h4>
                        <p class="text-sm text-blue-800 dark:text-blue-300 mb-4">
                            Configure the AICC API by adding these variables to your <code class="bg-blue-100 dark:bg-blue-900 px-2 py-1 rounded-md font-mono text-xs">.env</code> file:
                        </p>
                        <div class="bg-blue-100 dark:bg-blue-900/50 p-4 rounded-xl border border-blue-200 dark:border-blue-800 mb-4">
                            <code class="text-xs text-blue-900 dark:text-blue-100 font-mono leading-relaxed block">
                                CHATBOT_BASE_URL=https://api.ai.cc/v1<br>
                                CHATBOT_API_KEY=&lt;YOUR_AICCAPI_KEY&gt;<br>
                                CHATBOT_MODEL=mistralai/Mistral-7B-Instruct-v0.2<br>
                                CHATBOT_TEMPERATURE=0.7<br>
                                CHATBOT_MAX_TOKENS=256
                            </code>
                        </div>
                        <div class="flex items-start space-x-2 text-xs">
                            <svg class="w-4 h-4 text-blue-600 dark:text-blue-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-blue-700 dark:text-blue-400">
                                <strong class="font-semibold">Required:</strong> <code class="bg-blue-100 dark:bg-blue-900 px-1.5 py-0.5 rounded font-mono">CHATBOT_API_KEY</code> - Your AICC API key<br>
                                <strong class="font-semibold">Optional:</strong> Other variables have defaults and can be customized
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            <!-- /api-config-info -->
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
        .bg-grid-pattern {
            background-image: 
                linear-gradient(to right, rgba(0,0,0,0.05) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(0,0,0,0.05) 1px, transparent 1px);
            background-size: 20px 20px;
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

            // Character counter
            promptInput.addEventListener('input', function() {
                const count = this.value.length;
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
            });

            // Form submission
            form.addEventListener('submit', async function(e) {
                e.preventDefault();
                
                const prompt = promptInput.value.trim();
                if (!prompt) {
                    return;
                }

                // Show loading state
                loadingIndicator.classList.remove('hidden');
                errorMessage.classList.add('hidden');
                responseContent.classList.add('hidden');
                emptyState.classList.add('hidden');
                submitBtn.disabled = true;
                submitText.textContent = 'Sending...';
                submitIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>';

                try {
                    const systemPrompt = document.getElementById('system_prompt').value.trim();
                    const modelId = document.getElementById('model_id').value;
                    const formData = new FormData();
                    formData.append('prompt', prompt);
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
                    
                    // Hide loading
                    loadingIndicator.classList.add('hidden');
                    submitBtn.disabled = false;
                    submitText.textContent = 'Send Message';
                    submitIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>';

                    if (data.success) {
                        // Populate full-page result
                        const responseTextContent = data.response || JSON.stringify(data.raw, null, 2);
                        document.getElementById('fullpage-prompt').textContent = prompt;
                        document.getElementById('fullpage-response').textContent = responseTextContent;
                        document.getElementById('fullpage-raw-content').textContent = JSON.stringify(data.raw, null, 2);
                        
                        const fullpageUsage = document.getElementById('fullpage-usage');
                        const fullpageUsageText = document.getElementById('fullpage-usage-text');
                        if (data.usage) {
                            const usage = data.usage;
                            fullpageUsageText.textContent = `Tokens: ${(usage.prompt_tokens || 0).toLocaleString()} prompt + ${(usage.completion_tokens || 0).toLocaleString()} completion = ${(usage.total_tokens || 0).toLocaleString()} total`;
                            fullpageUsage.classList.remove('hidden');
                        } else {
                            fullpageUsage.classList.add('hidden');
                        }
                        
                        // Also update sidebar (for consistency) and hide raw by default on full page
                        responseText.textContent = responseTextContent;
                        rawResponseContent.textContent = JSON.stringify(data.raw, null, 2);
                        const usageInfo = document.getElementById('usage-info');
                        const usageText = document.getElementById('usage-text');
                        if (data.usage) {
                            const usage = data.usage;
                            usageText.textContent = `Tokens: ${(usage.prompt_tokens || 0).toLocaleString()} prompt + ${(usage.completion_tokens || 0).toLocaleString()} completion = ${(usage.total_tokens || 0).toLocaleString()} total`;
                            usageInfo.classList.remove('hidden');
                        } else {
                            usageInfo.classList.add('hidden');
                        }
                        
                        // Switch to full-page result view
                        document.getElementById('chatbot-form-view').classList.add('hidden');
                        document.getElementById('api-config-info').classList.add('hidden');
                        document.getElementById('chatbot-result-view').classList.remove('hidden');
                        document.getElementById('fullpage-raw').classList.add('hidden');
                        document.getElementById('fullpage-toggle-text').textContent = 'Show Raw Response';
                        
                        // Scroll to top of result
                        document.getElementById('chatbot-result-view').scrollIntoView({ behavior: 'smooth', block: 'start' });
                    } else {
                        // Show error
                        errorMessage.classList.remove('hidden');
                        responseContent.classList.add('hidden');
                        emptyState.classList.add('hidden');
                        errorText.textContent = data.error || data.message || 'An error occurred';
                        rawResponseContent.textContent = JSON.stringify(data, null, 2);
                    }
                } catch (error) {
                    // Hide loading
                    loadingIndicator.classList.add('hidden');
                    submitBtn.disabled = false;
                    submitText.textContent = 'Send Message';
                    submitIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>';

                    // Show error
                    errorMessage.classList.remove('hidden');
                    responseContent.classList.add('hidden');
                    emptyState.classList.add('hidden');
                    errorText.textContent = 'Network error: ' + error.message;
                }
            });

            // Clear button
            clearBtn.addEventListener('click', function() {
                document.getElementById('system_prompt').value = '';
                promptInput.value = '';
                charCount.textContent = '0';
                charCount.classList.remove('text-red-600', 'dark:text-red-400', 'text-yellow-600', 'dark:text-yellow-400', 'animate-pulse');
                charCount.classList.add('text-gray-400', 'dark:text-gray-500');
                errorMessage.classList.add('hidden');
                responseContent.classList.add('hidden');
                emptyState.classList.remove('hidden');
                document.getElementById('usage-info').classList.add('hidden');
            });

            // Toggle raw response (sidebar)
            toggleDetails.addEventListener('click', function() {
                const isHidden = rawResponse.classList.contains('hidden');
                rawResponse.classList.toggle('hidden');
                toggleText.textContent = isHidden ? 'Hide Raw Response' : 'Show Raw Response';
            });

            // Full-page: toggle raw response
            document.getElementById('fullpage-toggle-raw').addEventListener('click', function() {
                const rawEl = document.getElementById('fullpage-raw');
                const isHidden = rawEl.classList.contains('hidden');
                rawEl.classList.toggle('hidden');
                document.getElementById('fullpage-toggle-text').textContent = isHidden ? 'Hide Raw Response' : 'Show Raw Response';
            });

            // Try another prompt: show form view again
            document.getElementById('try-another-btn').addEventListener('click', function() {
                document.getElementById('chatbot-result-view').classList.add('hidden');
                document.getElementById('chatbot-form-view').classList.remove('hidden');
                document.getElementById('api-config-info').classList.remove('hidden');
                // Reset sidebar state to empty
                document.getElementById('system_prompt').value = '';
                promptInput.value = '';
                charCount.textContent = '0';
                charCount.classList.remove('text-red-600', 'dark:text-red-400', 'text-yellow-600', 'dark:text-yellow-400', 'animate-pulse');
                charCount.classList.add('text-gray-400', 'dark:text-gray-500');
                errorMessage.classList.add('hidden');
                responseContent.classList.add('hidden');
                emptyState.classList.remove('hidden');
                document.getElementById('usage-info').classList.add('hidden');
                rawResponse.classList.add('hidden');
                toggleText.textContent = 'Show Raw Response';
                // Scroll to form
                document.getElementById('chatbot-form-view').scrollIntoView({ behavior: 'smooth', block: 'start' });
            });
        });
    </script>
</x-app-layout>
