@props(['title' => 'Welcome', 'subtitle' => null])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - {{ $title }}</title>

        <!-- Favicon -->
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
        <link rel="manifest" href="{{ asset('site.webmanifest') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-50 dark:bg-gray-900">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">
            <!-- Background decoration -->
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div class="absolute -top-40 -right-40 w-80 h-80 bg-indigo-300 dark:bg-indigo-900 rounded-full mix-blend-multiply dark:mix-blend-soft-light filter blur-3xl opacity-30 animate-blob"></div>
                <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-purple-300 dark:bg-purple-900 rounded-full mix-blend-multiply dark:mix-blend-soft-light filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>
                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-80 h-80 bg-pink-300 dark:bg-pink-900 rounded-full mix-blend-multiply dark:mix-blend-soft-light filter blur-3xl opacity-30 animate-blob animation-delay-4000"></div>
            </div>

            <div class="relative w-full sm:max-w-md">
                <!-- Logo/Brand -->
                <div class="flex justify-center mb-8">
                    <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                        <div class="h-12 w-12 rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 flex items-center justify-center shadow-lg group-hover:shadow-xl transition-shadow">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <div class="text-left">
                            <h1 class="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                                Neogencia
                            </h1>
                            <p class="text-xs text-gray-600 dark:text-gray-400">AI Agents Marketplace</p>
                        </div>
                    </a>
                </div>

                <!-- Main Card -->
                <div class="bg-white dark:bg-gray-800 shadow-2xl rounded-2xl overflow-hidden border border-gray-200 dark:border-gray-700">
                    <!-- Card Header with Gradient -->
                    <div class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 px-8 py-6">
                        <h2 class="text-2xl font-bold text-white text-center">
                            {{ $title }}
                        </h2>
                        @if($subtitle)
                            <p class="text-indigo-100 text-sm text-center mt-2">{{ $subtitle }}</p>
                        @endif
                    </div>

                    <!-- Card Content -->
                    <div class="px-8 py-8">
                        {{ $slot }}
                    </div>
                </div>

                <!-- Footer Links -->
                <div class="mt-6 text-center space-y-2">
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        <a href="{{ route('home') }}" class="font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300 transition-colors">
                            ← Back to Home
                        </a>
                    </p>
                </div>
            </div>
        </div>

        <style>
            @keyframes blob {
                0%, 100% {
                    transform: translate(0px, 0px) scale(1);
                }
                33% {
                    transform: translate(30px, -50px) scale(1.1);
                }
                66% {
                    transform: translate(-20px, 20px) scale(0.9);
                }
            }
            .animate-blob {
                animation: blob 7s infinite;
            }
            .animation-delay-2000 {
                animation-delay: 2s;
            }
            .animation-delay-4000 {
                animation-delay: 4s;
            }
        </style>
    </body>
</html>