<x-layouts.stellar>
    <x-slot name="title">{{ __('Products') }} - {{ config('app.name') }}</x-slot>

    <!-- Hero Section -->
    <section class="relative pt-32 pb-12 md:pb-16">
        <div class="absolute inset-0 -z-10 -mx-28 rounded-b-[3rem] pointer-events-none overflow-hidden" aria-hidden="true">
            <div class="absolute left-1/2 -translate-x-1/2 bottom-0 -z-10">
                <img src="{{ asset('stellar-assets/images/glow-bottom.svg') }}" class="max-w-none" width="2146" height="774" alt="Hero Illustration">
            </div>
        </div>

        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="text-center">
                <h1 class="h1 bg-clip-text text-transparent bg-gradient-to-r from-slate-200/60 via-slate-200 to-slate-200/60 pb-4" data-aos="fade-down">
                    {{ __('Digital Products') }}
                </h1>
                <p class="text-lg text-slate-300 max-w-2xl mx-auto" data-aos="fade-down" data-aos-delay="200">
                    {{ __('Browse our premium selection of digital products, gaming accounts, and exclusive services') }}
                </p>
            </div>
        </div>
    </section>

    <!-- Filters & Search -->
    <section class="pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="bg-slate-800/50 rounded-2xl p-6 backdrop-blur-sm border border-slate-700/50">
                <form method="GET" action="{{ route('products.index') }}" class="grid md:grid-cols-4 gap-4">
                    <!-- Search -->
                    <div class="md:col-span-2">
                        <input 
                            type="search" 
                            name="search"
                            placeholder="{{ __('Search products...') }}" 
                            class="form-input w-full"
                            value="{{ request('search') }}"
                        />
                    </div>
                    
                    <!-- Category Filter -->
                    <div>
                        <select name="category" class="form-select w-full">
                            <option value="">{{ __('All Categories') }}</option>
                            @foreach($categories ?? [] as $category)
                                <option value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Sort -->
                    <div>
                        <select name="sort" class="form-select w-full">
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>{{ __('Latest') }}</option>
                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>{{ __('Price: Low to High') }}</option>
                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>{{ __('Price: High to Low') }}</option>
                            <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>{{ __('Most Popular') }}</option>
                        </select>
                    </div>

                    <!-- Submit hidden - auto-submit on change via Alpine -->
                    <button type="submit" class="hidden">{{ __('Filter') }}</button>
                </form>
            </div>
        </div>
    </section>

    <!-- Products Grid -->
    <section class="pb-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            @if(isset($products) && $products->count() > 0)
                <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($products as $product)
                        <div class="group relative" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 8) * 50 }}">
                            <div class="absolute inset-0 bg-gradient-to-b from-slate-800/50 to-slate-900/50 rounded-2xl -m-px opacity-0 group-hover:opacity-100 transition duration-700 ease-out"></div>
                            <div class="relative bg-slate-800 rounded-2xl p-5 h-full flex flex-col">
                                <!-- Product Image/Icon -->
                                <div class="flex items-center justify-center w-16 h-16 bg-slate-700 rounded-xl mb-4 mx-auto">
                                    <x-platform-icon :product="$product" size="lg" />
                                </div>
                                
                                <!-- Product Info -->
                                <h3 class="text-lg font-bold text-slate-100 mb-2 text-center line-clamp-1">
                                    {{ $product->title }}
                                </h3>
                                <p class="text-slate-400 text-sm mb-4 text-center line-clamp-2 flex-grow">
                                    {{ Str::limit($product->description, 80) }}
                                </p>
                                
                                <!-- Price & Category -->
                                <div class="flex items-center justify-between mb-4">
                                    <span class="text-2xl font-bold text-white">
                                        ${{ number_format($product->price, 2) }}
                                    </span>
                                    @if($product->category)
                                        <span class="text-xs text-slate-400 bg-slate-700 px-2 py-1 rounded">
                                            {{ $product->category->name }}
                                        </span>
                                    @endif
                                </div>
                                
                                <!-- Seller Info -->
                                @if($product->seller)
                                    <div class="flex items-center text-xs text-slate-400 mb-4 pb-4 border-b border-slate-700">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                        {{ $product->seller->user->name }}
                                    </div>
                                @endif
                                
                                <!-- View Button -->
                                <a href="{{ route('products.show', $product->slug) }}" 
                                   class="btn text-slate-900 bg-gradient-to-r from-white/80 via-white to-white/80 hover:bg-white w-full transition duration-150 ease-in-out group/btn">
                                    {{ __('View Details') }} 
                                    <span class="tracking-normal text-purple-500 group-hover/btn:translate-x-0.5 transition-transform duration-150 ease-in-out ml-1">→</span>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($products->hasPages())
                    <div class="mt-12">
                        <div class="flex justify-center">
                            {{ $products->links() }}
                        </div>
                    </div>
                @endif
            @else
                <div class="text-center py-16">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-slate-800 rounded-full mb-4">
                        <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-100 mb-2">{{ __('No products found') }}</h3>
                    <p class="text-slate-400 mb-6">{{ __('Try adjusting your search or filters') }}</p>
                    <a href="{{ route('products.index') }}" class="btn text-slate-900 bg-gradient-to-r from-white/80 via-white to-white/80 hover:bg-white">
                        {{ __('Clear Filters') }}
                    </a>
                </div>
            @endif
        </div>
    </section>
</x-layouts.stellar>
