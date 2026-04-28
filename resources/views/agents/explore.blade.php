<x-app-layout>
    <!-- Hero Section with AI Platform Image -->
    <div class="relative overflow-hidden py-20 md:py-32 min-h-[600px] md:min-h-[700px] flex items-center">
        <!-- Hero Background Image -->
        <div class="absolute inset-0">
            <img src="{{ asset('hero-ai-platform.jpg') }}" alt="AI Platform" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-br from-indigo-900/80 via-purple-900/70 to-pink-900/80"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>
        </div>
        
        <!-- Animated Background Elements Overlay -->
        <div class="absolute inset-0">
            <div class="absolute top-0 left-1/4 w-96 h-96 bg-indigo-500/20 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-purple-500/20 rounded-full blur-3xl animate-pulse delay-1000"></div>
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-pink-500/15 rounded-full blur-3xl animate-pulse delay-500"></div>
        </div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 z-10 w-full">
            <div class="text-center">
                <div class="inline-block mb-6">
                    <span class="px-4 py-2 bg-white/20 backdrop-blur-md text-white text-sm font-semibold rounded-full border border-white/30">
                        🔍 Explore AI Agents
                    </span>
                </div>
                <h1 class="text-5xl md:text-6xl lg:text-7xl font-extrabold text-white mb-6 leading-tight drop-shadow-2xl">
                    Discover <span class="bg-gradient-to-r from-cyan-300 via-blue-300 to-purple-300 bg-clip-text text-transparent drop-shadow-lg">Powerful AI Agents</span>
                </h1>
                <p class="text-xl md:text-2xl text-white/90 mb-8 max-w-3xl mx-auto leading-relaxed drop-shadow-lg">
                    Search and filter through our comprehensive collection of AI agents to find the perfect solution for your needs
                </p>
                <a href="{{ route('home') }}" class="inline-flex items-center text-white/90 hover:text-white font-medium">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Home
                </a>
            </div>
        </div>
    </div>

    <div class="py-12 bg-gradient-to-b from-gray-50 to-white dark:from-gray-800 dark:to-gray-900">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Featured Agents Section -->
            @if($featuredAgents->count() > 0)
                <div class="mb-12">
                    <div class="text-center mb-8">
                        <div class="inline-block mb-4">
                            <span class="px-4 py-2 bg-gradient-to-r from-indigo-100 via-purple-100 to-pink-100 dark:from-indigo-900/30 dark:via-purple-900/30 dark:to-pink-900/30 text-indigo-700 dark:text-indigo-300 text-sm font-semibold rounded-full">
                                ⭐ Featured
                            </span>
                        </div>
                        <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 dark:text-white mb-3">
                            Handpicked <span class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 bg-clip-text text-transparent">Powerful Agents</span>
                        </h2>
                        <p class="text-lg text-gray-600 dark:text-gray-400">Curated selection of the best AI agents you should try</p>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 gap-4 mb-16">
                        @foreach($featuredAgents as $agent)
                            <a href="{{ route('agents.show', $agent) }}" class="bg-white dark:bg-gray-800 p-3 rounded-xl border-2 border-indigo-500/30 dark:border-indigo-400/30 shadow-sm hover:shadow-md transition-all duration-200 group relative overflow-hidden">
                                <div class="absolute top-2 right-2 z-10">
                                    <span class="inline-flex items-center gap-1 text-[10px] font-bold px-2.5 py-1 rounded-full bg-gradient-to-r from-amber-400 via-orange-500 to-pink-500 text-white shadow-lg ring-1 ring-white/40 dark:ring-white/20">
                                        <span aria-hidden="true">★</span>{{ __('Featured') }}
                                    </span>
                                </div>
                                <div class="flex items-start gap-3">
                                    <div class="w-11 h-11 rounded-lg bg-gray-100 dark:bg-gray-700 overflow-hidden flex items-center justify-center shrink-0">
                                        @if($agent->featured_image)
                                            <img src="{{ $agent->featured_image }}" alt="{{ $agent->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-200">
                                        @else
                                            <span class="text-sm font-bold text-indigo-600 dark:text-indigo-300">{{ strtoupper(substr($agent->name, 0, 1)) }}</span>
                                        @endif
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="text-sm font-semibold text-gray-800 dark:text-gray-200 truncate" title="{{ $agent->name }}">{{ $agent->name }}</p>
                                        <p class="mt-1 text-xs text-gray-600 dark:text-gray-400 line-clamp-2">{{ $agent->description }}</p>
                                        <p class="mt-2 text-[11px] text-gray-500 dark:text-gray-400">
                                            {{ number_format($agent->averageRating(), 1) }}/5 · {{ $agent->reviewsCount() }} reviews
                                        </p>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Search and Filters (minimal) -->
            <div class="mb-10 pb-8 border-b border-gray-200/80 dark:border-gray-700/80">
                <form method="GET" action="{{ route('agents.explore') }}" class="flex flex-col gap-4">
                    <div class="flex flex-col sm:flex-row sm:flex-wrap sm:items-center gap-3 sm:gap-2">
                        <div class="relative flex-1 min-w-[200px]">
                            <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            <input type="search" name="search" id="search" value="{{ request('search') }}"
                                placeholder="{{ __('Search…') }}"
                                aria-label="{{ __('Search agents') }}"
                                class="w-full pl-9 pr-14 py-2 text-sm rounded-lg border-0 ring-1 ring-gray-200 dark:ring-gray-600 bg-gray-50/80 dark:bg-gray-900/50 text-gray-900 dark:text-gray-100 placeholder:text-gray-400 focus:ring-2 focus:ring-indigo-500/30 focus:bg-white dark:focus:bg-gray-900 transition-colors">
                            <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 text-xs font-medium text-gray-500 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-200" aria-label="{{ __('Search') }}">
                                {{ __('Go') }}
                            </button>
                        </div>

                        <div class="hidden sm:block h-6 w-px bg-gray-200 dark:bg-gray-600 shrink-0" aria-hidden="true"></div>

                        <select name="category" id="category" onchange="this.form.submit()" aria-label="{{ __('Category') }}"
                            class="py-2 pl-3 pr-8 text-sm rounded-lg border-0 ring-1 ring-gray-200 dark:ring-gray-600 bg-gray-50/80 dark:bg-gray-900/50 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-indigo-500/30 cursor-pointer min-w-[140px] sm:min-w-0">
                            <option value="">{{ __('All categories') }}</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>

                        <select name="pricing_type" id="pricing_type" onchange="this.form.submit()" aria-label="{{ __('Pricing') }}"
                            class="py-2 pl-3 pr-8 text-sm rounded-lg border-0 ring-1 ring-gray-200 dark:ring-gray-600 bg-gray-50/80 dark:bg-gray-900/50 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-indigo-500/30 cursor-pointer">
                            <option value="">{{ __('Any price') }}</option>
                            <option value="free" {{ request('pricing_type') == 'free' ? 'selected' : '' }}>{{ __('Free') }}</option>
                            <option value="paid" {{ request('pricing_type') == 'paid' ? 'selected' : '' }}>{{ __('Paid') }}</option>
                            <option value="freemium" {{ request('pricing_type') == 'freemium' ? 'selected' : '' }}>{{ __('Freemium') }}</option>
                        </select>

                        <select name="sort" id="sort" onchange="this.form.submit()" aria-label="{{ __('Sort') }}"
                            class="py-2 pl-3 pr-8 text-sm rounded-lg border-0 ring-1 ring-gray-200 dark:ring-gray-600 bg-gray-50/80 dark:bg-gray-900/50 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-indigo-500/30 cursor-pointer">
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>{{ __('Latest') }}</option>
                            <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>{{ __('Popular') }}</option>
                            <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>{{ __('Top rated') }}</option>
                        </select>
                    </div>

                    <div class="flex flex-wrap items-center justify-between gap-2 text-xs text-gray-500 dark:text-gray-400">
                        <span>{{ number_format($agents->total()) }} {{ __('agents') }}</span>
                        @if(request()->filled('search') || request()->filled('category') || request()->filled('pricing_type') || (request('sort') && request('sort') !== 'latest'))
                            <a href="{{ route('agents.explore') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline font-medium">
                                {{ __('Reset filters') }}
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Agents Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 gap-4 mb-12">
                @forelse($agents as $agent)
                    <a href="{{ route('agents.show', $agent) }}" class="bg-white dark:bg-gray-800 p-3 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition-all duration-200 group">
                        <div class="flex items-start gap-3">
                            <div class="w-11 h-11 rounded-lg bg-gray-100 dark:bg-gray-700 overflow-hidden flex items-center justify-center shrink-0">
                                @if($agent->featured_image)
                                    <img src="{{ $agent->featured_image }}" alt="{{ $agent->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-200">
                                @else
                                    <span class="text-sm font-bold text-indigo-600 dark:text-indigo-300">{{ strtoupper(substr($agent->name, 0, 1)) }}</span>
                                @endif
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-semibold text-gray-800 dark:text-gray-200 truncate" title="{{ $agent->name }}">{{ $agent->name }}</p>
                                <p class="mt-1 text-xs text-gray-600 dark:text-gray-400 line-clamp-2">{{ $agent->description }}</p>
                                <p class="mt-2 text-[11px] text-gray-500 dark:text-gray-400">
                                    {{ number_format($agent->averageRating(), 1) }}/5 · {{ $agent->reviewsCount() }} reviews
                                </p>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full text-center py-16">
                        <div class="max-w-md mx-auto">
                            <svg class="mx-auto h-24 w-24 text-gray-400 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                            </svg>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">No agents found</h3>
                            <p class="text-gray-500 dark:text-gray-400 mb-6">Try adjusting your filters or be the first to submit an AI agent!</p>
                            @auth
                                <a href="{{ route('agents.create') }}" class="inline-flex items-center bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 hover:from-indigo-700 hover:via-purple-700 hover:to-pink-700 text-white font-semibold py-3 px-6 rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Submit an Agent
                                </a>
                            @else
                                <a href="{{ route('register') }}" class="inline-flex items-center bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 hover:from-indigo-700 hover:via-purple-700 hover:to-pink-700 text-white font-semibold py-3 px-6 rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                    Get Started
                                </a>
                            @endauth
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mb-12">
                {{ $agents->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
