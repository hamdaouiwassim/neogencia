<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-3xl text-gray-900 dark:text-white leading-tight">
                    {{ __('Submit New AI Agent') }}
                </h2>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Share your AI agent with the community</p>
            </div>
            <a href="{{ route('home') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </a>
        </div>
    </x-slot>

    <div class="py-8 md:py-12">
        <div class="max-w-4xl mx-auto sm:px-4 lg:px-8">
            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-6 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-200 px-4 py-3 rounded-lg shadow-sm flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-2xl sm:rounded-3xl border border-gray-200 dark:border-gray-700">
                <!-- Header Section -->
                <div class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 px-8 py-6">
                    <div class="flex items-center space-x-3">
                        <div class="h-12 w-12 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-white">Agent Information</h3>
                            <p class="text-indigo-100 text-sm">Fill in the details below to submit your AI agent</p>
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('agents.store') }}" enctype="multipart/form-data" class="p-8 md:p-10">
                    @csrf

                    <div class="space-y-8">
                        <!-- Basic Information Section -->
                        <div class="space-y-6">
                            <div class="flex items-center space-x-2 pb-4 border-b border-gray-200 dark:border-gray-700">
                                <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Basic Information</h4>
                            </div>

                            <!-- Agent Name -->
                            <div>
                                <x-input-label for="name" :value="__('Agent/Model Name')" />
                                <div class="mt-2 relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <x-text-input 
                                        id="name" 
                                        class="block w-full pl-10" 
                                        type="text" 
                                        name="name" 
                                        :value="old('name')" 
                                        required 
                                        autofocus
                                        placeholder="Enter agent name (e.g., GPT-4, Claude AI)"
                                    />
                                </div>
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Choose a clear and descriptive name</p>
                            </div>

                            <!-- Category -->
                            <div>
                                <x-input-label for="category_id" :value="__('Category')" />
                                <div class="mt-2 relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none z-10">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                        </svg>
                                    </div>
                                    <select 
                                        id="category_id" 
                                        name="category_id" 
                                        class="block w-full pl-10 rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-2 focus:ring-indigo-500/20 dark:focus:ring-indigo-600/20 shadow-sm transition-all duration-200" 
                                        required
                                    >
                                        <option value="">Select a category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                            </div>

                            <!-- Description -->
                            <div>
                                <x-input-label for="description" :value="__('Description')" />
                                <div class="mt-2">
                                    <textarea 
                                        id="description" 
                                        name="description" 
                                        rows="5" 
                                        class="block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-2 focus:ring-indigo-500/20 dark:focus:ring-indigo-600/20 shadow-sm transition-all duration-200" 
                                        required
                                        placeholder="Describe what your AI agent does, its key features, and use cases..."
                                    >{{ old('description') }}</textarea>
                                </div>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Provide a detailed description to help users understand your agent</p>
                            </div>
                        </div>

                        <!-- Links & Resources Section -->
                        <div class="space-y-6">
                            <div class="flex items-center space-x-2 pb-4 border-b border-gray-200 dark:border-gray-700">
                                <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                </svg>
                                <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Links & Resources</h4>
                            </div>

                            <!-- Agent URL/Link -->
                            <div>
                                <x-input-label for="link" :value="__('Agent URL')" />
                                <div class="mt-2 relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                        </svg>
                                    </div>
                                    <x-text-input 
                                        id="link" 
                                        class="block w-full pl-10" 
                                        type="url" 
                                        name="link" 
                                        :value="old('link')" 
                                        placeholder="https://your-agent-url.com" 
                                        required 
                                    />
                                </div>
                                <x-input-error :messages="$errors->get('link')" class="mt-2" />
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">The main URL where users can access or use your agent</p>
                            </div>

                            <!-- Documentation URL -->
                            <div>
                                <x-input-label for="documentation" :value="__('Documentation URL')" />
                                <div class="mt-2 relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                        </svg>
                                    </div>
                                    <x-text-input 
                                        id="documentation" 
                                        class="block w-full pl-10" 
                                        type="url" 
                                        name="documentation" 
                                        :value="old('documentation')" 
                                        placeholder="https://docs.example.com (Optional)"
                                    />
                                </div>
                                <x-input-error :messages="$errors->get('documentation')" class="mt-2" />
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Link to documentation, API reference, or user guide (optional but recommended)</p>
                            </div>
                        </div>

                        <!-- Visual & Media Section -->
                        <div class="space-y-6">
                            <div class="flex items-center space-x-2 pb-4 border-b border-gray-200 dark:border-gray-700">
                                <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Featured Image</h4>
                            </div>

                            <!-- Featured Image URL -->
                            <div>
                                <x-input-label for="featured_image" :value="__('Featured Image URL')" />
                                <div class="mt-2 relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <x-text-input 
                                        id="featured_image" 
                                        class="block w-full pl-10" 
                                        type="url" 
                                        name="featured_image" 
                                        :value="old('featured_image')" 
                                        placeholder="https://example.com/image.jpg"
                                        onchange="previewImage(this.value)"
                                    />
                                </div>
                                <x-input-error :messages="$errors->get('featured_image')" class="mt-2" />
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Add a URL to a high-quality image that represents your agent (recommended: 1200x630px)</p>
                                
                                <!-- Image Preview -->
                                <div id="image-preview" class="mt-4 hidden">
                                    <div class="rounded-lg border-2 border-gray-200 dark:border-gray-700 overflow-hidden bg-gray-50 dark:bg-gray-900">
                                        <img id="preview-img" src="" alt="Preview" class="w-full h-48 object-cover">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pricing Section -->
                        <div class="space-y-6">
                            <div class="flex items-center space-x-2 pb-4 border-b border-gray-200 dark:border-gray-700">
                                <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Pricing</h4>
                            </div>

                            <!-- Pricing Type -->
                            <div>
                                <x-input-label for="pricing_type" :value="__('Pricing Type')" />
                                <div class="mt-2 grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <label class="relative flex cursor-pointer rounded-xl border-2 p-4 focus:outline-none pricing-option border-gray-200 dark:border-gray-700 hover:border-indigo-300 dark:hover:border-indigo-600 transition-all" data-value="free">
                                        <input type="radio" name="pricing_type" value="free" class="sr-only" {{ old('pricing_type', 'free') == 'free' ? 'checked' : '' }} />
                                        <div class="flex flex-1">
                                            <div class="flex flex-col">
                                                <span class="block text-sm font-medium text-gray-900 dark:text-white">Free</span>
                                                <span class="mt-1 flex items-center text-sm text-gray-500 dark:text-gray-400">Completely free to use</span>
                                            </div>
                                        </div>
                                        <svg class="h-5 w-5 text-indigo-600 dark:text-indigo-400 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </label>

                                    <label class="relative flex cursor-pointer rounded-xl border-2 p-4 focus:outline-none pricing-option border-gray-200 dark:border-gray-700 hover:border-indigo-300 dark:hover:border-indigo-600 transition-all" data-value="freemium">
                                        <input type="radio" name="pricing_type" value="freemium" class="sr-only" {{ old('pricing_type') == 'freemium' ? 'checked' : '' }} />
                                        <div class="flex flex-1">
                                            <div class="flex flex-col">
                                                <span class="block text-sm font-medium text-gray-900 dark:text-white">Freemium</span>
                                                <span class="mt-1 flex items-center text-sm text-gray-500 dark:text-gray-400">Free with paid options</span>
                                            </div>
                                        </div>
                                        <svg class="h-5 w-5 text-indigo-600 dark:text-indigo-400 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </label>

                                    <label class="relative flex cursor-pointer rounded-xl border-2 p-4 focus:outline-none pricing-option border-gray-200 dark:border-gray-700 hover:border-indigo-300 dark:hover:border-indigo-600 transition-all" data-value="paid">
                                        <input type="radio" name="pricing_type" value="paid" class="sr-only" {{ old('pricing_type') == 'paid' ? 'checked' : '' }} />
                                        <div class="flex flex-1">
                                            <div class="flex flex-col">
                                                <span class="block text-sm font-medium text-gray-900 dark:text-white">Paid</span>
                                                <span class="mt-1 flex items-center text-sm text-gray-500 dark:text-gray-400">Requires payment</span>
                                            </div>
                                        </div>
                                        <svg class="h-5 w-5 text-indigo-600 dark:text-indigo-400 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </label>
                                </div>
                                <x-input-error :messages="$errors->get('pricing_type')" class="mt-2" />
                            </div>

                            <!-- Price -->
                            <div id="price-field" style="display: none;">
                                <x-input-label for="price" :value="__('Price (USD)')" />
                                <div class="mt-2 relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm font-medium">$</span>
                                    </div>
                                    <x-text-input 
                                        id="price" 
                                        class="block w-full pl-8" 
                                        type="number" 
                                        name="price" 
                                        step="0.01" 
                                        min="0" 
                                        :value="old('price', 0)" 
                                        placeholder="0.00"
                                    />
                                </div>
                                <x-input-error :messages="$errors->get('price')" class="mt-2" />
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Enter the price in USD per month or per use</p>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="mt-10 pt-8 border-t border-gray-200 dark:border-gray-700 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <a href="{{ route('home') }}" class="px-6 py-3 text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white font-medium transition-colors flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Cancel
                        </a>
                        <button type="submit" class="w-full sm:w-auto bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold py-3 px-8 rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-[1.02] inline-flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            {{ __('Submit Agent') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Pricing option selection
        document.querySelectorAll('.pricing-option').forEach(option => {
            option.addEventListener('click', function() {
                // Remove selected state from all options
                document.querySelectorAll('.pricing-option').forEach(opt => {
                    opt.classList.remove('border-indigo-500', 'bg-indigo-50', 'dark:bg-indigo-900/20');
                    opt.querySelector('svg').classList.add('hidden');
                    opt.querySelector('input').checked = false;
                });

                // Add selected state to clicked option
                this.classList.add('border-indigo-500', 'bg-indigo-50', 'dark:bg-indigo-900/20');
                this.querySelector('svg').classList.remove('hidden');
                this.querySelector('input').checked = true;

                // Show/hide price field
                const priceField = document.getElementById('price-field');
                const value = this.querySelector('input').value;
                if (value === 'paid' || value === 'freemium') {
                    priceField.style.display = 'block';
                } else {
                    priceField.style.display = 'none';
                }
            });

            // Check if option is pre-selected
            if (option.querySelector('input').checked) {
                option.classList.add('border-indigo-500', 'bg-indigo-50', 'dark:bg-indigo-900/20');
                option.querySelector('svg').classList.remove('hidden');
                
                const value = option.querySelector('input').value;
                const priceField = document.getElementById('price-field');
                if (value === 'paid' || value === 'freemium') {
                    priceField.style.display = 'block';
                }
            }
        });

        // Image preview
        function previewImage(url) {
            const previewDiv = document.getElementById('image-preview');
            const previewImg = document.getElementById('preview-img');
            
            if (url && url.trim() !== '') {
                previewImg.src = url;
                previewImg.onerror = function() {
                    previewDiv.classList.add('hidden');
                };
                previewImg.onload = function() {
                    previewDiv.classList.remove('hidden');
                };
            } else {
                previewDiv.classList.add('hidden');
            }
        }

        // Preview image on page load if value exists
        document.addEventListener('DOMContentLoaded', function() {
            const imageInput = document.getElementById('featured_image');
            if (imageInput.value) {
                previewImage(imageInput.value);
            }
        });
    </script>

    <style>
        .pricing-option input:checked + * {
            display: block;
        }
        .pricing-option:hover {
            transform: translateY(-2px);
        }
    </style>
</x-app-layout>