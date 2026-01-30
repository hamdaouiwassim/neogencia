<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Neogencia - AI Agents Marketplace</title>

        <!-- Favicon -->
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
        <link rel="manifest" href="{{ asset('site.webmanifest') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Typed.js Library -->
        <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-black" x-data="{ mobileSidebarOpen: false }">
        @php
            // Define public routes that should show navbar even for authenticated users
            $publicRoutes = [
                'home',
                'agents.explore',  // Public explore agents page
                'agents.show',  // Public agent detail page
                'login',
                'register',
                'password.*',
                'verification.*',
                'welcome'
            ];
            $isPublicRoute = request()->routeIs($publicRoutes);
            
            // If user is authenticated and NOT on a public route, show sidebar
            // This covers all authenticated routes automatically
            $showSidebar = auth()->check() && !$isPublicRoute;
        @endphp

        @if($showSidebar)
            <!-- Sidebar Layout for Authenticated Users on Protected Pages -->
            <div class="min-h-screen flex">
                <!-- Sidebar for authenticated users -->
                <div class="hidden lg:block">
                    <x-sidebar />
                </div>
                
                <!-- Mobile Sidebar -->
                <div x-show="mobileSidebarOpen" 
                     x-transition:enter="transition-opacity ease-linear duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition-opacity ease-linear duration-300"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     @click="mobileSidebarOpen = false"
                     class="lg:hidden fixed inset-0 z-40 bg-gray-600 bg-opacity-75"></div>

                <aside x-show="mobileSidebarOpen"
                       x-transition:enter="transition ease-in-out duration-300 transform"
                       x-transition:enter-start="-translate-x-full"
                       x-transition:enter-end="translate-x-0"
                       x-transition:leave="transition ease-in-out duration-300 transform"
                       x-transition:leave-start="translate-x-0"
                       x-transition:leave-end="-translate-x-full"
                       class="lg:hidden fixed inset-y-0 left-0 z-50 w-64 bg-white dark:bg-gray-900 border-r border-gray-200 dark:border-gray-700 shadow-lg flex flex-col">
                    <div class="flex items-center justify-between h-16 px-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-indigo-50 to-purple-50 dark:from-gray-800 dark:to-gray-700">
                        <a href="{{ route('home') }}" class="flex items-center space-x-2 hover:opacity-80 transition-opacity">
                            <x-application-logo class="block h-8 w-auto fill-current text-gray-800 dark:text-gray-200" />
                            <span class="font-bold text-lg bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">Neogencia</span>
                        </a>
                        <button @click="mobileSidebarOpen = false" class="p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-800">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <x-sidebar />
                </aside>

                <!-- Main Content Area -->
                <div class="flex-1 lg:ml-64 flex flex-col min-h-screen">
                    <!-- Top Bar for Authenticated Users -->
                    <div class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-md border-b border-gray-200 dark:border-gray-700 shadow-sm sticky top-0 z-30">
                        <div class="h-16 flex items-center justify-between px-4 sm:px-6 lg:px-8">
                            <div class="flex items-center">
                                <button @click="mobileSidebarOpen = !mobileSidebarOpen" class="lg:hidden p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-800 mr-2">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                                    </svg>
                                </button>
                                <h1 class="text-xl font-semibold text-gray-900 dark:text-white">
                                    @if(request()->routeIs('admin.*'))
                                        {{ __('Administration') }}
                                    @elseif(request()->routeIs('dashboard'))
                                        {{ __('Dashboard') }}
                                    @elseif(request()->routeIs('agents.*'))
                                        {{ __('Agents') }}
                                    @elseif(request()->routeIs('chatbot.*'))
                                        {{ __('Chatbot Test') }}
                                    @else
                                        {{ __('Neogencia') }}
                                    @endif
                                </h1>
                            </div>
                        </div>
                    </div>

                    <!-- Page Heading -->
                    @isset($header)
                        <header class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
                            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                                {{ $header }}
                            </div>
                        </header>
                    @endisset

                    <!-- Page Content -->
                    <main class="flex-1">
                        {{ $slot }}
                    </main>

                    @include('components.footer')
                </div>
            </div>
        @else
            <!-- Navbar Layout for Public Pages and Guest Users -->
            <div class="min-h-screen flex flex-col w-full">
                @include('layouts.navigation')

                <!-- Page Heading -->
                @isset($header)
                    <header class="bg-white dark:bg-gray-800 shadow-lg border-b border-gray-200 dark:border-gray-700">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <!-- Page Content -->
                <main class="flex-1">
                    {{ $slot }}
                </main>

                @include('components.footer')
            </div>
        @endif
    </body>
</html>
