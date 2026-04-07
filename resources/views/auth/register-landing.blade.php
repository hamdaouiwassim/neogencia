<x-guest-layout :title="__('Invitation only')" :subtitle="__('New accounts are created with a link from an administrator.')">
    <div class="space-y-6 text-center">
        <div class="rounded-2xl border border-indigo-100 dark:border-indigo-900/40 bg-indigo-50/80 dark:bg-indigo-950/30 px-5 py-6">
            <p class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed">
                {{ __('If you were invited to join, open the signup link you received by email or message. Each link works once and may expire.') }}
            </p>
        </div>

        <div class="pt-2 space-y-3">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                {{ __('Already have an account?') }}
            </p>
            <a
                href="{{ route('login') }}"
                class="inline-flex w-full justify-center items-center rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold py-3 px-4 shadow-lg hover:shadow-xl transition-all duration-200"
            >
                {{ __('Sign in') }}
            </a>
        </div>
    </div>
</x-guest-layout>
