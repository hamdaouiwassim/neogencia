<x-app-layout>
    <div class="relative overflow-hidden bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-600 py-16 md:py-24">
        <div class="absolute inset-0 bg-black/20"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white mb-4">
                    AI Agents Marketplace
                </h1>
                <p class="text-xl md:text-2xl text-indigo-100 mb-8 max-w-3xl mx-auto">
                    Discover, explore, and connect with cutting-edge AI agents and models
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    @auth
                        <a href="{{ route('agents.create') }}" class="bg-white text-indigo-600 hover:bg-gray-100 font-semibold py-3 px-8 rounded-lg shadow-xl hover:shadow-2xl transition-all duration-200 transform hover:scale-105">
                            + Submit Agent
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="bg-white text-indigo-600 hover:bg-gray-100 font-semibold py-3 px-8 rounded-lg shadow-xl hover:shadow-2xl transition-all duration-200 transform hover:scale-105">
                            Get Started
                        </a>
                    @endauth
                    <a href="#agents" class="bg-indigo-700/80 text-white hover:bg-indigo-800/90 font-semibold py-3 px-8 rounded-lg shadow-xl hover:shadow-2xl transition-all duration-200 border border-white/20">
                        Browse Agents
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Featured Agents Section -->
            @if($featuredAgents->count() > 0)
                <div class="mb-16">
                    <div class="text-center mb-8">
                        <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-3">Featured AI Agents</h2>
                        <p class="text-lg text-gray-600 dark:text-gray-400">Handpicked powerful agents you should try</p>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($featuredAgents as $agent)
                            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border-2 border-indigo-500/20 dark:border-indigo-400/20 group relative">
                                <div class="absolute top-4 right-4 z-10">
                                    <span class="bg-gradient-to-r from-indigo-500 to-purple-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg">
                                        Featured
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
                                        <a href="{{ route('agents.show', $agent) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 text-sm font-semibold flex items-center group-hover:gap-2 transition-all">
                                            View Details 
                                            <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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

            <!-- Submit Agent Block -->
            <div class="mb-16 bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 rounded-2xl p-8 md:p-12 text-center relative overflow-hidden">
                <div class="absolute inset-0 bg-black/10"></div>
                <div class="relative z-10">
                    <svg class="mx-auto h-16 w-16 text-white mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Share Your AI Agent</h2>
                    <p class="text-xl text-indigo-100 mb-8 max-w-2xl mx-auto">
                        Have you built an amazing AI agent? Share it with our community and help others discover innovative solutions.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        @auth
                            <a href="{{ route('agents.create') }}" class="bg-white text-indigo-600 hover:bg-gray-100 font-semibold py-4 px-8 rounded-lg shadow-xl hover:shadow-2xl transition-all duration-200 transform hover:scale-105 inline-flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Submit Your Agent
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="bg-white text-indigo-600 hover:bg-gray-100 font-semibold py-4 px-8 rounded-lg shadow-xl hover:shadow-2xl transition-all duration-200 transform hover:scale-105 inline-flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                </svg>
                                Sign Up to Submit
                            </a>
                            <a href="{{ route('login') }}" class="bg-indigo-700/80 text-white hover:bg-indigo-800/90 font-semibold py-4 px-8 rounded-lg shadow-xl hover:shadow-2xl transition-all duration-200 border border-white/20 inline-flex items-center justify-center">
                                Already have an account? Login
                            </a>
                        @endauth
                    </div>
                    <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6 text-white/80">
                        <div class="flex flex-col items-center">
                            <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            <p class="text-sm font-medium">Quick Submission</p>
                            <p class="text-xs mt-1">Takes just a few minutes</p>
                        </div>
                        <div class="flex flex-col items-center">
                            <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <p class="text-sm font-medium">Reach Thousands</p>
                            <p class="text-xs mt-1">Get discovered by users</p>
                        </div>
                        <div class="flex flex-col items-center">
                            <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                            </svg>
                            <p class="text-sm font-medium">Build Reputation</p>
                            <p class="text-xs mt-1">Earn reviews and ratings</p>
                        </div>
                    </div>
                </div>
            </div>

            <div id="agents">
            <!-- Search and Filters -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-xl mb-8 p-6 border border-gray-200 dark:border-gray-700">
                <form method="GET" action="{{ route('home') }}" class="space-y-4 md:space-y-0 md:flex md:items-end md:space-x-4">
                    <div class="flex-1">
                        <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Search</label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}" 
                               placeholder="Search agents..." 
                               class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600">
                    </div>
                    
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Category</label>
                        <select name="category" id="category" class="rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600">
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
                        <select name="pricing_type" id="pricing_type" class="rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600">
                            <option value="">All Types</option>
                            <option value="free" {{ request('pricing_type') == 'free' ? 'selected' : '' }}>Free</option>
                            <option value="paid" {{ request('pricing_type') == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="freemium" {{ request('pricing_type') == 'freemium' ? 'selected' : '' }}>Freemium</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="sort" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Sort</label>
                        <select name="sort" id="sort" class="rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600">
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                            <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Popular</option>
                            <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Highest Rated</option>
                        </select>
                    </div>
                    
                    <div>
                        <button type="submit" class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold py-2 px-6 rounded-lg shadow-lg hover:shadow-xl transition-all duration-200">
                            Filter
                        </button>
                    </div>
                </form>
            </div>

            <!-- Agents Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
                @forelse($agents as $agent)
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-200 dark:border-gray-700 group">
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
                                <a href="{{ route('agents.show', $agent) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 text-sm font-semibold flex items-center group-hover:gap-2 transition-all">
                                    View Details 
                                    <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                            <p class="text-gray-500 dark:text-gray-400 mb-6">Be the first to submit an AI agent!</p>
                            @auth
                                <a href="{{ route('agents.create') }}" class="inline-block bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold py-3 px-6 rounded-lg shadow-lg hover:shadow-xl transition-all duration-200">
                                    Submit an Agent
                                </a>
                            @else
                                <a href="{{ route('register') }}" class="inline-block bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold py-3 px-6 rounded-lg shadow-lg hover:shadow-xl transition-all duration-200">
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

            <!-- Pricing Section -->
            <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 overflow-hidden shadow-2xl sm:rounded-2xl p-8 md:p-12 border border-gray-200 dark:border-gray-700">
                <div class="text-center mb-12">
                    <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-3">Pricing Plans</h2>
                    <p class="text-lg text-gray-600 dark:text-gray-400">Choose the perfect plan for your needs</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @forelse($pricingPlans as $plan)
                        <div class="relative bg-white dark:bg-gray-800 border-2 rounded-xl p-8 transform transition-all duration-300 hover:scale-105 {{ $plan->is_popular ? 'border-indigo-500 dark:border-indigo-400 ring-4 ring-indigo-500/20 dark:ring-indigo-400/20 shadow-2xl' : 'border-gray-200 dark:border-gray-700 shadow-lg hover:shadow-xl' }}">
                            @if($plan->is_popular)
                                <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                                    <span class="bg-gradient-to-r from-indigo-500 to-purple-500 text-white text-xs font-bold px-4 py-2 rounded-full shadow-lg">MOST POPULAR</span>
                                </div>
                            @endif
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">{{ $plan->name }}</h3>
                            <div class="mb-6">
                                <span class="text-5xl font-extrabold text-gray-900 dark:text-white">${{ number_format($plan->price, 2) }}</span>
                                <span class="text-gray-600 dark:text-gray-400 text-lg">/{{ $plan->currency }}</span>
                            </div>
                            @if($plan->description)
                                <p class="text-gray-600 dark:text-gray-400 mb-4">{{ $plan->description }}</p>
                            @endif
                            @if(is_array($plan->features) && count($plan->features) > 0)
                                <ul class="space-y-2 mb-6">
                                    @foreach($plan->features as $feature)
                                        <li class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                                            <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                            {{ $feature }}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                            <button class="w-full {{ $plan->is_popular ? 'bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700' : 'bg-gray-800 hover:bg-gray-900 dark:bg-gray-700 dark:hover:bg-gray-600' }} text-white font-semibold py-3 px-6 rounded-lg shadow-lg hover:shadow-xl transition-all duration-200">
                                Get Started
                            </button>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-12">
                            <p class="text-gray-500 dark:text-gray-400 text-lg">Pricing plans coming soon!</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
