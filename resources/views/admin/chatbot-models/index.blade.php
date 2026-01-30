<x-app-layout>
    <x-slot name="header">
        @include('admin.partials.header', ['title' => __('Chatbot Models'), 'subtitle' => __('Manage AI models for the chatbot test page')])
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @include('admin.partials.alerts')

            <!-- Add Model Form -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-2xl rounded-3xl border border-gray-200/50 dark:border-gray-700/50 p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Add Chatbot Model</h3>
                </div>
                <form method="POST" action="{{ route('admin.chatbot-models.store') }}" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Display Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                   class="w-full rounded-xl border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all"
                                   placeholder="e.g. Mistral 7B Instruct">
                        </div>
                        <div>
                            <label for="api_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">API Model Name</label>
                            <input type="text" name="api_name" id="api_name" value="{{ old('api_name') }}" required
                                   class="w-full rounded-xl border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 font-mono text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all"
                                   placeholder="e.g. mistralai/Mistral-7B-Instruct-v0.2">
                        </div>
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" name="is_default" id="is_default" value="1" {{ old('is_default') ? 'checked' : '' }}
                               class="rounded border-gray-300 dark:border-gray-600 text-indigo-600 focus:ring-indigo-500">
                        <label for="is_default" class="ml-2 text-sm text-gray-700 dark:text-gray-300">Set as default model</label>
                    </div>
                    <button type="submit" class="inline-flex items-center bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 px-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Add Model
                    </button>
                </form>
            </div>

            <!-- Models Table -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-2xl rounded-3xl border border-gray-200/50 dark:border-gray-700/50">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Display Name</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">API Name</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Default</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($models as $model)
                                <tr class="hover:bg-gray-50/80 dark:hover:bg-gray-700/80 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $model->name }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400 font-mono">
                                        {{ $model->api_name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($model->is_default)
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">Default</span>
                                        @else
                                            <form method="POST" action="{{ route('admin.chatbot-models.set-default', $model) }}" class="inline">
                                                @csrf
                                                <button type="submit" class="text-xs text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 font-medium">
                                                    Set as default
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-2">
                                            <button type="button" onclick="editModel({{ json_encode($model) }})"
                                                    class="inline-flex items-center px-3 py-1.5 text-xs font-semibold text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-xl transition-all duration-200">
                                                Edit
                                            </button>
                                            <form method="POST" action="{{ route('admin.chatbot-models.destroy', $model) }}" class="inline" onsubmit="return confirm('Delete this model?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center px-3 py-1.5 text-xs font-semibold text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-xl transition-all duration-200">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-sm text-gray-500 dark:text-gray-400">
                                        No chatbot models yet. Add one above or run <code class="bg-gray-100 dark:bg-gray-700 px-1 rounded">php artisan db:seed --class=ChatbotModelSeeder</code>.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Edit Modal -->
            <div id="edit-modal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-modal="true">
                <div class="flex items-center justify-center min-h-screen px-4">
                    <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="closeEditModal()"></div>
                    <div class="relative bg-white dark:bg-gray-800 rounded-3xl shadow-2xl border border-gray-200/50 dark:border-gray-700/50 max-w-md w-full p-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Edit Chatbot Model</h3>
                        <form id="edit-form" method="POST" action="#" data-action-base="{{ route('admin.chatbot-models.update', ['chatbotModel' => 0]) }}" class="space-y-4">
                            @csrf
                            @method('PUT')
                            <div>
                                <label for="edit_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Display Name</label>
                                <input type="text" name="name" id="edit_name" required
                                       class="w-full rounded-xl border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20">
                            </div>
                            <div>
                                <label for="edit_api_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">API Model Name</label>
                                <input type="text" name="api_name" id="edit_api_name" required
                                       class="w-full rounded-xl border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 font-mono text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20">
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" name="is_default" id="edit_is_default" value="1"
                                       class="rounded border-gray-300 dark:border-gray-600 text-indigo-600 focus:ring-indigo-500">
                                <label for="edit_is_default" class="ml-2 text-sm text-gray-700 dark:text-gray-300">Set as default model</label>
                            </div>
                            <div class="flex justify-end gap-2 pt-2">
                                <button type="button" onclick="closeEditModal()" class="px-4 py-2.5 text-sm font-semibold text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-all">
                                    Cancel
                                </button>
                                <button type="submit" class="px-4 py-2.5 text-sm font-semibold text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 shadow-lg transition-all">
                                    Update
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function editModel(model) {
            const form = document.getElementById('edit-form');
            const base = form.getAttribute('data-action-base');
            form.action = base.replace(/\/0$/, '/' + model.id);
            document.getElementById('edit_name').value = model.name;
            document.getElementById('edit_api_name').value = model.api_name;
            document.getElementById('edit_is_default').checked = model.is_default;
            document.getElementById('edit-modal').classList.remove('hidden');
        }
        function closeEditModal() {
            document.getElementById('edit-modal').classList.add('hidden');
        }
    </script>
</x-app-layout>
