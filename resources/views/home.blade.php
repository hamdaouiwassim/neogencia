<x-app-layout>
    <style>
        /* Typed.js cursor styling */
        #typed-text + .typed-cursor {
            color: rgb(139, 92, 246); /* purple-500 */
            animation: blink 1s infinite;
        }
        @keyframes blink {
            0%, 50% { opacity: 1; }
            51%, 100% { opacity: 0; }
        }
    </style>
    
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
                        🚀 Welcome to Neogencia
                    </span>
                </div>
                <h1 class="text-5xl md:text-6xl lg:text-7xl font-extrabold text-white mb-6 leading-tight drop-shadow-2xl">
                    Discover Powerful
                    <span class="bg-gradient-to-r from-cyan-300 via-blue-300 to-purple-300 bg-clip-text text-transparent drop-shadow-lg">AI Agents</span>
                </h1>
                <p class="text-xl md:text-2xl text-white/90 mb-10 max-w-3xl mx-auto leading-relaxed drop-shadow-lg">
                    Explore, connect, and leverage cutting-edge AI agents that transform how you work and create on Neogencia
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                    @auth
                        <a href="{{ route('agents.create') }}" class="group inline-flex items-center bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 text-white hover:from-indigo-600 hover:via-purple-600 hover:to-pink-600 font-bold py-4 px-8 rounded-xl shadow-2xl hover:shadow-3xl transition-all duration-300 transform hover:scale-105">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Submit Your Agent
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="group inline-flex items-center bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 text-white hover:from-indigo-600 hover:via-purple-600 hover:to-pink-600 font-bold py-4 px-8 rounded-xl shadow-2xl hover:shadow-3xl transition-all duration-300 transform hover:scale-105">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            Get Started Free
                        </a>
                    @endauth
                    <a href="{{ route('agents.explore') }}" class="group inline-flex items-center bg-white/10 backdrop-blur-md text-white hover:bg-white/20 font-bold py-4 px-8 rounded-xl shadow-xl hover:shadow-2xl transition-all duration-300 border-2 border-white/30">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Explore Agents
                    </a>
                </div>
            </div>
        </div>
        <!-- Scroll Indicator -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
            <svg class="w-6 h-6 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
            </svg>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="relative bg-white dark:bg-gray-900 py-16 -mt-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 md:gap-8">
                <div class="text-center p-6 bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50 dark:from-indigo-900/20 dark:via-purple-900/20 dark:to-pink-900/20 rounded-2xl border border-indigo-200 dark:border-indigo-800 hover:shadow-lg transition-all duration-300">
                    <div class="text-4xl md:text-5xl font-extrabold bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 bg-clip-text text-transparent mb-2">
                        {{ \App\Models\Agent::where('is_approved', true)->count() }}+
                    </div>
                    <div class="text-gray-600 dark:text-gray-400 font-semibold">AI Agents</div>
                </div>
                <div class="text-center p-6 bg-gradient-to-br from-purple-50 via-pink-50 to-rose-50 dark:from-purple-900/20 dark:via-pink-900/20 dark:to-rose-900/20 rounded-2xl border border-purple-200 dark:border-purple-800 hover:shadow-lg transition-all duration-300">
                    <div class="text-4xl md:text-5xl font-extrabold bg-gradient-to-r from-purple-600 via-pink-600 to-rose-600 bg-clip-text text-transparent mb-2">
                        {{ \App\Models\User::count() }}+
                    </div>
                    <div class="text-gray-600 dark:text-gray-400 font-semibold">Active Users</div>
                </div>
                <div class="text-center p-6 bg-gradient-to-br from-cyan-50 via-blue-50 to-indigo-50 dark:from-cyan-900/20 dark:via-blue-900/20 dark:to-indigo-900/20 rounded-2xl border border-cyan-200 dark:border-cyan-800 hover:shadow-lg transition-all duration-300">
                    <div class="text-4xl md:text-5xl font-extrabold bg-gradient-to-r from-cyan-600 via-blue-600 to-indigo-600 bg-clip-text text-transparent mb-2">
                        {{ \App\Models\Review::count() }}+
                    </div>
                    <div class="text-gray-600 dark:text-gray-400 font-semibold">Reviews</div>
                </div>
                <div class="text-center p-6 bg-gradient-to-br from-indigo-50 via-purple-50 to-cyan-50 dark:from-indigo-900/20 dark:via-purple-900/20 dark:to-cyan-900/20 rounded-2xl border border-indigo-200 dark:border-indigo-800 hover:shadow-lg transition-all duration-300">
                    <div class="text-4xl md:text-5xl font-extrabold bg-gradient-to-r from-indigo-600 via-purple-600 to-cyan-600 bg-clip-text text-transparent mb-2">
                        {{ \App\Models\Agent::where('is_approved', true)->sum('views') }}+
                    </div>
                    <div class="text-gray-600 dark:text-gray-400 font-semibold">Total Views</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="py-20 bg-gradient-to-b from-white to-gray-50 dark:from-gray-900 dark:to-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 dark:text-white mb-4">
                    Why Choose <span class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 bg-clip-text text-transparent">Our Platform</span>
                </h2>
                <p class="text-xl text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                    Everything you need to discover, evaluate, and integrate AI agents
                </p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="group p-8 bg-white dark:bg-gray-800 rounded-2xl border-2 border-gray-200 dark:border-gray-700 hover:border-indigo-500 dark:hover:border-indigo-500 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">Powerful Search</h3>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                        Find the perfect AI agent with advanced filtering by category, pricing, and ratings
                    </p>
                </div>
                <div class="group p-8 bg-white dark:bg-gray-800 rounded-2xl border-2 border-gray-200 dark:border-gray-700 hover:border-pink-500 dark:hover:border-pink-500 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-gradient-to-br from-pink-500 to-rose-600 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">Verified Agents</h3>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                        All agents are reviewed and verified to ensure quality and reliability
                    </p>
                </div>
                <div class="group p-8 bg-white dark:bg-gray-800 rounded-2xl border-2 border-gray-200 dark:border-gray-700 hover:border-blue-500 dark:hover:border-blue-500 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">Active Community</h3>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                        Join thousands of developers and creators sharing innovative AI solutions
                    </p>
                </div>
                <div class="group p-8 bg-white dark:bg-gray-800 rounded-2xl border-2 border-gray-200 dark:border-gray-700 hover:border-emerald-500 dark:hover:border-emerald-500 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">Lightning Fast</h3>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                        Quick access to agents with instant search and seamless integration
                    </p>
                </div>
                <div class="group p-8 bg-white dark:bg-gray-800 rounded-2xl border-2 border-gray-200 dark:border-gray-700 hover:border-amber-500 dark:hover:border-amber-500 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-gradient-to-br from-amber-500 to-orange-600 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">Real Analytics</h3>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                        Track views, ratings, and performance metrics for every agent
                    </p>
                </div>
                <div class="group p-8 bg-white dark:bg-gray-800 rounded-2xl border-2 border-gray-200 dark:border-gray-700 hover:border-indigo-500 dark:hover:border-indigo-500 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-blue-600 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">Secure Platform</h3>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                        Your data and submissions are protected with enterprise-grade security
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- AI Workforce Value Proposition Section -->
    <div id="ai-workforce" class="py-20 bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50 dark:from-indigo-900/10 dark:via-purple-900/10 dark:to-pink-900/10 relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-5">
            <div class="absolute top-0 left-0 w-96 h-96 bg-indigo-500 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-purple-500 rounded-full blur-3xl"></div>
        </div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <div class="inline-block mb-4">
                    <span class="px-4 py-2 bg-gradient-to-r from-indigo-100 via-purple-100 to-pink-100 dark:from-indigo-900/30 dark:via-purple-900/30 dark:to-pink-900/30 text-indigo-700 dark:text-indigo-300 text-sm font-semibold rounded-full border border-indigo-200 dark:border-indigo-800">
                        🤖 AI Workforce Platform
                    </span>
                </div>
                <h2 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-gray-900 dark:text-white mb-6">
                    Build Your <span id="typed-text" class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 bg-clip-text text-transparent"></span>
                </h2>
                <p class="text-xl md:text-2xl text-gray-700 dark:text-gray-300 max-w-4xl mx-auto leading-relaxed mb-4">
                    An AI Workforce is your digital team of intelligent agents designed to automate routine and repetitive tasks, freeing your human talent to focus on strategic initiatives.
                </p>
                <p class="text-lg md:text-xl text-gray-600 dark:text-gray-400 max-w-4xl mx-auto leading-relaxed">
                    Each AI Workforce is composed of specialized Agents equipped with custom Tools tailored to your specific business needs—all crafted by domain experts who understand your industry.
                </p>
            </div>

            <!-- Main Value Proposition Card -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl border-2 border-indigo-200/50 dark:border-indigo-800/50 p-8 md:p-12 mb-12">
                <div class="max-w-4xl mx-auto text-center">
                    <div class="w-20 h-20 bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mb-6">
                        One Platform. Complete Control. Unlimited Possibilities.
                    </h3>
                    <p class="text-lg md:text-xl text-gray-700 dark:text-gray-300 leading-relaxed mb-8">
                        Neogencia provides the complete platform to build, configure, and deploy your AI Workforce as a powerful <strong class="text-indigo-600 dark:text-indigo-400">Multi-Agent System (MAS)</strong>, empowering your organization across every department.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        @auth
                            <a href="{{ route('seo-squads.index') }}" class="inline-flex items-center justify-center bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 hover:from-indigo-700 hover:via-purple-700 hover:to-pink-700 text-white font-bold py-4 px-8 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Create Your AI Workforce
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="inline-flex items-center justify-center bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 hover:from-indigo-700 hover:via-purple-700 hover:to-pink-700 text-white font-bold py-4 px-8 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                                Get Started Free
                            </a>
                        @endauth
                        <a href="#use-cases" class="inline-flex items-center justify-center bg-white dark:bg-gray-700 text-gray-900 dark:text-white hover:bg-gray-50 dark:hover:bg-gray-600 font-bold py-4 px-8 rounded-xl border-2 border-gray-200 dark:border-gray-600 shadow-md hover:shadow-lg transition-all duration-300">
                            Explore Use Cases
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Use Cases Grid -->
            <div id="use-cases" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Use Case 1: Customer Support -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 border-2 border-indigo-200 dark:border-indigo-800 hover:border-indigo-500 dark:hover:border-indigo-500 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="w-14 h-14 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Customer Support</h3>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                        Deploy AI agents to handle customer inquiries, support tickets, and FAQs 24/7, reducing response times and improving satisfaction.
                    </p>
                </div>

                <!-- Use Case 2: Sales & Marketing -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 border-2 border-purple-200 dark:border-purple-800 hover:border-purple-500 dark:hover:border-purple-500 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Sales & Marketing</h3>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                        Automate lead qualification, content creation, email campaigns, and market research to accelerate your sales pipeline.
                    </p>
                </div>

                <!-- Use Case 3: HR & Recruitment -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 border-2 border-pink-200 dark:border-pink-800 hover:border-pink-500 dark:hover:border-pink-500 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="w-14 h-14 bg-gradient-to-br from-pink-500 to-rose-600 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">HR & Recruitment</h3>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                        Streamline resume screening, candidate matching, interview scheduling, and onboarding processes with intelligent automation.
                    </p>
                </div>

                <!-- Use Case 4: Finance & Accounting -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 border-2 border-cyan-200 dark:border-cyan-800 hover:border-cyan-500 dark:hover:border-cyan-500 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="w-14 h-14 bg-gradient-to-br from-cyan-500 to-blue-600 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Finance & Accounting</h3>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                        Automate invoice processing, expense management, financial reporting, and compliance checks with precision and accuracy.
                    </p>
                </div>

                <!-- Use Case 5: Operations & Logistics -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 border-2 border-blue-200 dark:border-blue-800 hover:border-blue-500 dark:hover:border-blue-500 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Operations & Logistics</h3>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                        Optimize supply chain management, inventory tracking, order fulfillment, and route planning with intelligent coordination.
                    </p>
                </div>

                <!-- Use Case 6: Research & Development -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 border-2 border-indigo-200 dark:border-indigo-800 hover:border-indigo-500 dark:hover:border-indigo-500 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="w-14 h-14 bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Research & Development</h3>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                        Accelerate data analysis, literature reviews, experiment design, and innovation discovery with AI-powered research assistants.
                    </p>
                </div>
            </div>

            <!-- Benefits Section -->
            <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-center p-6">
                    <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-2">10x Faster</h4>
                    <p class="text-gray-600 dark:text-gray-400">Complete tasks in minutes that would take hours or days</p>
                </div>
                <div class="text-center p-6">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Cost Effective</h4>
                    <p class="text-gray-600 dark:text-gray-400">Reduce operational costs while scaling your capabilities</p>
                </div>
                <div class="text-center p-6">
                    <div class="w-16 h-16 bg-gradient-to-br from-pink-500 to-rose-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Always Available</h4>
                    <p class="text-gray-600 dark:text-gray-400">24/7 operation without breaks, holidays, or downtime</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Categories Showcase -->
    <div class="py-16 bg-white dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 dark:text-white mb-4">
                    Explore by <span class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 bg-clip-text text-transparent">Category</span>
                </h2>
                <p class="text-xl text-gray-600 dark:text-gray-400">Find agents tailored to your specific needs</p>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($categories->take(8) as $category)
                    <a href="{{ route('home', ['category' => $category->id]) }}" class="group p-6 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-700 rounded-xl border-2 border-gray-200 dark:border-gray-600 hover:border-violet-500 dark:hover:border-violet-500 shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 rounded-lg flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                            {{ $category->name }}
                        </h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">
                            {{ $category->agents()->where('is_approved', true)->count() }} agents
                        </p>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <div class="py-12 bg-gradient-to-b from-gray-50 to-white dark:from-gray-800 dark:to-gray-900">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Featured Agents Section -->
                        @if($featuredAgents->count() > 0)
                <div class="mb-20">
                    <div class="text-center mb-12">
                        <div class="inline-block mb-4">
                            <span class="px-4 py-2 bg-gradient-to-r from-indigo-100 via-purple-100 to-pink-100 dark:from-indigo-900/30 dark:via-purple-900/30 dark:to-pink-900/30 text-indigo-700 dark:text-indigo-300 text-sm font-semibold rounded-full">
                                ⭐ Featured
                            </span>
                        </div>
                        <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 dark:text-white mb-4">
                            Handpicked <span class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 bg-clip-text text-transparent">Powerful Agents</span>
                        </h2>
                        <p class="text-xl text-gray-600 dark:text-gray-400 mb-6">Curated selection of the best AI agents you should try</p>
                        <a href="{{ route('agents.explore') }}" class="inline-flex items-center text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 font-semibold">
                            View All Agents
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
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

            <!-- How It Works Section -->
            <div class="mb-20 py-16 bg-white dark:bg-gray-900">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center mb-12">
                        <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 dark:text-white mb-4">
                            How It <span class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 bg-clip-text text-transparent">Works</span>
                        </h2>
                        <p class="text-xl text-gray-600 dark:text-gray-400">Get started in three simple steps</p>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div class="text-center p-8 bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50 dark:from-indigo-900/20 dark:via-purple-900/20 dark:to-pink-900/20 rounded-2xl border-2 border-indigo-200 dark:border-indigo-800">
                            <div class="w-20 h-20 bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl font-bold text-white shadow-lg">
                                1
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">Sign Up</h3>
                            <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                                Create your free account in seconds and join our growing community
                            </p>
                        </div>
                        <div class="text-center p-8 bg-gradient-to-br from-pink-50 to-rose-50 dark:from-pink-900/20 dark:to-rose-900/20 rounded-2xl border-2 border-pink-200 dark:border-pink-800">
                            <div class="w-20 h-20 bg-gradient-to-br from-pink-500 to-rose-600 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl font-bold text-white shadow-lg">
                                2
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">Submit Agent</h3>
                            <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                                Share your AI agent with details, links, and documentation
                            </p>
                        </div>
                        <div class="text-center p-8 bg-gradient-to-br from-blue-50 to-cyan-50 dark:from-blue-900/20 dark:to-cyan-900/20 rounded-2xl border-2 border-blue-200 dark:border-blue-800">
                            <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl font-bold text-white shadow-lg">
                                3
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">Get Discovered</h3>
                            <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                                Get approved and start receiving views, reviews, and ratings
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Agent Block -->
            <div class="mb-20 bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 rounded-3xl p-10 md:p-16 text-center relative overflow-hidden shadow-2xl">
                <div class="absolute inset-0 bg-black/10"></div>
                <div class="absolute top-0 left-0 w-96 h-96 bg-white/10 rounded-full blur-3xl -translate-x-1/2 -translate-y-1/2"></div>
                <div class="absolute bottom-0 right-0 w-96 h-96 bg-white/10 rounded-full blur-3xl translate-x-1/2 translate-y-1/2"></div>
                <div class="relative z-10">
                    <div class="inline-block mb-6">
                        <span class="px-4 py-2 bg-white/20 backdrop-blur-md text-white text-sm font-semibold rounded-full border border-white/30">
                            🚀 Join the Community
                        </span>
                    </div>
                    <svg class="mx-auto h-20 w-20 text-white mb-6 drop-shadow-lg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <h2 class="text-4xl md:text-5xl font-extrabold text-white mb-6">Share Your AI Agent</h2>
                    <p class="text-xl md:text-2xl text-purple-100 mb-10 max-w-3xl mx-auto leading-relaxed">
                        Have you built an amazing AI agent? Share it with our community and help others discover innovative solutions that transform workflows.
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

            <!-- Pricing Section -->
            <div class="bg-gradient-to-br from-white via-gray-50 to-white dark:from-gray-800 dark:via-gray-900 dark:to-gray-800 overflow-hidden shadow-2xl sm:rounded-3xl p-8 md:p-16 border-2 border-gray-200 dark:border-gray-700">
                <div class="text-center mb-16">
                    <div class="inline-block mb-4">
                        <span class="px-4 py-2 bg-gradient-to-r from-violet-100 to-purple-100 dark:from-violet-900/30 dark:to-purple-900/30 text-violet-700 dark:text-violet-300 text-sm font-semibold rounded-full">
                            💰 Pricing
                        </span>
                    </div>
                    <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 dark:text-white mb-4">
                        Choose Your <span class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 bg-clip-text text-transparent">Plan</span>
                    </h2>
                    <p class="text-xl text-gray-600 dark:text-gray-400">Select the perfect plan that fits your needs</p>
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
                            <button class="w-full inline-flex items-center justify-center {{ $plan->is_popular ? 'bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 hover:from-indigo-700 hover:via-purple-700 hover:to-pink-700' : 'bg-gray-800 hover:bg-gray-900 dark:bg-gray-700 dark:hover:bg-gray-600' }} text-white font-semibold py-3 px-6 rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
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

    <!-- Typed.js Initialization -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (document.getElementById('typed-text')) {
                var typed = new Typed('#typed-text', {
                    strings: [
                        'AI Workforce',
                        'Digital Team',
                        'Multi-Agent System',
                        'Automated Solutions',
                        'AI Workforce'
                    ],
                    typeSpeed: 60,
                    backSpeed: 40,
                    backDelay: 2000,
                    startDelay: 500,
                    loop: true,
                    showCursor: true,
                    cursorChar: '|',
                    smartBackspace: true
                });
            }
        });
    </script>
</x-app-layout>
