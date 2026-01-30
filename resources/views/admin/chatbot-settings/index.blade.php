<x-app-layout>
    <x-slot name="header">
        @include('admin.partials.header', ['title' => __('Chatbot Settings'), 'subtitle' => __('API URL, key, and generation parameters')])
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @include('admin.partials.alerts')

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-2xl rounded-3xl border border-gray-200/50 dark:border-gray-700/50 p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Configure the AICC API parameters used by the Chatbot Test page. These override values from <code class="bg-gray-100 dark:bg-gray-700 px-1.5 py-0.5 rounded-lg text-xs">.env</code> when set.
                    </p>
                </div>

                <form method="POST" action="{{ route('admin.chatbot-settings.update') }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="base_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">API Base URL</label>
                        <input type="url" name="base_url" id="base_url" value="{{ old('base_url', $settings->base_url) }}" required
                               class="w-full rounded-xl border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 font-mono text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all"
                               placeholder="https://api.ai.cc/v1">
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Base URL for the chat completions API (e.g. https://api.ai.cc/v1)</p>
                    </div>

                    <div>
                        <label for="api_key" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">API Key</label>
                        <input type="password" name="api_key" id="api_key" value=""
                               class="w-full rounded-xl border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 font-mono text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all"
                               placeholder="Leave blank to keep current key"
                               autocomplete="off">
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Your AICC API key. Leave blank to keep the existing value.</p>
                        @if($settings->api_key)
                            <p class="mt-1 text-xs text-green-600 dark:text-green-400">A key is currently set (hidden for security).</p>
                        @endif
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="temperature" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Temperature</label>
                            <input type="number" name="temperature" id="temperature" value="{{ old('temperature', $settings->temperature) }}" required
                                   min="0" max="2" step="0.01"
                                   class="w-full rounded-xl border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all">
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">0–2. Higher = more random. Typical: 0.7</p>
                        </div>
                        <div>
                            <label for="max_tokens" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Max Tokens</label>
                            <input type="number" name="max_tokens" id="max_tokens" value="{{ old('max_tokens', $settings->max_tokens) }}" required
                                   min="1" max="4096"
                                   class="w-full rounded-xl border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all">
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Maximum response length (1–4096)</p>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-200 dark:border-gray-700 flex flex-wrap items-center gap-3">
                        <button type="submit" class="inline-flex items-center bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 px-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Save Settings
                        </button>
                        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-4 py-2.5 text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 font-semibold rounded-xl border-2 border-gray-200 dark:border-gray-600 transition-all duration-200">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
