<x-layouts.stellar>
    <x-slot name="title">{{ __('Add Product') }} - {{ config('app.name') }}</x-slot>

    <section class="relative pt-32 pb-12 md:pb-20">
        <div class="max-w-4xl mx-auto px-4 sm:px-6">
            
            <div class="mb-8">
                <a href="{{ route('seller.products.index') }}" class="inline-flex items-center text-purple-400 hover:text-purple-300 text-sm mb-4">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    {{ __('Back to Products') }}
                </a>
                <h1 class="h2 bg-clip-text text-transparent bg-gradient-to-r from-slate-200/60 via-slate-200 to-slate-200/60">
                    {{ __('Add New Product') }}
                </h1>
            </div>

            <form action="{{ route('seller.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Basic Information -->
                <div class="bg-slate-800/50 rounded-2xl p-6 lg:p-8 border border-slate-700/50" data-aos="fade-up">
                    <h2 class="text-lg font-bold text-slate-100 mb-6">{{ __('Basic Information') }}</h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm text-slate-300 font-medium mb-2">{{ __('Product Title') }} <span class="text-red-400">*</span></label>
                            <input type="text" name="title" value="{{ old('title') }}" class="form-input w-full" required>
                            @error('title')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm text-slate-300 font-medium mb-2">{{ __('Description') }} <span class="text-red-400">*</span></label>
                            <textarea name="description" rows="4" class="form-textarea w-full" required>{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm text-slate-300 font-medium mb-2">{{ __('Category') }} <span class="text-red-400">*</span></label>
                                <select name="category_id" class="form-select w-full" required>
                                    <option value="">{{ __('Select category') }}</option>
                                    @foreach($categories ?? [] as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm text-slate-300 font-medium mb-2">{{ __('Price') }} <span class="text-red-400">*</span></label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">$</span>
                                    <input type="number" name="price" step="0.01" min="0" value="{{ old('price') }}" class="form-input w-full pl-8" required>
                                </div>
                                @error('price')
                                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product Details -->
                <div class="bg-slate-800/50 rounded-2xl p-6 lg:p-8 border border-slate-700/50" data-aos="fade-up" data-aos-delay="100">
                    <h2 class="text-lg font-bold text-slate-100 mb-6">{{ __('Product Details') }}</h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm text-slate-300 font-medium mb-2">{{ __('Product Type') }} <span class="text-red-400">*</span></label>
                            <select name="type" class="form-select w-full" required>
                                <option value="digital">{{ __('Digital Product') }}</option>
                                <option value="account">{{ __('Game Account') }}</option>
                                <option value="service">{{ __('Service') }}</option>
                                <option value="credential">{{ __('Credentials') }}</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm text-slate-300 font-medium mb-2">{{ __('Stock Quantity') }}</label>
                            <input type="number" name="stock" min="0" value="{{ old('stock', 1) }}" class="form-input w-full">
                            <p class="text-xs text-slate-500 mt-1">{{ __('Leave blank for unlimited') }}</p>
                        </div>

                        <div>
                            <label class="block text-sm text-slate-300 font-medium mb-2">{{ __('Product Files/Content') }}</label>
                            <input type="file" name="files[]" multiple class="form-input w-full">
                            <p class="text-xs text-slate-500 mt-1">{{ __('Upload product files, images, or credentials') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex gap-4" data-aos="fade-up" data-aos-delay="200">
                    <button type="submit" class="btn text-white bg-purple-500 hover:bg-purple-600">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        {{ __('Publish Product') }}
                    </button>
                    <a href="{{ route('seller.products.index') }}" class="btn text-slate-300 hover:text-white bg-slate-700 hover:bg-slate-600">
                        {{ __('Cancel') }}
                    </a>
                </div>
            </form>
        </div>
    </section>
</x-layouts.stellar>
