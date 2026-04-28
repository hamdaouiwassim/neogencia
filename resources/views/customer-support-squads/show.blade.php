<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ $customerSupportSquad->name }}</h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $customerSupportSquad->description ?: __('Test support response quality using multiple AI roles.') }}</p>
            </div>
            <div class="flex items-center gap-2">
                @if(Auth::user()->isAdmin())
                    <a href="{{ route('customer-support-squads.edit', $customerSupportSquad) }}" class="inline-flex items-center px-4 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 font-semibold rounded-xl transition-all">{{ __('Edit') }}</a>
                @endif
                <a href="{{ route('customer-support-squads.index') }}" class="inline-flex items-center text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">{{ __('Back') }}</a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @include('admin.partials.alerts')

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-2xl border border-gray-200 dark:border-gray-700 p-6" id="test-form-view">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">{{ __('Run Support Test') }}</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">{{ __('Enter a customer message and optional context. Each role in the squad will respond.') }}</p>

                <form id="support-test-form" class="space-y-4">
                    @csrf
                    <div>
                        <label for="customer_message" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Customer message') }} *</label>
                        <textarea name="customer_message" id="customer_message" rows="5" required class="w-full rounded-xl border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all" placeholder="{{ __('Customer writes here...') }}"></textarea>
                    </div>
                    <div>
                        <label for="customer_context" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Customer context') }} ({{ __('optional') }})</label>
                        <textarea name="customer_context" id="customer_context" rows="3" class="w-full rounded-xl border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all"></textarea>
                    </div>
                    <div>
                        <label for="policy_context" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Policy / knowledge base') }} ({{ __('optional') }})</label>
                        <textarea name="policy_context" id="policy_context" rows="3" class="w-full rounded-xl border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all"></textarea>
                    </div>
                    <button type="submit" id="run-test-btn" class="w-full inline-flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-6 rounded-xl shadow-sm transition-colors">
                        <span id="run-test-text">{{ __('Run Test') }}</span>
                    </button>
                </form>
            </div>

            <div id="results-view" class="hidden space-y-4">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-2xl border border-gray-200 dark:border-gray-700 p-6">
                    <div class="flex flex-wrap items-start justify-between gap-4 mb-6">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ __('Support Test Results') }}</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1" id="results-preview"></p>
                        </div>
                        <button onclick="resetSupportTest()" class="inline-flex items-center px-4 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 font-semibold rounded-xl transition-all">{{ __('New Test') }}</button>
                    </div>
                    <div id="results-summary" class="hidden grid grid-cols-1 sm:grid-cols-3 gap-3 mb-6"></div>
                    <div id="results-container" class="space-y-5"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const testUrl = '{{ route("customer-support-squads.test", $customerSupportSquad) }}';

        function escapeHtml(text) {
            return String(text ?? '')
                .replaceAll('&', '&amp;')
                .replaceAll('<', '&lt;')
                .replaceAll('>', '&gt;')
                .replaceAll('"', '&quot;')
                .replaceAll("'", '&#039;');
        }

        function copySquadResult(button) {
            const card = button.closest('[data-squad-card]');
            const el = card && card.querySelector('[data-response-text]');
            if (!el || !navigator.clipboard) return;
            navigator.clipboard.writeText(el.textContent.trim()).then(function () {
                const prev = button.getAttribute('data-label') || button.textContent;
                button.textContent = '{{ __('Copied') }}';
                setTimeout(function () { button.textContent = prev; }, 2000);
            });
        }

        document.getElementById('support-test-form').addEventListener('submit', async function (e) {
            e.preventDefault();

            const formView = document.getElementById('test-form-view');
            const resultsView = document.getElementById('results-view');
            const runBtn = document.getElementById('run-test-btn');
            const runText = document.getElementById('run-test-text');
            const resultsContainer = document.getElementById('results-container');
            const resultsSummary = document.getElementById('results-summary');
            const resultsPreview = document.getElementById('results-preview');

            runBtn.disabled = true;
            runText.textContent = '{{ __('Running...') }}';
            resultsSummary.classList.add('hidden');
            resultsSummary.innerHTML = '';
            if (resultsPreview) resultsPreview.textContent = '';
            resultsContainer.innerHTML = '<div class="text-center py-10"><div class="inline-block h-9 w-9 animate-spin rounded-full border-2 border-indigo-600 border-t-transparent"></div><p class="mt-4 text-sm text-gray-600 dark:text-gray-400">{{ __('Running all roles…') }}</p></div>';

            try {
                const formData = new FormData();
                formData.append('customer_message', document.getElementById('customer_message').value);
                formData.append('customer_context', document.getElementById('customer_context').value);
                formData.append('policy_context', document.getElementById('policy_context').value);
                formData.append('_token', '{{ csrf_token() }}');

                const response = await fetch(testUrl, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    },
                    body: formData,
                });

                const data = await response.json();
                if (!data.success) {
                    alert(data.error || 'Test failed');
                    return;
                }

                resultsContainer.innerHTML = '';
                const successCount = data.results.filter(function (r) { return r.success; }).length;
                const errorCount = data.results.length - successCount;
                const totalTokens = data.results.reduce(function (sum, r) { return sum + (r.usage && r.usage.total_tokens ? r.usage.total_tokens : 0); }, 0);

                if (resultsPreview) {
                    const msg = document.getElementById('customer_message').value.trim();
                    const short = msg.length > 120 ? msg.slice(0, 117) + '…' : msg;
                    resultsPreview.textContent = short ? '{{ __('Customer message') }}: ' + short : '';
                }

                resultsSummary.innerHTML = `
                    <div class="rounded-2xl border border-emerald-200/80 dark:border-emerald-800/60 bg-gradient-to-br from-emerald-50 to-white dark:from-emerald-950/40 dark:to-gray-900/40 p-4 shadow-sm">
                        <p class="text-[11px] uppercase tracking-wider text-emerald-600 dark:text-emerald-400 font-bold">{{ __('Successful') }}</p>
                        <p class="mt-1 text-3xl font-extrabold tabular-nums text-emerald-800 dark:text-emerald-200">${successCount}</p>
                        <p class="mt-1 text-xs text-emerald-700/80 dark:text-emerald-300/80">{{ __('Roles completed') }}</p>
                    </div>
                    <div class="rounded-2xl border border-amber-200/80 dark:border-amber-800/60 bg-gradient-to-br from-amber-50 to-white dark:from-amber-950/40 dark:to-gray-900/40 p-4 shadow-sm">
                        <p class="text-[11px] uppercase tracking-wider text-amber-600 dark:text-amber-400 font-bold">{{ __('Needs review') }}</p>
                        <p class="mt-1 text-3xl font-extrabold tabular-nums text-amber-800 dark:text-amber-200">${errorCount}</p>
                        <p class="mt-1 text-xs text-amber-800/70 dark:text-amber-200/70">{{ __('Errors or empty responses') }}</p>
                    </div>
                    <div class="rounded-2xl border border-indigo-200/80 dark:border-indigo-800/60 bg-gradient-to-br from-indigo-50 to-white dark:from-indigo-950/40 dark:to-gray-900/40 p-4 shadow-sm">
                        <p class="text-[11px] uppercase tracking-wider text-indigo-600 dark:text-indigo-400 font-bold">{{ __('Tokens') }}</p>
                        <p class="mt-1 text-3xl font-extrabold tabular-nums text-indigo-800 dark:text-indigo-200">${totalTokens.toLocaleString()}</p>
                        <p class="mt-1 text-xs text-indigo-700/80 dark:text-indigo-300/80">{{ __('Total reported usage') }}</p>
                    </div>
                `;
                resultsSummary.classList.remove('hidden');

                data.results.forEach(function (result, index) {
                    const card = document.createElement('article');
                    card.setAttribute('data-squad-card', '');
                    const step = index + 1;
                    if (result.success) {
                        card.className = 'overflow-hidden rounded-2xl border border-gray-200/90 dark:border-gray-600/80 bg-white dark:bg-gray-800/40 shadow-sm ring-1 ring-black/[0.03] dark:ring-white/[0.04]';
                        card.innerHTML = `
                            <div class="flex flex-wrap items-center gap-3 px-4 py-3.5 bg-gradient-to-r from-teal-50 via-white to-cyan-50/80 dark:from-teal-950/50 dark:via-gray-900/80 dark:to-cyan-950/40 border-b border-gray-200/80 dark:border-gray-700/80">
                                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-teal-600 to-cyan-600 text-sm font-bold text-white shadow-md">${step}</span>
                                <div class="min-w-0 flex-1">
                                    <h4 class="text-base font-bold text-gray-900 dark:text-white leading-tight">${escapeHtml(result.task_role_name)}</h4>
                                    <p class="mt-0.5 text-xs text-gray-600 dark:text-gray-400">
                                        <span class="inline-flex items-center rounded-md bg-white/80 dark:bg-gray-800/80 px-2 py-0.5 font-medium text-gray-700 dark:text-gray-300 ring-1 ring-gray-200/80 dark:ring-gray-600">${escapeHtml(result.model_name)}</span>
                                    </p>
                                </div>
                                <span class="shrink-0 inline-flex items-center gap-1 rounded-full bg-emerald-100 dark:bg-emerald-900/50 px-2.5 py-1 text-xs font-bold text-emerald-800 dark:text-emerald-200 ring-1 ring-emerald-200/80 dark:ring-emerald-800/60">
                                    <svg class="h-3.5 w-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                    {{ __('OK') }}
                                </span>
                                <button type="button" data-label="{{ __('Copy') }}" onclick="copySquadResult(this)" class="shrink-0 rounded-lg border border-gray-300/80 dark:border-gray-600 bg-white/90 dark:bg-gray-800 px-3 py-1.5 text-xs font-semibold text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">{{ __('Copy') }}</button>
                            </div>
                            <div class="px-4 py-3">
                                <p class="text-[11px] font-semibold uppercase tracking-wider text-teal-700 dark:text-teal-400 mb-2">{{ __('Suggested reply') }}</p>
                                <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/80 dark:bg-gray-950/50">
                                    <div data-response-text class="max-h-[min(28rem,55vh)] overflow-y-auto overscroll-contain px-4 py-3 text-sm leading-relaxed text-gray-800 dark:text-gray-200 whitespace-pre-wrap font-sans">${escapeHtml(result.response)}</div>
                                </div>
                                ${result.usage ? `<div class="mt-3 flex flex-wrap gap-3 text-[11px] text-gray-500 dark:text-gray-400">
                                    <span class="rounded-md bg-gray-100 dark:bg-gray-900/60 px-2 py-1">{{ __('In') }} <strong class="text-gray-700 dark:text-gray-300">${(result.usage.prompt_tokens || 0).toLocaleString()}</strong></span>
                                    <span class="rounded-md bg-gray-100 dark:bg-gray-900/60 px-2 py-1">{{ __('Out') }} <strong class="text-gray-700 dark:text-gray-300">${(result.usage.completion_tokens || 0).toLocaleString()}</strong></span>
                                    <span class="rounded-md bg-gray-100 dark:bg-gray-900/60 px-2 py-1">{{ __('Total') }} <strong class="text-gray-700 dark:text-gray-300">${(result.usage.total_tokens || 0).toLocaleString()}</strong></span>
                                </div>` : ''}
                            </div>
                        `;
                    } else {
                        card.className = 'overflow-hidden rounded-2xl border border-red-200/90 dark:border-red-900/50 bg-white dark:bg-gray-800/40 shadow-sm';
                        card.innerHTML = `
                            <div class="flex flex-wrap items-center gap-3 px-4 py-3.5 bg-gradient-to-r from-red-50 to-white dark:from-red-950/40 dark:to-gray-900/80 border-b border-red-100 dark:border-red-900/40">
                                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-red-600 text-sm font-bold text-white shadow-md">${step}</span>
                                <div class="min-w-0 flex-1">
                                    <h4 class="text-base font-bold text-gray-900 dark:text-white">${escapeHtml(result.task_role_name)}</h4>
                                    <p class="mt-0.5 text-xs text-gray-600 dark:text-gray-400"><span class="font-medium">${escapeHtml(result.model_name || '—')}</span></p>
                                </div>
                                <span class="shrink-0 rounded-full bg-red-100 dark:bg-red-900/40 px-2.5 py-1 text-xs font-bold text-red-800 dark:text-red-200">{{ __('Failed') }}</span>
                            </div>
                            <div class="px-4 py-4">
                                <div class="rounded-xl border border-red-200/80 dark:border-red-900/50 bg-red-50/50 dark:bg-red-950/20 px-4 py-3 text-sm text-red-800 dark:text-red-200">
                                    <p class="font-semibold">${escapeHtml(result.error || 'Unknown error')}</p>
                                    ${result.message ? `<p class="mt-2 text-xs opacity-90 whitespace-pre-wrap">${escapeHtml(result.message)}</p>` : ''}
                                </div>
                            </div>
                        `;
                    }
                    resultsContainer.appendChild(card);
                });

                formView.classList.add('hidden');
                resultsView.classList.remove('hidden');
            } catch (error) {
                alert('Failed to run test: ' + error.message);
            } finally {
                runBtn.disabled = false;
                runText.textContent = '{{ __('Run Test') }}';
            }
        });

        function resetSupportTest() {
            document.getElementById('test-form-view').classList.remove('hidden');
            document.getElementById('results-view').classList.add('hidden');
            const rs = document.getElementById('results-summary');
            if (rs) {
                rs.classList.add('hidden');
                rs.innerHTML = '';
            }
            const rp = document.getElementById('results-preview');
            if (rp) rp.textContent = '';
            document.getElementById('support-test-form').reset();
        }
    </script>
</x-app-layout>
