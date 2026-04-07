<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    🤖 {{ __('AI Workforce Platform') }}
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ __('Build and deploy multi-agent teams on Neogencia.') }}</p>
            </div>
            <a href="{{ route('home') }}" class="inline-flex items-center text-sm font-semibold text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                {{ __('Back to home') }}
            </a>
        </div>
    </x-slot>

    <style>
        #typed-text + .typed-cursor {
            color: rgb(139, 92, 246);
            animation: blink 1s infinite;
        }
        @keyframes blink {
            0%, 50% { opacity: 1; }
            51%, 100% { opacity: 0; }
        }
    </style>

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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (document.getElementById('typed-text')) {
                new Typed('#typed-text', {
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
