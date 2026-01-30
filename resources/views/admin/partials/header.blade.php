<div class="flex items-center justify-between flex-wrap gap-4">
    <div class="flex items-center space-x-3">
        <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
            </svg>
        </div>
        <div>
            <h2 class="font-bold text-2xl text-gray-900 dark:text-white">
                {{ $title ?? __('Administration') }}
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">{{ $subtitle ?? __('Manage your platform') }}</p>
        </div>
    </div>
    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-4 py-2.5 bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 hover:border-indigo-500 dark:hover:border-indigo-500 text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 font-semibold rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Back to Dashboard
    </a>
</div>
