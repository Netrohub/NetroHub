@extends('layouts.app')

@section('content')
<div class="min-h-screen relative overflow-hidden bg-dark-900 py-8">
    <!-- Gaming Background Effects -->
    <div class="absolute inset-0">
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-primary-500/10 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-1/4 right-1/4 w-80 h-80 bg-secondary-500/10 rounded-full blur-3xl animate-float animation-delay-2000"></div>
        <div class="absolute top-3/4 left-1/3 w-64 h-64 bg-neon-blue/5 rounded-full blur-3xl animate-float animation-delay-4000"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Gaming Header -->
        <div class="mb-12 text-center animate-fade-in">
            <div class="relative inline-flex items-center justify-center w-20 h-20 bg-gaming-gradient rounded-3xl mb-8 shadow-gaming-xl group">
                <div class="absolute inset-0 bg-gaming-gradient rounded-3xl blur-xl opacity-50 group-hover:opacity-100 transition-opacity"></div>
                <svg class="relative w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
            </div>
            <h1 class="text-5xl md:text-6xl font-black text-white mb-6 bg-gaming-gradient bg-clip-text text-transparent leading-tight">
                Gaming Marketplace
            </h1>
            <p class="text-xl md:text-2xl text-muted-300 max-w-3xl mx-auto leading-relaxed">
                Discover epic digital products from the best creators in the gaming community
            </p>
        </div>

        <!-- Gaming Search and Filters -->
        <div class="card-glass mb-12 animate-fade-in animation-delay-200 p-6 md:p-8">
            <form method="GET" action="{{ route('products.index') }}" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Gaming Search -->
                    <div class="md:col-span-2">
                        <label class="label">
                            <svg class="w-4 h-4 inline mr-2 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            Search Products
                        </label>
                        <div class="input-group">
                            <svg class="input-group-icon w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            <input 
                                type="text" 
                                name="search" 
                                value="{{ request('search') }}"
                                placeholder="Search for gaming accounts, digital products..." 
                                class="input input-with-icon"
                            >
                        </div>
                    </div>
                    
                    <!-- Gaming Sort -->
                    <div>
                        <label class="label">
                            <svg class="w-4 h-4 inline mr-2 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4"/>
                            </svg>
                            Sort By
                        </label>
                        <select name="sort" onchange="this.form.submit()" class="select">
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                            <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular</option>
                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                            <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Highest Rated</option>
                        </select>
                    </div>
                </div>

                <!-- Gaming Categories -->
                @if($categories->count() > 0)
                <div>
                    <label class="label">
                        <svg class="w-4 h-4 inline mr-2 text-neon-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                        Categories
                    </label>
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('products.index') }}" 
                           class="flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-300 {{ !request('category') ? 'bg-gaming-gradient text-white shadow-gaming scale-105' : 'bg-dark-800/70 text-muted-300 hover:bg-dark-700/70 hover:text-white hover:scale-105 border border-gaming' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                            All
                        </a>
                        @foreach($categories as $category)
                            <a href="{{ route('products.index', ['category' => $category->slug]) }}" 
                               class="flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-300 {{ request('category') == $category->slug ? 'bg-gaming-gradient text-white shadow-gaming scale-105' : 'bg-dark-800/70 text-muted-300 hover:bg-dark-700/70 hover:text-white hover:scale-105 border border-gaming' }}">
                                <x-platform-icon :category="$category->name" size="sm" :class="request('category') == $category->slug ? 'filter brightness-0 invert' : ''" />
                                {{ $category->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
                @endif
            </form>
        </div>

        <!-- Results Count -->
        @if($products->count() > 0)
            <div class="mb-8 flex items-center justify-between scroll-fade-in">
                <div class="flex items-center gap-3">
                    <div class="w-1 h-8 bg-gaming-gradient rounded-full"></div>
                    <p class="text-muted-400 text-sm">
                        Showing <span class="text-white font-bold">{{ $products->firstItem() }}</span> to 
                        <span class="text-white font-bold">{{ $products->lastItem() }}</span> of 
                        <span class="text-gradient font-bold">{{ $products->total() }}</span> results
                    </p>
                </div>
            </div>
            
            <!-- Gaming Products Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 scroll-stagger">
                @foreach($products as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>

            <!-- Gaming Pagination -->
            <div class="mt-16 text-center">
                {{ $products->links() }}
            </div>
        @else
            <!-- Gaming Empty State -->
            <x-ui.card variant="glass" class="text-center py-16 animate-fade-in">
                <div class="inline-flex items-center justify-center w-24 h-24 bg-gradient-to-br from-muted-600 to-muted-700 rounded-3xl mb-8 shadow-2xl">
                    <svg class="w-12 h-12 text-muted-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                </div>
                <h3 class="text-3xl font-bold text-white mb-4">No Products Found</h3>
                <p class="text-lg text-muted-300 mb-8 max-w-md mx-auto">
                    Looks like our gaming marketplace is empty! Try adjusting your search or filters to find epic digital products.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('products.index') }}" 
                       class="inline-flex items-center justify-center px-6 py-3 bg-gaming-gradient text-white font-semibold rounded-2xl hover:shadow-gaming transition-all">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Clear Filters
                    </a>
                    <a href="{{ route('sell.index') }}" 
                       class="inline-flex items-center justify-center px-6 py-3 border border-gaming text-white font-semibold rounded-2xl hover:bg-dark-700/50 transition-all">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Sell Your Products
                    </a>
                </div>
            </x-ui.card>
        @endif
    </div>
</div>
@endsection