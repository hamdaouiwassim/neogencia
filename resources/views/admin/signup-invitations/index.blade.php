<x-app-layout>
    <x-slot name="header">
        @include('admin.partials.header', [
            'title' => __('Signup invitations'),
            'subtitle' => __('Create links for new users. Each link is single-use.'),
        ])
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @include('admin.partials.alerts')

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-2xl rounded-3xl border border-gray-200/50 dark:border-gray-700/50 p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('New invitation') }}</h2>
                <form method="POST" action="{{ route('admin.signup-invitations.store') }}" class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                    @csrf
                    <div class="md:col-span-5">
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Email (optional)') }}</label>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            value="{{ old('email') }}"
                            placeholder="{{ __('Any email; leave blank for open invite') }}"
                            class="w-full rounded-xl border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all"
                        />
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">{{ __('If set, signup must use exactly this address.') }}</p>
                    </div>
                    <div class="md:col-span-3">
                        <label for="expires_in_days" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Expires in (days)') }}</label>
                        <input
                            type="number"
                            name="expires_in_days"
                            id="expires_in_days"
                            min="1"
                            max="365"
                            value="{{ old('expires_in_days') }}"
                            placeholder="{{ __('No expiry if empty') }}"
                            class="w-full rounded-xl border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all"
                        />
                    </div>
                    <div class="md:col-span-4 flex gap-2">
                        <button type="submit" class="inline-flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 px-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 w-full md:w-auto">
                            {{ __('Generate link') }}
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-2xl rounded-3xl border border-gray-200/50 dark:border-gray-700/50">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">{{ __('Status') }}</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">{{ __('Email lock') }}</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">{{ __('Expires') }}</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">{{ __('Created by') }}</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">{{ __('Link') }}</th>
                                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($invitations as $invitation)
                                @php
                                    $consumable = $invitation->isConsumable();
                                    $expired = $invitation->expires_at && $invitation->expires_at->isPast() && ! $invitation->used_at;
                                @endphp
                                <tr class="hover:bg-gray-50/80 dark:hover:bg-gray-700/80 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @if($invitation->used_at)
                                            <span class="inline-flex px-2 py-0.5 rounded-lg text-xs font-medium bg-gray-200 text-gray-800 dark:bg-gray-600 dark:text-gray-100">{{ __('Used') }}</span>
                                        @elseif($expired)
                                            <span class="inline-flex px-2 py-0.5 rounded-lg text-xs font-medium bg-amber-100 text-amber-900 dark:bg-amber-900/40 dark:text-amber-200">{{ __('Expired') }}</span>
                                        @else
                                            <span class="inline-flex px-2 py-0.5 rounded-lg text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-200">{{ __('Active') }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">
                                        {{ $invitation->email ?? '—' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">
                                        {{ $invitation->expires_at ? $invitation->expires_at->timezone(config('app.timezone'))->format('M j, Y g:i A') : __('Never') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                                        {{ $invitation->inviter?->name ?? '—' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        @if($consumable)
                                            <button
                                                type="button"
                                                data-copy-url="{{ $invitation->registrationUrl() }}"
                                                class="copy-invite-url inline-flex items-center text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 font-medium"
                                            >
                                                <svg class="w-4 h-4 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                                </svg>
                                                <span class="copy-invite-label">{{ __('Copy') }}</span>
                                            </button>
                                        @else
                                            <span class="text-gray-400 dark:text-gray-500">—</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                        <form method="POST" action="{{ route('admin.signup-invitations.destroy', $invitation) }}" class="inline" onsubmit="return confirm(@json(__('Delete this invitation?')))">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 font-medium">
                                                {{ __('Delete') }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                        {{ __('No invitations yet. Create one above.') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($invitations->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                        {{ $invitations->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.copy-invite-url').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var url = btn.getAttribute('data-copy-url');
                var label = btn.querySelector('.copy-invite-label');
                if (!label || !navigator.clipboard || !url) return;
                var prev = label.textContent;
                navigator.clipboard.writeText(url).then(function () {
                    label.textContent = @json(__('Copied!'));
                    setTimeout(function () { label.textContent = prev; }, 2000);
                });
            });
        });
    </script>
</x-app-layout>
