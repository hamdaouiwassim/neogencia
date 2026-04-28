<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ __('Edit Customer Support Squad') }}</h2>
            <a href="{{ route('customer-support-squads.show', $customerSupportSquad) }}" class="inline-flex items-center text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">{{ __('Back') }}</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @include('admin.partials.alerts')
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-2xl rounded-3xl border border-gray-200/50 dark:border-gray-700/50">
                <form method="POST" action="{{ route('customer-support-squads.update', $customerSupportSquad) }}" id="squad-form">
                    @csrf
                    @method('PUT')
                    <div class="p-6 space-y-6">
                        <input type="text" name="name" value="{{ old('name', $customerSupportSquad->name) }}" required class="w-full rounded-xl border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all">
                        <textarea name="description" rows="3" class="w-full rounded-xl border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all">{{ old('description', $customerSupportSquad->description) }}</textarea>
                        <label class="flex items-center"><input type="checkbox" name="is_active" value="1" {{ old('is_active', $customerSupportSquad->is_active) ? 'checked' : '' }} class="rounded border-gray-300 dark:border-gray-600 text-indigo-600 focus:ring-indigo-500"><span class="ml-2 text-sm text-gray-700 dark:text-gray-300">{{ __('Active Squad') }}</span></label>
                        <div id="models-container" class="space-y-4"></div>
                        <div class="flex items-center gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                            <button type="button" onclick="addModelRow()" class="px-4 py-2.5 text-indigo-700 dark:text-indigo-300 bg-indigo-50 dark:bg-indigo-900/30 hover:bg-indigo-100 dark:hover:bg-indigo-900/50 font-semibold rounded-xl transition-all">{{ __('Add Model') }}</button>
                            <button type="submit" class="inline-flex items-center bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 px-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200">{{ __('Update Squad') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @php
        $existing = $customerSupportSquad->squadModels->map(fn ($sm) => ['model_id' => $sm->chatbot_model_id, 'task_role' => $sm->task_role, 'system_prompt' => $sm->system_prompt])->values()->all();
    @endphp
    <script>
        let modelRowCount = 0;
        const taskRoles = @json($taskRoles);
        const models = @json($models);
        const existingModels = @json($existing);

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
                    <button type="button" onclick="removeModelRow(${modelRowCount})" class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300">✕</button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <select name="models[${modelRowCount}][model_id]" required class="w-full rounded-xl border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20">
                        <option value="">Select model</option>
                        ${models.map(m => `<option value="${m.id}" ${m.id == selectedModelId ? 'selected' : ''}>${m.name}</option>`).join('')}
                    </select>
                    <select name="models[${modelRowCount}][task_role]" required class="w-full rounded-xl border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20">
                        <option value="">Select role</option>
                        ${Object.entries(taskRoles).map(([key, value]) => `<option value="${key}" ${key === selectedTaskRole ? 'selected' : ''}>${value}</option>`).join('')}
                    </select>
                </div>
                <textarea name="models[${modelRowCount}][system_prompt]" rows="2" class="w-full rounded-xl border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 text-sm">${systemPrompt}</textarea>
            `;
            container.appendChild(row);
            modelRowCount++;
        }

        function removeModelRow(index) {
            const row = document.getElementById(`model-row-${index}`);
            if (row) row.remove();
        }

        document.addEventListener('DOMContentLoaded', function () {
            if (existingModels.length > 0) {
                existingModels.forEach(model => addModelRow(model));
            } else {
                addModelRow();
            }
        });
    </script>
</x-app-layout>
