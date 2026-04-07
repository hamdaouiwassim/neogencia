<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ $seoSquad->name }}
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $seoSquad->description ?: 'Turn one URL brief into a prioritized SEO action plan.' }}</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('seo-squads.edit', $seoSquad) }}" class="inline-flex items-center px-4 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 font-semibold rounded-xl transition-all">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit
                </a>
                <a href="{{ route('seo-squads.index') }}" class="inline-flex items-center text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @include('admin.partials.alerts')

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-5 shadow-sm">
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Specialist Roles</p>
                    <p class="mt-2 text-2xl font-bold text-gray-900 dark:text-white">{{ $seoSquad->squadModels->count() }}</p>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Coverage across technical, content, keyword, and strategy lenses.</p>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-5 shadow-sm">
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Decision Quality</p>
                    <p class="mt-2 text-lg font-semibold text-gray-900 dark:text-white">Cross-validated recommendations</p>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Compare multiple expert outputs before committing implementation time.</p>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-5 shadow-sm">
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Expected Outcome</p>
                    <p class="mt-2 text-lg font-semibold text-gray-900 dark:text-white">Faster prioritization</p>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Identify high-impact fixes, quick wins, and risks in one run.</p>
                </div>
            </div>

            <!-- Squad Info -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-2xl border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center justify-between flex-wrap gap-4 mb-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Squad Workflow</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Your models run in sequence to produce a complete SEO plan.</p>
                    </div>
                    <span class="text-xs px-3 py-1 rounded-full bg-indigo-50 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-800">
                        {{ $seoSquad->squadModels->count() }} Step{{ $seoSquad->squadModels->count() !== 1 ? 's' : '' }}
                    </span>
                </div>

                <div class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/30 p-4 sm:p-5">
                    <div class="overflow-x-auto">
                        <div class="min-w-[760px]">
                            <div class="relative flex items-stretch gap-4">
                                @foreach($seoSquad->squadModels->sortBy('sort_order')->values() as $index => $squadModel)
                                    <div class="relative flex-1 min-w-[220px]">
                                        <div class="h-full rounded-xl border-2 border-indigo-200 dark:border-indigo-800 bg-white dark:bg-gray-800 p-4 shadow-sm">
                                            <div class="flex items-center justify-between mb-3">
                                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-indigo-600 text-white text-xs font-bold">
                                                    {{ $index + 1 }}
                                                </span>
                                                <span class="text-[11px] px-2 py-1 rounded-md bg-indigo-50 dark:bg-indigo-900/30 border border-indigo-200 dark:border-indigo-700 text-indigo-700 dark:text-indigo-300">
                                                    {{ __('Node') }} {{ $index + 1 }}
                                                </span>
                                            </div>
                                            <h4 class="text-sm font-semibold text-gray-900 dark:text-white leading-snug">
                                                {{ $taskRoles[$squadModel->task_role] ?? $squadModel->task_role }}
                                            </h4>
                                            <p class="mt-2 text-xs text-gray-600 dark:text-gray-400">
                                                {{ __('Model:') }} {{ $squadModel->chatbotModel->name }}
                                            </p>
                                            <div class="mt-3 pt-3 border-t border-gray-100 dark:border-gray-700">
                                                <p class="text-[11px] uppercase tracking-wide text-gray-500 dark:text-gray-400">{{ __('Output') }}</p>
                                                <p class="text-xs text-gray-700 dark:text-gray-300 mt-1">
                                                    {{ __('Recommendations for this specialist role.') }}
                                                </p>
                                            </div>
                                        </div>

                                        @if(!$loop->last)
                                            <div class="hidden lg:flex absolute top-1/2 -right-3 transform -translate-y-1/2 items-center">
                                                <div class="w-6 border-t-2 border-dashed border-indigo-300 dark:border-indigo-700"></div>
                                                <svg class="w-4 h-4 text-indigo-400 dark:text-indigo-500 -ml-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <p class="mt-3 text-xs text-gray-500 dark:text-gray-400">
                        {{ __('Flow: each node contributes insights that feed into the next decision step.') }}
                    </p>
                </div>

                <div class="mt-4 rounded-xl border border-emerald-200 dark:border-emerald-800 bg-emerald-50 dark:bg-emerald-900/20 p-3">
                    <p class="text-sm text-emerald-800 dark:text-emerald-200">
                        <span class="font-semibold">Execution tip:</span>
                        Start with Step 1 output, then refine decisions using later steps for stronger prioritization.
                    </p>
                </div>
                <div class="mt-4">
                    @if(!$seoSquad->is_active)
                        <div class="px-4 py-2 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-xl">
                            <p class="text-sm text-yellow-800 dark:text-yellow-200 font-medium">This squad is inactive</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Analysis Form -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-2xl border border-gray-200 dark:border-gray-700 p-6" id="analysis-form-view">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">Run SEO Analysis</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Provide a URL, optional keywords/content, and get structured recommendations from each specialist role.</p>
                
                <form id="analysis-form" class="space-y-4">
                    @csrf
                    <div>
                        <label for="url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">URL to Analyze *</label>
                        <input type="url" name="url" id="url" required
                               class="w-full rounded-xl border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all"
                               placeholder="https://example.com/page">
                    </div>

                    <div>
                        <label for="target_keywords" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Target Keywords (Optional)</label>
                        <input type="text" name="target_keywords" id="target_keywords"
                               class="w-full rounded-xl border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all"
                               placeholder="keyword1, keyword2, keyword3">
                    </div>

                    <div>
                        <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Page Content (Optional)</label>
                        <textarea name="content" id="content" rows="6"
                                  class="w-full rounded-xl border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all"
                                  placeholder="Paste page content here for more accurate analysis"></textarea>
                    </div>

                    <button type="submit" id="analyze-btn" class="w-full inline-flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-6 rounded-xl shadow-sm transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        <span id="analyze-text">Run Analysis</span>
                    </button>
                </form>
            </div>

            <!-- Results View -->
            <div id="results-view" class="hidden space-y-4">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-2xl border border-gray-200 dark:border-gray-700 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white">Analysis Results</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1" id="results-url"></p>
                        </div>
                        <button onclick="resetAnalysis()" class="inline-flex items-center px-4 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 font-semibold rounded-xl transition-all">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            New Analysis
                        </button>
                    </div>

                    <div id="results-summary" class="hidden grid grid-cols-1 sm:grid-cols-3 gap-3 mb-5"></div>

                    <div id="results-container" class="space-y-4">
                        <!-- Results will be populated here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const analyzeUrl = '{{ route("seo-squads.analyze", $seoSquad) }}';
        const taskRoles = @json($taskRoles);

        function escapeHtml(text) {
            return String(text ?? '')
                .replaceAll('&', '&amp;')
                .replaceAll('<', '&lt;')
                .replaceAll('>', '&gt;')
                .replaceAll('"', '&quot;')
                .replaceAll("'", '&#039;');
        }

        document.getElementById('analysis-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formView = document.getElementById('analysis-form-view');
            const resultsView = document.getElementById('results-view');
            const analyzeBtn = document.getElementById('analyze-btn');
            const analyzeText = document.getElementById('analyze-text');
            const resultsContainer = document.getElementById('results-container');
            const resultsUrl = document.getElementById('results-url');
            const resultsSummary = document.getElementById('results-summary');
            
            const url = document.getElementById('url').value;
            const keywords = document.getElementById('target_keywords').value;
            const content = document.getElementById('content').value;

            // Show loading state
            analyzeBtn.disabled = true;
            analyzeText.textContent = 'Analyzing...';
            resultsSummary.classList.add('hidden');
            resultsSummary.innerHTML = '';
            resultsContainer.innerHTML = '<div class="text-center py-8"><div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-indigo-600"></div><p class="mt-4 text-gray-600 dark:text-gray-400">Running analysis with all models...</p></div>';

            try {
                const formData = new FormData();
                formData.append('url', url);
                if (keywords) formData.append('target_keywords', keywords);
                if (content) formData.append('content', content);
                formData.append('_token', '{{ csrf_token() }}');

                const response = await fetch(analyzeUrl, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                const data = await response.json();

                if (data.success) {
                    resultsUrl.textContent = `Analyzed: ${url}`;
                    resultsContainer.innerHTML = '';
                    const successCount = data.results.filter((result) => result.success).length;
                    const errorCount = data.results.length - successCount;
                    const totalTokens = data.results.reduce((sum, result) => sum + (result.usage?.total_tokens || 0), 0);

                    resultsSummary.innerHTML = `
                        <div class="rounded-xl border border-emerald-200 dark:border-emerald-900/40 bg-emerald-50 dark:bg-emerald-900/20 p-3">
                            <p class="text-xs uppercase tracking-wide text-emerald-700 dark:text-emerald-300 font-semibold">Successful Roles</p>
                            <p class="mt-1 text-2xl font-bold text-emerald-800 dark:text-emerald-200">${successCount}</p>
                        </div>
                        <div class="rounded-xl border border-amber-200 dark:border-amber-900/40 bg-amber-50 dark:bg-amber-900/20 p-3">
                            <p class="text-xs uppercase tracking-wide text-amber-700 dark:text-amber-300 font-semibold">Needs Review</p>
                            <p class="mt-1 text-2xl font-bold text-amber-800 dark:text-amber-200">${errorCount}</p>
                        </div>
                        <div class="rounded-xl border border-blue-200 dark:border-blue-900/40 bg-blue-50 dark:bg-blue-900/20 p-3">
                            <p class="text-xs uppercase tracking-wide text-blue-700 dark:text-blue-300 font-semibold">Token Spend</p>
                            <p class="mt-1 text-2xl font-bold text-blue-800 dark:text-blue-200">${totalTokens.toLocaleString()}</p>
                        </div>
                    `;
                    resultsSummary.classList.remove('hidden');

                    data.results.forEach((result, index) => {
                        const resultCard = document.createElement('div');
                        resultCard.className = 'bg-gray-50 dark:bg-gray-900/50 rounded-xl p-6 border border-gray-200 dark:border-gray-700';
                        
                        if (result.success) {
                            resultCard.innerHTML = `
                                <div class="flex items-start justify-between mb-4">
                                    <div>
                                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white">${escapeHtml(result.task_role_name)}</h4>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Model: ${escapeHtml(result.model_name)}</p>
                                    </div>
                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">Success</span>
                                </div>
                                <div class="mb-3 p-3 rounded-lg border border-indigo-200 dark:border-indigo-800 bg-indigo-50/60 dark:bg-indigo-900/20">
                                    <p class="text-xs font-semibold uppercase tracking-wide text-indigo-700 dark:text-indigo-300">How to use this output</p>
                                    <p class="text-sm text-indigo-900 dark:text-indigo-200 mt-1">Extract 2-3 actions from this role and combine with other role outputs into a prioritized sprint list.</p>
                                </div>
                                <div class="prose dark:prose-invert max-w-none">
                                    <div class="text-gray-700 dark:text-gray-300 whitespace-pre-wrap">${escapeHtml(result.response)}</div>
                                </div>
                                ${result.usage ? `<div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700 text-xs text-gray-500 dark:text-gray-400">
                                    Tokens: ${result.usage.prompt_tokens || 0} prompt + ${result.usage.completion_tokens || 0} completion = ${result.usage.total_tokens || 0} total
                                </div>` : ''}
                            `;
                        } else {
                            resultCard.innerHTML = `
                                <div class="flex items-start justify-between mb-4">
                                    <div>
                                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white">${escapeHtml(result.task_role_name)}</h4>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Model: ${escapeHtml(result.model_name)}</p>
                                    </div>
                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">Error</span>
                                </div>
                                <div class="text-red-600 dark:text-red-400">
                                    <p class="font-medium">${escapeHtml(result.error || 'Unknown error')}</p>
                                    ${result.message ? `<p class="text-sm mt-1">${escapeHtml(result.message)}</p>` : ''}
                                </div>
                            `;
                        }
                        
                        resultsContainer.appendChild(resultCard);
                    });

                    formView.classList.add('hidden');
                    resultsView.classList.remove('hidden');
                } else {
                    alert('Analysis failed: ' + (data.error || 'Unknown error'));
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Failed to run analysis: ' + error.message);
            } finally {
                analyzeBtn.disabled = false;
                analyzeText.textContent = 'Run Analysis';
            }
        });

        function resetAnalysis() {
            document.getElementById('analysis-form-view').classList.remove('hidden');
            document.getElementById('results-view').classList.add('hidden');
            document.getElementById('results-summary').classList.add('hidden');
            document.getElementById('results-summary').innerHTML = '';
            document.getElementById('analysis-form').reset();
        }
    </script>
</x-app-layout>
