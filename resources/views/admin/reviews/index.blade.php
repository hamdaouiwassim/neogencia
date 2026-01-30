<x-app-layout>
    <x-slot name="header">
        @include('admin.partials.header', ['title' => __('Manage Reviews'), 'subtitle' => __('Moderate and filter user reviews')])
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @include('admin.partials.alerts')

            <!-- Filters -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-2xl rounded-3xl border border-gray-200/50 dark:border-gray-700/50 p-6">
                <form method="GET" action="{{ route('admin.reviews') }}" class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search reviews..."
                               class="w-full rounded-xl border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all">
                    </div>
                    <div>
                        <select name="rating" class="rounded-xl border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 min-w-[140px]">
                            <option value="all">All Ratings</option>
                            <option value="5" {{ request('rating') === '5' ? 'selected' : '' }}>5 Stars</option>
                            <option value="4" {{ request('rating') === '4' ? 'selected' : '' }}>4 Stars</option>
                            <option value="3" {{ request('rating') === '3' ? 'selected' : '' }}>3 Stars</option>
                            <option value="2" {{ request('rating') === '2' ? 'selected' : '' }}>2 Stars</option>
                            <option value="1" {{ request('rating') === '1' ? 'selected' : '' }}>1 Star</option>
                        </select>
                    </div>
                    <button type="submit" class="inline-flex items-center bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 px-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                        </svg>
                        Filter
                    </button>
                    <a href="{{ route('admin.reviews') }}" class="inline-flex items-center bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 font-semibold py-2.5 px-6 rounded-xl border-2 border-gray-200 dark:border-gray-600 transition-all duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Clear
                    </a>
                </form>
            </div>

            <!-- Reviews List -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-2xl rounded-3xl border border-gray-200/50 dark:border-gray-700/50">
                <div class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($reviews as $review)
                        <div class="p-6 hover:bg-gray-50/80 dark:hover:bg-gray-700/80 transition-colors">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-3 mb-2">
                                        <div class="h-10 w-10 rounded-full bg-gradient-to-r from-indigo-500 to-purple-500 flex items-center justify-center text-white font-semibold">
                                            {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="font-semibold text-gray-900 dark:text-white">{{ $review->user->name }}</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ $review->created_at->diffForHumans() }}</div>
                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        <a href="{{ route('agents.show', $review->agent) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 font-medium">
                                            {{ $review->agent->name }}
                                        </a>
                                    </div>
                                    <div class="flex items-center space-x-1 mb-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-5 h-5 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600' }}" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                            </svg>
                                        @endfor
                                        <span class="ml-2 text-sm text-gray-500 dark:text-gray-400">{{ $review->rating }}/5</span>
                                    </div>
                                    @if($review->comment)
                                        <p class="text-gray-700 dark:text-gray-300 mt-2">{{ $review->comment }}</p>
                                    @endif
                                </div>
                                <div>
                                    <form method="POST" action="{{ route('admin.reviews.delete', $review) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this review? This action cannot be undone.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white text-xs font-semibold rounded-lg shadow-sm hover:shadow-md transition-all duration-200">
                                            <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-6 text-center text-gray-500 dark:text-gray-400">No reviews found.</div>
                    @endforelse
                </div>
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/50 rounded-b-3xl">
                    {{ $reviews->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
