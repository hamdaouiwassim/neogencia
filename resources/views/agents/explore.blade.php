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
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-16">
                        @foreach($featuredAgents as $agent)
                            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-2xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border-2 border-indigo-500/30 dark:border-indigo-400/30 group relative">
                                <div class="absolute top-4 right-4 z-10">
                                    <span class="bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-lg backdrop-blur-sm">
                                        ⭐ Featured
                                    </span>
                                </div>
                                @if($agent->featured_image)
                                    <div class="w-full h-48 bg-gray-200 dark:bg-gray-700 overflow-hidden">
                                        <img src="{{ $agent->featured_image }}" alt="{{ $agent->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                    </div>
                                @endif
                                <div class="p-6">
                                    <div class="flex justify-between items-start mb-2">
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                            <a href="{{ route('agents.show', $agent) }}" class="hover:text-indigo-600 dark:hover:text-indigo-400">
                                                {{ $agent->name }}
                                            </a>
                                        </h3>
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full
                                            {{ $agent->pricing_type === 'free' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : '' }}
                                            {{ $agent->pricing_type === 'paid' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : '' }}
                                            {{ $agent->pricing_type === 'freemium' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' : '' }}">
                                            {{ ucfirst($agent->pricing_type) }}
                                        </span>
                                    </div>
                                    
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-3 line-clamp-2">
                                        {{ $agent->description }}
                                    </p>
                                    
                                    <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400 mb-3">
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                            </svg>
                                            {{ number_format($agent->averageRating(), 1) }} ({{ $agent->reviewsCount() }})
                                        </span>
                                        <span>{{ $agent->views }} views</span>
                                    </div>
                                    
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $agent->category->name }}
                                        </span>
                                        <a href="{{ route('agents.show', $agent) }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 hover:from-indigo-700 hover:via-purple-700 hover:to-pink-700 text-white text-sm font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-200 transform hover:scale-105">
                                            View Details
                                            <svg class="w-4 h-4 ml-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Search and Filters -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-2xl sm:rounded-3xl mb-12 p-8 border-2 border-gray-200/50 dark:border-gray-700/50">
                <div class="text-center mb-6">
                    <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 dark:text-white mb-2">
                        Discover <span class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 bg-clip-text text-transparent">AI Agents</span>
                    </h2>
                    <p class="text-gray-600 dark:text-gray-400">Search and filter through our collection of AI agents</p>
                </div>
                <form method="GET" action="{{ route('agents.explore') }}" class="space-y-4 md:space-y-0 md:flex md:items-end md:space-x-4">
                    <div class="flex-1">
                        <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Search</label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}" 
                               placeholder="Search agents..." 
                               class="w-full rounded-xl border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-2 focus:ring-indigo-500/20 transition-all">
                    </div>
                    
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Category</label>
                        <select name="category" id="category" class="rounded-xl border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-2 focus:ring-indigo-500/20 min-w-[160px]">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label for="pricing_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Pricing</label>
                        <select name="pricing_type" id="pricing_type" class="rounded-xl border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-2 focus:ring-indigo-500/20 min-w-[140px]">
                            <option value="">All Types</option>
                            <option value="free" {{ request('pricing_type') == 'free' ? 'selected' : '' }}>Free</option>
                            <option value="paid" {{ request('pricing_type') == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="freemium" {{ request('pricing_type') == 'freemium' ? 'selected' : '' }}>Freemium</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="sort" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Sort</label>
                        <select name="sort" id="sort" class="rounded-xl border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-2 focus:ring-indigo-500/20 min-w-[140px]">
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                            <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Popular</option>
                            <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Highest Rated</option>
                        </select>
                    </div>
                    
                    <div>
                        <button type="submit" class="inline-flex items-center bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 hover:from-indigo-700 hover:via-purple-700 hover:to-pink-700 text-white font-semibold py-2.5 px-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                            </svg>
                            Filter
                        </button>
                    </div>
                </form>
            </div>

            <!-- Agents Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                @forelse($agents as $agent)
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-2xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border-2 border-gray-200 dark:border-gray-700 group">
                        @if($agent->featured_image)
                            <div class="w-full h-48 bg-gray-200 dark:bg-gray-700 overflow-hidden">
                                <img src="{{ $agent->featured_image }}" alt="{{ $agent->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                            </div>
                        @endif
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                    <a href="{{ route('agents.show', $agent) }}" class="hover:text-indigo-600 dark:hover:text-indigo-400">
                                        {{ $agent->name }}
                                    </a>
                                </h3>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full
                                    {{ $agent->pricing_type === 'free' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : '' }}
                                    {{ $agent->pricing_type === 'paid' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : '' }}
                                    {{ $agent->pricing_type === 'freemium' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' : '' }}">
                                    {{ ucfirst($agent->pricing_type) }}
                                </span>
                            </div>
                            
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-3 line-clamp-2">
                                {{ $agent->description }}
                            </p>
                            
                            <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400 mb-3">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                    {{ number_format($agent->averageRating(), 1) }} ({{ $agent->reviewsCount() }})
                                </span>
                                <span>{{ $agent->views }} views</span>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <span class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $agent->category->name }}
                                </span>
                                <a href="{{ route('agents.show', $agent) }}" class="inline-flex items-center px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-lg shadow-sm hover:shadow-md transition-all duration-200 transform hover:scale-105">
                                    View Details
                                    <svg class="w-3 h-3 ml-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
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
