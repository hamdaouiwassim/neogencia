<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('home') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <div>
                    <nav class="flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400 mb-1">
                        <a href="{{ route('home') }}" class="hover:text-gray-900 dark:hover:text-white transition-colors">Home</a>
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-gray-900 dark:text-white font-medium">{{ $agent->name }}</span>
                    </nav>
                    <h2 class="font-bold text-2xl text-gray-900 dark:text-white leading-tight">
                        {{ $agent->name }}
                    </h2>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-gradient-to-r from-indigo-500 to-purple-500 text-white">
                    {{ $agent->category->name }}
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-8 md:py-12">
        <div class="max-w-7xl mx-auto sm:px-4 lg:px-8">
            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-6 mx-auto max-w-4xl bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-200 px-4 py-3 rounded-lg shadow-sm">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-8 space-y-6">
                    <!-- Agent Details -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-2xl sm:rounded-3xl border border-gray-200 dark:border-gray-700">
                        @if($agent->featured_image)
                            <div class="w-full h-64 md:h-[500px] bg-gray-200 dark:bg-gray-700 overflow-hidden relative group">
                                <img src="{{ $agent->featured_image }}" alt="{{ $agent->name }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent"></div>
                                @if($agent->is_featured)
                                    <div class="absolute top-4 right-4 z-10">
                                        <span class="bg-gradient-to-r from-indigo-500 to-purple-500 text-white text-xs font-bold px-4 py-2 rounded-full shadow-lg flex items-center space-x-1">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                            </svg>
                                            <span>Featured</span>
                                        </span>
                                    </div>
                                @endif
                                <!-- Stats Overlay -->
                                <div class="absolute bottom-4 left-4 right-4 flex items-center justify-between text-white">
                                    <div class="flex items-center space-x-4">
                                        <div class="flex items-center space-x-1 bg-black/40 backdrop-blur-sm px-3 py-1.5 rounded-lg">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span class="text-sm font-semibold">{{ number_format($agent->views) }}</span>
                                        </div>
                                        <div class="flex items-center space-x-1 bg-black/40 backdrop-blur-sm px-3 py-1.5 rounded-lg">
                                            <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                            </svg>
                                            <span class="text-sm font-semibold">{{ number_format($agent->averageRating(), 1) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="p-6 md:p-10 text-gray-900 dark:text-gray-100">
                            <!-- Header Section with Stats -->
                            <div class="mb-8 pb-8 border-b border-gray-200 dark:border-gray-700">
                                <div class="flex flex-col md:flex-row md:items-start md:justify-between mb-6 gap-4">
                                    <div class="flex-1">
                                        <div class="flex items-center flex-wrap gap-3 mb-4">
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full
                                                {{ $agent->pricing_type === 'free' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : '' }}
                                                {{ $agent->pricing_type === 'paid' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : '' }}
                                                {{ $agent->pricing_type === 'freemium' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' : '' }}">
                                                {{ ucfirst($agent->pricing_type) }}
                                            </span>
                                            @if($agent->price > 0)
                                                <div class="flex items-baseline space-x-1">
                                                    <span class="text-3xl font-extrabold text-gray-900 dark:text-white">${{ number_format($agent->price, 2) }}</span>
                                                    <span class="text-sm text-gray-500 dark:text-gray-400">USD</span>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <!-- Stats Grid -->
                                        <div class="grid grid-cols-3 gap-4 mt-4 p-4 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-700/50 dark:to-gray-800/50 rounded-xl">
                                            <div class="text-center">
                                                <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($agent->averageRating(), 1) }}</div>
                                                <div class="text-xs text-gray-600 dark:text-gray-400 mt-1">Rating</div>
                                            </div>
                                            <div class="text-center border-x border-gray-200 dark:border-gray-600">
                                                <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $agent->reviewsCount() }}</div>
                                                <div class="text-xs text-gray-600 dark:text-gray-400 mt-1">Reviews</div>
                                            </div>
                                            <div class="text-center">
                                                <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($agent->views) }}</div>
                                                <div class="text-xs text-gray-600 dark:text-gray-400 mt-1">Views</div>
                                            </div>
                                        </div>
                                        
                                        <div class="flex items-center flex-wrap gap-4 text-sm text-gray-600 dark:text-gray-400 mt-4">
                                            <span class="flex items-center">
                                                <svg class="w-5 h-5 mr-1.5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                </svg>
                                                <span class="font-semibold text-gray-900 dark:text-white">{{ number_format($agent->averageRating(), 1) }}</span>
                                                <span class="ml-1">({{ $agent->reviewsCount() }} reviews)</span>
                                            </span>
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                                {{ $agent->created_at->format('M d, Y') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Description Section -->
                            <div class="mb-8">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    About
                                </h3>
                                <div class="prose prose-lg dark:prose-invert max-w-none">
                                    <p class="text-gray-700 dark:text-gray-300 leading-relaxed whitespace-pre-line text-base">{{ $agent->description }}</p>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex flex-wrap gap-4 mb-8 pb-8 border-b border-gray-200 dark:border-gray-700">
                                <a href="{{ $agent->link }}" target="_blank" class="group inline-flex items-center bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold py-3 px-8 rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105">
                                    <svg class="w-5 h-5 mr-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                    </svg>
                                    Visit Agent
                                </a>
                                @if($agent->documentation)
                                    <a href="{{ $agent->documentation }}" target="_blank" class="inline-flex items-center bg-gray-800 hover:bg-gray-900 dark:bg-gray-700 dark:hover:bg-gray-600 text-white font-semibold py-3 px-6 rounded-lg shadow-lg hover:shadow-xl transition-all duration-200">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                        </svg>
                                        Documentation
                                    </a>
                                @endif
                                <button onclick="navigator.share({title: '{{ $agent->name }}', text: '{{ Str::limit($agent->description, 100) }}', url: window.location.href})" class="inline-flex items-center bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-900 dark:text-white font-semibold py-3 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
                                    </svg>
                                    Share
                                </button>
                            </div>

                            <!-- Creator & Meta Info -->
                            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                                <div class="flex items-center space-x-4">
                                    <div class="h-12 w-12 rounded-full bg-gradient-to-r from-indigo-500 to-purple-500 flex items-center justify-center text-white font-bold shadow-lg">
                                        {{ substr($agent->user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white">Created by {{ $agent->user->name }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{{ $agent->created_at->format('F d, Y') }} • {{ $agent->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-4 text-sm text-gray-600 dark:text-gray-400">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                        </svg>
                                        {{ $agent->category->name }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Reviews Section -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-2xl sm:rounded-3xl border border-gray-200 dark:border-gray-700">
                        <div class="p-6 md:p-10">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 pb-6 border-b border-gray-200 dark:border-gray-700 gap-4">
                        <div>
                            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Reviews & Ratings</h2>
                            <p class="text-gray-600 dark:text-gray-400">{{ $agent->reviewsCount() }} {{ Str::plural('review', $agent->reviewsCount()) }} from the community</p>
                        </div>
                        <div class="flex items-center space-x-3 bg-gradient-to-r from-yellow-50 to-amber-50 dark:from-yellow-900/20 dark:to-amber-900/20 px-6 py-4 rounded-xl border border-yellow-200 dark:border-yellow-800">
                            <div class="flex flex-col items-center">
                                <div class="flex items-center space-x-1">
                                    <svg class="w-8 h-8 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                    <span class="text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($agent->averageRating(), 1) }}</span>
                                </div>
                                <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">Average Rating</p>
                            </div>
                        </div>
                    </div>

                    <!-- Review Form -->
                    @auth
                        <div class="mb-10 p-6 md:p-8 bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50 dark:from-gray-700 dark:via-gray-700 dark:to-gray-800 rounded-2xl border-2 border-indigo-200 dark:border-gray-600">
                            <div class="flex items-center space-x-2 mb-6">
                                <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                </svg>
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white">Share Your Experience</h3>
                            </div>
                            <form method="POST" action="{{ route('reviews.store', $agent) }}" class="space-y-4">
                                @csrf
                                <div>
                                    <label for="rating" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Rating</label>
                                    <select id="rating" name="rating" class="block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600" required>
                                        <option value="">Select rating</option>
                                        <option value="5">5 - Excellent</option>
                                        <option value="4">4 - Very Good</option>
                                        <option value="3">3 - Good</option>
                                        <option value="2">2 - Fair</option>
                                        <option value="1">1 - Poor</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('rating')" class="mt-2" />
                                </div>
                                <div>
                                    <label for="comment" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Comment (Optional)</label>
                                    <textarea id="comment" name="comment" rows="3" class="block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600" placeholder="Share your experience...">{{ old('comment') }}</textarea>
                                    <x-input-error :messages="$errors->get('comment')" class="mt-2" />
                                </div>
                                <button type="submit" class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold py-3 px-6 rounded-lg shadow-lg hover:shadow-xl transition-all duration-200">
                                    Submit Review
                                </button>
                            </form>
                        </div>
                    @else
                        <p class="text-gray-600 dark:text-gray-400 mb-6">
                            <a href="{{ route('login') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">Login</a> to write a review.
                        </p>
                    @endauth

                    <!-- Reviews List -->
                    <div class="space-y-6">
                        @forelse($agent->reviews as $review)
                            <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-6 border border-gray-200 dark:border-gray-600">
                                <div class="flex items-start space-x-4">
                                    <div class="h-12 w-12 rounded-full bg-gradient-to-r from-indigo-500 to-purple-500 flex items-center justify-center text-white font-bold flex-shrink-0">
                                        {{ substr($review->user->name, 0, 1) }}
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between mb-2">
                                            <div>
                                                <h4 class="font-semibold text-gray-900 dark:text-white">{{ $review->user->name }}</h4>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $review->created_at->diffForHumans() }}</p>
                                            </div>
                                            <div class="flex items-center space-x-1">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <svg class="w-5 h-5 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600' }}" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                    </svg>
                                                @endfor
                                            </div>
                                        </div>
                                        @if($review->comment)
                                            <p class="text-gray-700 dark:text-gray-300 mt-3 leading-relaxed">{{ $review->comment }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-12">
                                <svg class="mx-auto h-16 w-16 text-gray-400 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                </svg>
                                <p class="text-gray-500 dark:text-gray-400 text-lg">No reviews yet. Be the first to review!</p>
                            </div>
                        @endforelse
                        </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-4 space-y-6">
                    <!-- Sticky Container -->
                    <div class="lg:sticky lg:top-6 space-y-6">
                    <!-- Quick Info Card -->
                    <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 overflow-hidden shadow-2xl sm:rounded-3xl border border-gray-200 dark:border-gray-700 p-6">
                        <div class="flex items-center space-x-2 mb-6">
                            <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Quick Info</h3>
                        </div>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Category</span>
                                <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $agent->category->name }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Pricing</span>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full
                                    {{ $agent->pricing_type === 'free' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : '' }}
                                    {{ $agent->pricing_type === 'paid' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : '' }}
                                    {{ $agent->pricing_type === 'freemium' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' : '' }}">
                                    {{ ucfirst($agent->pricing_type) }}
                                </span>
                            </div>
                            @if($agent->price > 0)
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">Price</span>
                                    <span class="text-lg font-bold text-gray-900 dark:text-white">${{ number_format($agent->price, 2) }}</span>
                                </div>
                            @endif
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Views</span>
                                <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ number_format($agent->views) }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Rating</span>
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-yellow-400 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                    <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ number_format($agent->averageRating(), 1) }}</span>
                                    <span class="text-xs text-gray-500 dark:text-gray-400 ml-1">({{ $agent->reviewsCount() }})</span>
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Created</span>
                                <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $agent->created_at->format('M Y') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Creator Info -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-2xl sm:rounded-3xl border border-gray-200 dark:border-gray-700 p-6">
                        <div class="flex items-center space-x-2 mb-6">
                            <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Creator</h3>
                        </div>
                        <div class="flex items-center space-x-4 p-5 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-700/50 dark:to-gray-800/50 rounded-xl border border-gray-200 dark:border-gray-600">
                            <div class="h-14 w-14 rounded-full bg-gradient-to-r from-indigo-500 to-purple-500 flex items-center justify-center text-white font-bold text-xl shadow-lg">
                                {{ substr($agent->user->name, 0, 1) }}
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-gray-900 dark:text-white text-lg">{{ $agent->user->name }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $agent->user->role === 'creator' ? 'Agent Creator' : 'Community Member' }}</p>
                                @php
                                    $userAgentCount = $agent->user->agents()->count();
                                @endphp
                                @if($userAgentCount > 1)
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $userAgentCount }} agents shared</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Related Agents -->
                    @php
                        $relatedAgents = App\Models\Agent::where('category_id', $agent->category_id)
                            ->where('id', '!=', $agent->id)
                            ->with(['category', 'reviews'])
                            ->orderBy('views', 'desc')
                            ->limit(3)
                            ->get();
                    @endphp
                    @if($relatedAgents->count() > 0)
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-2xl sm:rounded-3xl border border-gray-200 dark:border-gray-700 p-6">
                            <div class="flex items-center space-x-2 mb-6">
                                <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Related Agents</h3>
                            </div>
                            <div class="space-y-4">
                                @foreach($relatedAgents as $related)
                                    <a href="{{ route('agents.show', $related) }}" class="block group">
                                        <div class="flex items-center space-x-3 p-4 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-all duration-200 border border-transparent hover:border-gray-200 dark:hover:border-gray-600">
                                            @if($related->featured_image)
                                                <img src="{{ $related->featured_image }}" alt="{{ $related->name }}" class="h-16 w-16 rounded-lg object-cover">
                                            @else
                                                <div class="h-16 w-16 rounded-lg bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-semibold text-gray-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 truncate">
                                                    {{ $related->name }}
                                                </p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $related->category->name }}</p>
                                                <div class="flex items-center mt-1">
                                                    <svg class="w-3 h-3 text-yellow-400 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                    </svg>
                                                    <span class="text-xs text-gray-500 dark:text-gray-400">{{ number_format($related->averageRating(), 1) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
