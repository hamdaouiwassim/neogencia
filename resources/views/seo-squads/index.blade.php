<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ __('SEO Squads') }}</h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    @if(Auth::user()->isAdmin())
                        {{ __('Run multi-model SEO audits that produce clearer priorities and faster action.') }}
                    @else
                        {{ __('Use squads your administrator has published. Run analysis on any active squad.') }}
                    @endif
                </p>
            </div>
            @if(Auth::user()->isAdmin())
                <a href="{{ route('seo-squads.create') }}" class="inline-flex items-center bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 px-5 rounded-xl shadow-sm transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    {{ __('Create Squad') }}
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @include('admin.partials.alerts')

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-5 shadow-sm">
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">{{ __('Active Squads') }}</p>
                    <p class="mt-2 text-2xl font-bold text-gray-900 dark:text-white">{{ $squads->where('is_active', true)->count() }}</p>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ __('Ready to analyze pages right now.') }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-5 shadow-sm">
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">{{ __('Total Models Assigned') }}</p>
                    <p class="mt-2 text-2xl font-bold text-gray-900 dark:text-white">{{ $squads->sum(fn ($squad) => $squad->squadModels->count()) }}</p>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ __('Specialists covering technical + content + keyword tasks.') }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-5 shadow-sm">
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">{{ __('Workflow Value') }}</p>
                    <p class="mt-2 text-lg font-semibold text-gray-900 dark:text-white">{{ __('One brief, many expert outputs') }}</p>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ __('Reduce analysis time and focus on ranked next steps.') }}</p>
                </div>
            </div>

            @if($squads->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($squads as $squad)
                        <div class="bg-white dark:bg-gray-800 overflow-hidden rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition-shadow">
                            <div class="p-6">
                                <div class="flex items-start justify-between mb-4">
                                    <div class="flex-1">
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">{{ $squad->name }}</h3>
                                        @if($squad->description)
                                            <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2">{{ $squad->description }}</p>
                                        @else
                                            <p class="text-sm text-gray-500 dark:text-gray-400 line-clamp-2">{{ __('No description yet. Add one to clarify team goals.') }}</p>
                                        @endif
                                    </div>
                                    <div class="ml-3">
                                        @if($squad->is_active)
                                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">Active</span>
                                        @else
                                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">Inactive</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="mb-4 space-y-3">
                                    <div class="flex items-center justify-between text-sm">
                                        <div class="flex items-center text-gray-600 dark:text-gray-400">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                                        </svg>
                                        {{ $squad->squadModels->count() }} Model{{ $squad->squadModels->count() !== 1 ? 's' : '' }}
                                        </div>
                                        <span class="text-xs text-gray-500 dark:text-gray-400">{{ __('Updated ') }}{{ $squad->updated_at->diffForHumans() }}</span>
                                    </div>
                                    <div class="flex flex-wrap gap-1.5">
                                        @foreach($squad->squadModels->take(3) as $squadModel)
                                            <span class="px-2 py-0.5 text-xs font-medium rounded-lg bg-indigo-50 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300">
                                                {{ \App\Models\SeoSquad::getTaskRoles()[$squadModel->task_role] ?? $squadModel->task_role }}
                                            </span>
                                        @endforeach
                                        @if($squad->squadModels->count() > 3)
                                            <span class="px-2 py-0.5 text-xs font-medium rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400">
                                                +{{ $squad->squadModels->count() - 3 }} more
                                            </span>
                                        @endif
                                    </div>
                                    <div class="rounded-xl bg-gray-50 dark:bg-gray-900/40 border border-gray-200 dark:border-gray-700 px-3 py-2">
                                        <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">{{ __('Expected value') }}</p>
                                        <p class="text-sm text-gray-700 dark:text-gray-300 mt-1">{{ __('Get cross-checking recommendations so you can prioritize fixes with higher confidence.') }}</p>
                                    </div>
                                </div>

                                <div class="flex items-center gap-2 pt-4 border-t border-gray-200 dark:border-gray-700">
                                    <a href="{{ route('seo-squads.show', $squad) }}" class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        {{ __('Use Squad') }}
                                    </a>
                                    @if(Auth::user()->isAdmin())
                                        <a href="{{ route('seo-squads.edit', $squad) }}" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 font-semibold rounded-xl transition-all duration-200" title="{{ __('Edit') }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                        <form method="POST" action="{{ route('seo-squads.destroy', $squad) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this squad?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-4 py-2 bg-red-100 dark:bg-red-900/30 hover:bg-red-200 dark:hover:bg-red-900/50 text-red-700 dark:text-red-300 font-semibold rounded-xl transition-all duration-200" title="{{ __('Delete') }}">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white dark:bg-gray-800 overflow-hidden rounded-2xl border border-gray-200 dark:border-gray-700 p-12 text-center shadow-sm">
                    <div class="w-16 h-16 bg-indigo-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ __('No SEO Squads Yet') }}</h3>
                    @if(Auth::user()->isAdmin())
                        <p class="text-gray-600 dark:text-gray-400 mb-6">{{ __('Build a squad of specialist roles (technical, content, keywords) and get a sharper action plan per page.') }}</p>
                        <a href="{{ route('seo-squads.create') }}" class="inline-flex items-center bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 px-6 rounded-xl shadow-sm transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            {{ __('Create Your First Squad') }}
                        </a>
                    @else
                        <p class="text-gray-600 dark:text-gray-400">{{ __('There are no active SEO squads available. Ask an administrator to create and publish one.') }}</p>
                    @endif
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
