@if(session('success'))
    <div class="mb-6 flex items-center p-4 rounded-2xl bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 border-2 border-green-200 dark:border-green-800 shadow-lg">
        <div class="flex-shrink-0 w-10 h-10 bg-green-500 rounded-xl flex items-center justify-center mr-3">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>
        <p class="text-green-800 dark:text-green-200 font-medium">{{ session('success') }}</p>
    </div>
@endif

@if($errors->any())
    <div class="mb-6 flex items-start p-4 rounded-2xl bg-gradient-to-r from-red-50 to-pink-50 dark:from-red-900/20 dark:to-pink-900/20 border-2 border-red-200 dark:border-red-800 shadow-lg">
        <div class="flex-shrink-0 w-10 h-10 bg-red-500 rounded-xl flex items-center justify-center mr-3">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <div class="flex-1">
            <p class="text-red-800 dark:text-red-200 font-semibold mb-1">Please fix the following:</p>
            <ul class="list-disc list-inside text-sm text-red-700 dark:text-red-300 space-y-0.5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
