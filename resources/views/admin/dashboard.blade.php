<x-app-layout>
    <x-slot name="header">
        @include('admin.partials.header', ['title' => __('Admin Dashboard'), 'subtitle' => __('Overview of your platform')])
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            @include('admin.partials.alerts')

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-2xl rounded-3xl border border-gray-200/50 dark:border-gray-700/50">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total Users</p>
                                <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['total_users'] }}</p>
                            </div>
                            <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <a href="{{ route('admin.users') }}" class="mt-4 inline-flex items-center text-sm font-medium text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
                            View users
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-2xl rounded-3xl border border-gray-200/50 dark:border-gray-700/50">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total Agents</p>
                                <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['total_agents'] }}</p>
                            </div>
                            <div class="w-14 h-14 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                        </div>
                        <a href="{{ route('admin.agents') }}" class="mt-4 inline-flex items-center text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300">
                            View agents
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-2xl rounded-3xl border border-gray-200/50 dark:border-gray-700/50">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total Reviews</p>
                                <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['total_reviews'] }}</p>
                            </div>
                            <div class="w-14 h-14 bg-gradient-to-br from-amber-500 to-orange-500 rounded-2xl flex items-center justify-center shadow-lg">
                                <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                            </div>
                        </div>
                        <a href="{{ route('admin.reviews') }}" class="mt-4 inline-flex items-center text-sm font-medium text-amber-600 dark:text-amber-400 hover:text-amber-800 dark:hover:text-amber-300">
                            View reviews
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-2xl rounded-3xl border-2 border-red-200 dark:border-red-800">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-semibold text-red-600 dark:text-red-400 uppercase tracking-wider">Pending Agents</p>
                                <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['pending_agents'] }}</p>
                            </div>
                            <div class="w-14 h-14 bg-gradient-to-br from-red-500 to-red-600 rounded-2xl flex items-center justify-center shadow-lg">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <a href="{{ route('admin.agents', ['status' => 'pending']) }}" class="mt-4 inline-flex items-center text-sm font-medium text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300">
                            Review pending
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-2xl rounded-3xl border border-gray-200/50 dark:border-gray-700/50">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-indigo-50 to-purple-50 dark:from-indigo-900/20 dark:to-purple-900/20">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Quick Actions</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Jump to common admin tasks</p>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <a href="{{ route('admin.agents', ['status' => 'pending']) }}" class="flex items-center p-5 rounded-2xl bg-red-50 dark:bg-red-900/20 border-2 border-red-200 dark:border-red-800 hover:bg-red-100 dark:hover:bg-red-900/30 hover:border-red-400 dark:hover:border-red-600 transition-all duration-200 group">
                            <div class="w-12 h-12 bg-red-500 rounded-xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="font-bold text-red-900 dark:text-red-200">Review Pending Agents</div>
                                <div class="text-sm text-red-700 dark:text-red-300">{{ $stats['pending_agents'] }} pending</div>
                            </div>
                        </a>
                        <a href="{{ route('admin.users') }}" class="flex items-center p-5 rounded-2xl bg-blue-50 dark:bg-blue-900/20 border-2 border-blue-200 dark:border-blue-800 hover:bg-blue-100 dark:hover:bg-blue-900/30 hover:border-blue-400 dark:hover:border-blue-600 transition-all duration-200 group">
                            <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="font-bold text-blue-900 dark:text-blue-200">Manage Users</div>
                                <div class="text-sm text-blue-700 dark:text-blue-300">{{ $stats['total_users'] }} users</div>
                            </div>
                        </a>
                        <a href="{{ route('admin.reviews') }}" class="flex items-center p-5 rounded-2xl bg-amber-50 dark:bg-amber-900/20 border-2 border-amber-200 dark:border-amber-800 hover:bg-amber-100 dark:hover:bg-amber-900/30 hover:border-amber-400 dark:hover:border-amber-600 transition-all duration-200 group">
                            <div class="w-12 h-12 bg-amber-500 rounded-xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="font-bold text-amber-900 dark:text-amber-200">Manage Reviews</div>
                                <div class="text-sm text-amber-700 dark:text-amber-300">{{ $stats['total_reviews'] }} reviews</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-2xl rounded-3xl border border-gray-200/50 dark:border-gray-700/50">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-indigo-50 to-purple-50 dark:from-indigo-900/20 dark:to-purple-900/20">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Recent Users</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Latest registered users</p>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            @foreach($stats['recent_users'] as $user)
                                <div class="flex items-center justify-between p-4 rounded-xl bg-gray-50 dark:bg-gray-900/50 hover:bg-gray-100 dark:hover:bg-gray-800/50 transition-colors">
                                    <div class="flex items-center space-x-3">
                                        <div class="h-11 w-11 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-500 flex items-center justify-center text-white font-bold text-sm shadow-md">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-900 dark:text-white">{{ $user->name }}</p>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $user->email }}</p>
                                        </div>
                                    </div>
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full
                                        {{ $user->role === 'admin' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' : '' }}
                                        {{ $user->role === 'creator' ? 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200' : '' }}
                                        {{ $user->role === 'user' ? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200' : '' }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                        <a href="{{ route('admin.users') }}" class="mt-4 inline-flex items-center px-4 py-2 text-sm font-semibold text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 bg-indigo-50 dark:bg-indigo-900/20 hover:bg-indigo-100 dark:hover:bg-indigo-900/30 rounded-xl transition-colors">
                            View All Users
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-2xl rounded-3xl border border-gray-200/50 dark:border-gray-700/50">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-900/20 dark:to-teal-900/20">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Recent Agents</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Latest submitted agents</p>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            @foreach($stats['recent_agents'] as $agent)
                                <div class="flex items-center justify-between p-4 rounded-xl bg-gray-50 dark:bg-gray-900/50 hover:bg-gray-100 dark:hover:bg-gray-800/50 transition-colors">
                                    <div class="flex-1 min-w-0">
                                        <p class="font-semibold text-gray-900 dark:text-white truncate">{{ $agent->name }}</p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">by {{ $agent->user->name }}</p>
                                    </div>
                                    <div class="flex items-center space-x-2 ml-4">
                                        @if($agent->is_approved)
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">Approved</span>
                                        @else
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">Pending</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <a href="{{ route('admin.agents') }}" class="mt-4 inline-flex items-center px-4 py-2 text-sm font-semibold text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 bg-indigo-50 dark:bg-indigo-900/20 hover:bg-indigo-100 dark:hover:bg-indigo-900/30 rounded-xl transition-colors">
                            View All Agents
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
