<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ __('Customer Support Squads') }}</h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    @if(Auth::user()->isAdmin())
                        {{ __('Build multi-model support teams to test better replies before sending to customers.') }}
                    @else
                        {{ __('Run tests on support squads your administrator has published.') }}
                    @endif
                </p>
            </div>
            @if(Auth::user()->isAdmin())
                <a href="{{ route('customer-support-squads.create') }}" class="inline-flex items-center bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 px-5 rounded-xl shadow-sm transition-colors">
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

            @if($squads->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($squads as $squad)
                        <div class="bg-white dark:bg-gray-800 overflow-hidden rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition-shadow">
                            <div class="p-6">
                                <div class="flex items-start justify-between mb-4">
                                    <div class="flex-1">
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">{{ $squad->name }}</h3>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2">{{ $squad->description ?: __('No description yet.') }}</p>
                                    </div>
                                    <span class="ml-3 px-2.5 py-1 text-xs font-semibold rounded-full {{ $squad->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                                        {{ $squad->is_active ? __('Active') : __('Inactive') }}
                                    </span>
                                </div>

                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                                    {{ $squad->squadModels->count() }} {{ __('models configured') }}
                                </p>

                                <div class="flex items-center gap-2 pt-4 border-t border-gray-200 dark:border-gray-700">
                                    <a href="{{ route('customer-support-squads.show', $squad) }}" class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl transition-all">
                                        {{ __('Use Squad') }}
                                    </a>
                                    @if(Auth::user()->isAdmin())
                                        <a href="{{ route('customer-support-squads.edit', $squad) }}" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 font-semibold rounded-xl transition-all">
                                            {{ __('Edit') }}
                                        </a>
                                        <form method="POST" action="{{ route('customer-support-squads.destroy', $squad) }}" onsubmit="return confirm('{{ __('Delete this squad?') }}');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-4 py-2 bg-red-100 dark:bg-red-900/30 hover:bg-red-200 dark:hover:bg-red-900/50 text-red-700 dark:text-red-300 font-semibold rounded-xl transition-all">
                                                {{ __('Delete') }}
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
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ __('No Support Squads Yet') }}</h3>
                    @if(Auth::user()->isAdmin())
                        <p class="text-gray-600 dark:text-gray-400 mb-6">{{ __('Create a customer support squad and start testing support responses.') }}</p>
                        <a href="{{ route('customer-support-squads.create') }}" class="inline-flex items-center bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 px-6 rounded-xl shadow-sm transition-colors">
                            {{ __('Create Your First Squad') }}
                        </a>
                    @else
                        <p class="text-gray-600 dark:text-gray-400">{{ __('There are no active support squads available. Ask an administrator to create and publish one.') }}</p>
                    @endif
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
