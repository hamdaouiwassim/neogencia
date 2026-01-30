<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Edit SEO Squad') }}
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Update your squad configuration</p>
            </div>
            <a href="{{ route('seo-squads.show', $seoSquad) }}" class="inline-flex items-center text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @include('admin.partials.alerts')

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-2xl rounded-3xl border border-gray-200/50 dark:border-gray-700/50">
                <form method="POST" action="{{ route('seo-squads.update', $seoSquad) }}" id="squad-form">
                    @csrf
                    @method('PUT')

                    <div class="p-6 space-y-6">
                        <!-- Basic Information -->
                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Squad Name *</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $seoSquad->name) }}" required
                                   class="w-full rounded-xl border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Description</label>
                            <textarea name="description" id="description" rows="3"
                                      class="w-full rounded-xl border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all">{{ old('description', $seoSquad->description) }}</textarea>
                        </div>

                        <div>
                            <label class="flex items-center">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $seoSquad->is_active) ? 'checked' : '' }}
                                       class="rounded border-gray-300 dark:border-gray-600 text-indigo-600 focus:ring-indigo-500">
                                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Active Squad</span>
                            </label>
                        </div>

                        <!-- Models Section -->
                        <div>
                            <div class="flex items-center justify-between mb-4">
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Squad Models *</label>
                                <button type="button" onclick="addModelRow()" class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/30 hover:bg-indigo-100 dark:hover:bg-indigo-900/50 rounded-xl transition-all">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Add Model
                                </button>
                            </div>

                            <div id="models-container" class="space-y-4">
                                <!-- Existing models will be populated here -->
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                            <button type="submit" class="inline-flex items-center bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 px-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Update Squad
                            </button>
                            <a href="{{ route('seo-squads.show', $seoSquad) }}" class="px-4 py-2.5 text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 font-semibold rounded-xl transition-all">
                                Cancel
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let modelRowCount = 0;
        const taskRoles = @json($taskRoles);
        const models = @json($models);
        const existingModels = @json($seoSquad->squadModels->map(function($sm) {
            return [
                'model_id' => $sm->chatbot_model_id,
                'task_role' => $sm->task_role,
                'system_prompt' => $sm->system_prompt,
            ];
        }));

        function addModelRow(modelData = null) {
            const container = document.getElementById('models-container');
            const row = document.createElement('div');
            row.className = 'bg-gray-50 dark:bg-gray-900/50 rounded-xl p-4 border-2 border-gray-200 dark:border-gray-700';
            row.id = `model-row-${modelRowCount}`;
            
            const selectedModelId = modelData ? modelData.model_id : '';
            const selectedTaskRole = modelData ? modelData.task_role : '';
            const systemPrompt = modelData ? (modelData.system_prompt || '') : '';
            
            row.innerHTML = `
                <div class="flex items-start justify-between mb-3">
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Model ${modelRowCount + 1}</span>
                    <button type="button" onclick="removeModelRow(${modelRowCount})" class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">AI Model *</label>
                        <select name="models[${modelRowCount}][model_id]" required
                                class="w-full rounded-xl border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20">
                            <option value="">Select a model</option>
                            ${models.map(m => `<option value="${m.id}" ${m.id == selectedModelId ? 'selected' : ''}>${m.name}</option>`).join('')}
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Task Role *</label>
                        <select name="models[${modelRowCount}][task_role]" required
                                class="w-full rounded-xl border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20">
                            <option value="">Select a task</option>
                            ${Object.entries(taskRoles).map(([key, value]) => `<option value="${key}" ${key === selectedTaskRole ? 'selected' : ''}>${value}</option>`).join('')}
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Custom System Prompt (Optional)</label>
                    <textarea name="models[${modelRowCount}][system_prompt]" rows="2"
                              class="w-full rounded-xl border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 text-sm">${systemPrompt}</textarea>
                </div>
            `;
            
            container.appendChild(row);
            modelRowCount++;
        }

        function removeModelRow(index) {
            const row = document.getElementById(`model-row-${index}`);
            if (row) {
                row.remove();
            }
        }

        // Populate existing models on page load
        document.addEventListener('DOMContentLoaded', function() {
            if (existingModels.length > 0) {
                existingModels.forEach(model => {
                    addModelRow(model);
                });
            } else {
                addModelRow();
            }
        });

        // Validate form before submit
        document.getElementById('squad-form').addEventListener('submit', function(e) {
            const container = document.getElementById('models-container');
            if (container.children.length === 0) {
                e.preventDefault();
                alert('Please add at least one model to the squad.');
                return false;
            }
        });
    </script>
</x-app-layout>
