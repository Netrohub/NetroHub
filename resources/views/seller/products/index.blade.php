<x-layouts.app>
    <x-slot name="title">{{ __('My Products') }} - {{ config('app.name') }}</x-slot>

    <section class="relative pt-32 pb-12 md:pb-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            
            <div class="flex items-center justify-between mb-8">
                <h1 class="h2 bg-clip-text text-transparent bg-gradient-to-r from-slate-200/60 via-slate-200 to-slate-200/60">
                    {{ __('My Products') }}
                </h1>
                <a href="{{ route('sell.index') }}" class="btn text-white bg-purple-500 hover:bg-purple-600">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    {{ __('Add Product') }}
                </a>
            </div>

            <!-- Filters -->
            <div class="bg-slate-800/50 rounded-2xl p-6 border border-slate-700/50 mb-8" data-aos="fade-up">
                <form method="GET" class="grid md:grid-cols-3 gap-4">
                    <input type="search" name="search" placeholder="{{ __('Search products...') }}" value="{{ request('search') }}" class="form-input w-full">
                    <select name="status" onchange="this.form.submit()" class="form-select w-full">
                        <option value="">{{ __('All Statuses') }}</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>{{ __('Inactive') }}</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
                    </select>
                    <select name="category" onchange="this.form.submit()" class="form-select w-full">
                        <option value="">{{ __('All Categories') }}</option>
                        @foreach($categories ?? [] as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </form>
            </div>

            <!-- Products List -->
            @if(isset($products) && $products->count() > 0)
                <div class="space-y-4">
                    @foreach($products as $product)
                        <div class="bg-slate-800/50 rounded-2xl border border-slate-700/50 hover:border-purple-500/30 transition-colors overflow-hidden" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 5) * 50 }}">
                            <div class="p-6">
                                <div class="flex flex-col md:flex-row gap-6">
                                    <!-- Product Icon -->
                                    <div class="w-24 h-24 bg-slate-700 rounded-xl flex items-center justify-center flex-shrink-0">
                                        <x-platform-icon :product="$product" size="xl" />
                                    </div>

                                    <!-- Product Info -->
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-start justify-between mb-2">
                                            <h3 class="text-xl font-bold text-slate-100">{{ $product->title }}</h3>
                                            <span class="text-xs px-3 py-1 rounded-full {{ $product->status === 'active' ? 'bg-green-500/20 text-green-400' : 'bg-slate-600 text-slate-400' }}">
                                                {{ ucfirst($product->status) }}
                                            </span>
                                        </div>
                                        <p class="text-slate-400 text-sm mb-3 line-clamp-2">{{ $product->description }}</p>
                                        <div class="flex flex-wrap gap-4 text-sm">
                                            <span class="text-slate-400">
                                                <span class="text-slate-300 font-medium">{{ __('Price:') }}</span> ${{ number_format($product->price, 2) }}
                                            </span>
                                            <span class="text-slate-400">
                                                <span class="text-slate-300 font-medium">{{ __('Sales:') }}</span> {{ $product->sales_count ?? 0 }}
                                            </span>
                                            <span class="text-slate-400">
                                                <span class="text-slate-300 font-medium">{{ __('Stock:') }}</span> {{ $product->stock ?? 'N/A' }}
                                            </span>
                                            @if($product->category)
                                                <span class="text-slate-400">
                                                    <span class="text-slate-300 font-medium">{{ __('Category:') }}</span> {{ $product->category->name }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Actions -->
                                    <div class="flex md:flex-col gap-2 justify-end">
                                        <a href="{{ route('products.show', $product->slug) }}" class="btn text-slate-300 hover:text-white bg-slate-700 hover:bg-slate-600 text-sm">
                                            <svg class="w-4 h-4 md:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            <span class="hidden md:inline">{{ __('View') }}</span>
                                        </a>
                                        <a href="{{ route('seller.products.edit', $product) }}" class="btn text-white bg-purple-500 hover:bg-purple-600 text-sm">
                                            <svg class="w-4 h-4 md:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                            <span class="hidden md:inline">{{ __('Edit') }}</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if($products->hasPages())
                    <div class="mt-8">
                        {{ $products->links() }}
                    </div>
                @endif
            @else
                <div class="bg-slate-800/50 rounded-2xl p-12 border border-slate-700/50 text-center" data-aos="fade-up">
                    <div class="w-20 h-20 bg-slate-700 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-100 mb-2">{{ __('No products yet') }}</h3>
                    <p class="text-slate-400 mb-6">{{ __('Start selling by adding your first product') }}</p>
                    <a href="{{ route('seller.products.create') }}" class="btn text-white bg-purple-500 hover:bg-purple-600 inline-flex">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        {{ __('Add Product') }}
                    </a>
                </div>
            @endif
        </div>
    </section>
</x-layouts.app>
