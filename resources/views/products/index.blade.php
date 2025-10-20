<x-layouts.app>
    <x-slot name="title">{{ __('Products') }} - {{ config('app.name') }}</x-slot>

    <section class="relative pt-32 pb-12">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center pb-12">
                <h1 class="text-3xl md:text-4xl font-bold text-foreground mb-4">
                    {{ __('Explore Our Digital Marketplace') }}
                </h1>
                <p class="text-lg text-muted-foreground">
                    {{ __('Find the best gaming accounts, social media accounts, and digital goods.') }}
                </p>
            </div>

            <div class="md:flex md:space-x-6">
                <!-- Sidebar Filters -->
                <aside class="md:w-1/4 lg:w-1/5 mb-8 md:mb-0">
                    <div class="glass-card p-6 sticky top-24">
                        <h3 class="text-xl font-bold text-foreground mb-4">{{ __('Filters') }}</h3>
                        <form action="{{ route('products.index') }}" method="GET">
                            <div class="mb-6">
                                <label for="search" class="block text-sm font-medium text-muted-foreground mb-2">{{ __('Search') }}</label>
                                <input 
                                    type="text" 
                                    name="search" 
                                    id="search" 
                                    placeholder="Search products..." 
                                    value="{{ request('search') }}" 
                                    class="form-input w-full"
                                >
                            </div>

                            <div class="mb-6">
                                <label for="category" class="block text-sm font-medium text-muted-foreground mb-2">{{ __('Category') }}</label>
                                <select name="category" id="category" class="form-input w-full">
                                    <option value="">{{ __('All Categories') }}</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->slug }}" @if(request('category') === $category->slug) selected @endif>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-6">
                                <label for="sort" class="block text-sm font-medium text-muted-foreground mb-2">{{ __('Sort By') }}</label>
                                <select name="sort" id="sort" class="form-input w-full">
                                    <option value="latest" @if(request('sort') === 'latest') selected @endif>{{ __('Latest') }}</option>
                                    <option value="price_low" @if(request('sort') === 'price_low') selected @endif>{{ __('Price: Low to High') }}</option>
                                    <option value="price_high" @if(request('sort') === 'price_high') selected @endif>{{ __('Price: High to Low') }}</option>
                                    <option value="rating" @if(request('sort') === 'rating') selected @endif>{{ __('Highest Rated') }}</option>
                                </select>
                            </div>

                            <button type="submit" class="btn-primary w-full">
                                {{ __('Apply Filters') }}
                            </button>
                        </form>
                    </div>
                </aside>

                <!-- Products Grid -->
                <div class="md:w-3/4 lg:w-4/5">
                    @if($products->count() > 0)
                        <!-- Product Grid - Exact Responsive Specifications -->
                        <div class="product-grid">
                            @foreach($products as $product)
                                <x-product-card :product="$product" />
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-12">
                            <x-pagination :paginator="$products" />
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="w-16 h-16 mx-auto text-muted-foreground mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                            </svg>
                            <h3 class="text-lg font-semibold text-foreground mb-2">{{ __('No Products Found') }}</h3>
                            <p class="text-muted-foreground mb-4">{{ __('Try adjusting your search or filter criteria.') }}</p>
                            <a href="{{ route('products.index') }}" class="btn-primary">
                                {{ __('View All Products') }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>