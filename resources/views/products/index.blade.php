<x-layouts.app>
    <x-slot name="title">{{ __('Products') }} - {{ config('app.name') }}</x-slot>

    <section class="py-20 relative">
        <div class="container mx-auto px-4">
            <!-- Header -->
            <div class="text-center mb-16">
                <h1 class="text-4xl md:text-5xl font-bold mb-6">
                    <span class="bg-gradient-to-r from-primary via-accent to-primary bg-clip-text text-transparent">
                        {{ __('Browse Products') }}
                    </span>
                </h1>
                <p class="text-muted-foreground text-lg max-w-2xl mx-auto">
                    {{ __('Discover premium gaming accounts, social media profiles, and digital assets') }}
                </p>
            </div>

            <!-- Filters and Search -->
            <div class="glass-card rounded-2xl p-6 mb-12">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Search -->
                    <div class="md:col-span-2">
                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 text-primary/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            <input type="search" 
                                   placeholder="{{ __('Search products...') }}" 
                                   class="w-full pl-12 pr-4 py-3 rounded-lg bg-muted/50 border border-border/50 text-foreground placeholder:text-muted-foreground focus:border-primary/50 focus:bg-muted/70 focus:outline-none transition-all">
                        </div>
                    </div>
                    
                    <!-- Category Filter -->
                    <div>
                        <select class="w-full px-4 py-3 rounded-lg bg-muted/50 border border-border/50 text-foreground focus:border-primary/50 focus:bg-muted/70 focus:outline-none transition-all">
                            <option value="">{{ __('All Categories') }}</option>
                            @foreach(\App\Models\Category::all() as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Type Filter -->
                    <div>
                        <select class="w-full px-4 py-3 rounded-lg bg-muted/50 border border-border/50 text-foreground focus:border-primary/50 focus:bg-muted/70 focus:outline-none transition-all">
                            <option value="">{{ __('All Types') }}</option>
                            <option value="game_account">{{ __('Gaming Accounts') }}</option>
                            <option value="social_account">{{ __('Social Media') }}</option>
                            <option value="digital_product">{{ __('Digital Products') }}</option>
                            <option value="service">{{ __('Services') }}</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Results Header -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
                <div>
                    <h2 class="text-2xl font-bold text-foreground">
                        {{ __('Products') }}
                        <span class="text-muted-foreground font-normal">({{ $products->total() }})</span>
                    </h2>
                </div>
                
                <!-- Sort Options -->
                <div class="flex items-center gap-4">
                    <span class="text-sm text-muted-foreground">{{ __('Sort by:') }}</span>
                    <select class="px-4 py-2 rounded-lg bg-muted/50 border border-border/50 text-foreground focus:border-primary/50 focus:outline-none transition-all">
                        <option value="latest">{{ __('Latest') }}</option>
                        <option value="price_low">{{ __('Price: Low to High') }}</option>
                        <option value="price_high">{{ __('Price: High to Low') }}</option>
                        <option value="rating">{{ __('Highest Rated') }}</option>
                        <option value="popular">{{ __('Most Popular') }}</option>
                    </select>
                </div>
            </div>

            <!-- Products Grid -->
            @if($products->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-12">
                    @foreach($products as $product)
                        <x-product-card :product="$product" />
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="flex justify-center">
                    {{ $products->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-20">
                    <div class="w-24 h-24 mx-auto mb-8 rounded-full bg-muted flex items-center justify-center">
                        <svg class="w-12 h-12 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-foreground mb-4">{{ __('No products found') }}</h3>
                    <p class="text-muted-foreground mb-8 max-w-md mx-auto">
                        {{ __('Try adjusting your search criteria or browse our featured products.') }}
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('products.index') }}" class="btn-glow px-6 py-3 rounded-lg text-primary-foreground font-semibold">
                            {{ __('View All Products') }}
                        </a>
                        <a href="{{ route('sell.index') }}" class="px-6 py-3 rounded-lg border border-border hover:border-primary/50 text-foreground font-semibold transition-all duration-300 hover:bg-primary/5">
                            {{ __('Start Selling') }}
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </section>
</x-layouts.app>
