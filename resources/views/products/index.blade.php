<x-layouts.stellar>
    <x-slot name="title">{{ __('Products') }} - {{ config('app.name') }}</x-slot>

    <!-- Hero Section -->
    <section class="relative pt-32 pb-10 sm:pb-14">
        <div class="absolute inset-0 -z-10 -mx-4 sm:-mx-6 rounded-b-[3rem] pointer-events-none overflow-hidden" aria-hidden="true">
            <div class="absolute left-1/2 -translate-x-1/2 bottom-0 -z-10">
                <img src="{{ asset('stellar-assets/images/glow-bottom.svg') }}" class="max-w-none" width="2146" height="774" alt="Hero Illustration">
            </div>
        </div>

        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="text-center">
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-slate-200/60 via-slate-200 to-slate-200/60 pb-4" data-aos="fade-down">
                    {{ __('Digital Products') }}
                </h1>
                <p class="text-lg text-slate-200 max-w-2xl mx-auto" data-aos="fade-down" data-aos-delay="200">
                    {{ __('Browse our premium selection of digital products, gaming accounts, and exclusive services') }}
                </p>
            </div>
        </div>
    </section>

    <!-- Filters & Search -->
    <section class="pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="bg-slate-800/50 rounded-2xl p-6 backdrop-blur-sm border border-slate-700/50">
                <form method="GET" action="{{ route('products.index') }}" class="space-y-4">
                    <!-- Desktop Filters -->
                    <div class="hidden md:grid md:grid-cols-4 gap-4">
                        <!-- Search -->
                        <div class="md:col-span-2">
                            <input 
                                type="search" 
                                name="search"
                                placeholder="{{ __('Search products...') }}" 
                                class="form-input w-full placeholder:text-slate-500"
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
                                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>{{ __('Newest') }}</option>
                                <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>{{ __('Trending') }}</option>
                                <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>{{ __('Price ↑') }}</option>
                                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>{{ __('Price ↓') }}</option>
                            </select>
                        </div>
                    </div>

                    <!-- Mobile Search & Filter Button -->
                    <div class="md:hidden space-y-3">
                        <div class="flex gap-3">
                            <input 
                                type="search" 
                                name="search"
                                placeholder="{{ __('Search products...') }}" 
                                class="form-input flex-1 placeholder:text-slate-500"
                                value="{{ request('search') }}"
                            />
                            <button type="button" 
                                    onclick="document.getElementById('mobile-filter-drawer').classList.remove('hidden')"
                                    class="px-4 py-3 bg-slate-700 hover:bg-slate-600 text-white rounded-xl transition-colors flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                                </svg>
                                <span class="hidden sm:inline">{{ __('Filters') }}</span>
                            </button>
                        </div>
                    </div>

                    <!-- Submit hidden - auto-submit on change via Alpine -->
                    <button type="submit" class="hidden">{{ __('Filter') }}</button>
                </form>
            </div>
        </div>
    </section>

    <!-- Mobile Filter Drawer -->
    <div id="mobile-filter-drawer" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-black/60" onclick="this.parentElement.classList.add('hidden')"></div>
        <div class="absolute bottom-0 left-0 right-0 bg-slate-800 rounded-t-2xl p-6 max-h-[80vh] overflow-y-auto">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-white">{{ __('Filters') }}</h3>
                <button onclick="document.getElementById('mobile-filter-drawer').classList.add('hidden')" 
                        class="text-slate-400 hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <form method="GET" action="{{ route('products.index') }}" class="space-y-4">
                <!-- Category Filter -->
                <div>
                    <label class="block text-sm font-semibold text-white mb-2">{{ __('Category') }}</label>
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
                    <label class="block text-sm font-semibold text-white mb-2">{{ __('Sort By') }}</label>
                    <select name="sort" class="form-select w-full">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>{{ __('Newest') }}</option>
                        <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>{{ __('Trending') }}</option>
                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>{{ __('Price ↑') }}</option>
                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>{{ __('Price ↓') }}</option>
                    </select>
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="button" 
                            onclick="document.getElementById('mobile-filter-drawer').classList.add('hidden')"
                            class="flex-1 px-4 py-3 bg-slate-700 hover:bg-slate-600 text-white rounded-xl transition-colors">
                        {{ __('Cancel') }}
                    </button>
                    <button type="submit" 
                            class="flex-1 px-4 py-3 bg-purple-500 hover:bg-purple-600 text-white rounded-xl transition-colors">
                        {{ __('Apply Filters') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Products Grid -->
    <section class="pb-10 sm:pb-14">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            @if(isset($products) && $products->count() > 0)
                <!-- Results Summary & Filter Chips -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                    <div class="text-slate-200">
                        <span class="font-medium">{{ __('Showing') }} {{ $products->count() }} {{ __('results') }}</span>
                        @if(request('search') || request('category') || request('sort'))
                            <span class="text-slate-400">•</span>
                            <a href="{{ route('products.index') }}" class="text-purple-400 hover:text-purple-300 font-medium">
                                {{ __('Clear Filters') }}
                            </a>
                        @endif
                    </div>
                    
                    <!-- Active Filter Chips -->
                    @if(request('search') || request('category') || request('sort'))
                        <div class="flex flex-wrap gap-2">
                            @if(request('search'))
                                <span class="inline-flex items-center gap-1 px-3 py-1 bg-slate-700 text-slate-300 rounded-full text-sm">
                                    {{ __('Search') }}: "{{ request('search') }}"
                                    <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}" class="text-slate-400 hover:text-white">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                        </svg>
                                    </a>
                                </span>
                            @endif
                            @if(request('category'))
                                <span class="inline-flex items-center gap-1 px-3 py-1 bg-slate-700 text-slate-300 rounded-full text-sm">
                                    {{ __('Category') }}: {{ collect($categories)->firstWhere('slug', request('category'))->name ?? request('category') }}
                                    <a href="{{ request()->fullUrlWithQuery(['category' => null]) }}" class="text-slate-400 hover:text-white">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                        </svg>
                                    </a>
                                </span>
                            @endif
                            @if(request('sort') && request('sort') !== 'latest')
                                <span class="inline-flex items-center gap-1 px-3 py-1 bg-slate-700 text-slate-300 rounded-full text-sm">
                                    {{ __('Sort') }}: {{ match(request('sort')) {
                                        'popular' => __('Trending'),
                                        'price_low' => __('Price ↑'),
                                        'price_high' => __('Price ↓'),
                                        default => __('Newest')
                                    } }}
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => null]) }}" class="text-slate-400 hover:text-white">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                        </svg>
                                    </a>
                                </span>
                            @endif
                        </div>
                    @endif
                </div>
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
                                <p class="text-slate-200 text-sm mb-4 text-center line-clamp-2 flex-grow">
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
                    <div class="inline-flex items-center justify-center w-24 h-24 bg-gradient-to-br from-purple-500/20 to-blue-500/20 rounded-2xl mb-8 border border-purple-500/30">
                        <svg class="w-12 h-12 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl sm:text-3xl md:text-4xl font-bold text-slate-100 mb-4">{{ __('No products found') }}</h3>
                    <p class="text-slate-200 mb-8 max-w-lg mx-auto leading-relaxed text-lg">
                        {{ __('We couldn\'t find any products matching your criteria. Try adjusting your search or filters to discover amazing digital products.') }}
                    </p>
                    
                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 justify-center max-w-md mx-auto">
                        <a href="{{ route('products.index') }}" class="btn text-slate-300 bg-slate-700 hover:bg-slate-600 border border-slate-600">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            {{ __('Clear Filters') }}
                        </a>
                        @auth
                            <a href="{{ route('sell.index') }}" class="btn text-white bg-purple-500 hover:bg-purple-600 shadow-lg shadow-purple-500/25 hover:shadow-purple-500/40">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                {{ __('Start Selling') }}
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="btn text-white bg-purple-500 hover:bg-purple-600 shadow-lg shadow-purple-500/25 hover:shadow-purple-500/40">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                </svg>
                                {{ __('Join Now') }}
                            </a>
                        @endauth
                    </div>
                </div>
            @endif
        </div>
    </section>
</x-layouts.stellar>
