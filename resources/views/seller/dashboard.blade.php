<x-layouts.app>
    <x-slot name="title">{{ __('Seller Dashboard') }} - {{ config('app.name') }}</x-slot>

    <section class="relative pt-32 pb-12 md:pb-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="h2 bg-clip-text text-transparent bg-gradient-to-r from-slate-200/60 via-slate-200 to-slate-200/60 mb-2">
                        {{ __('Seller Dashboard') }}
                    </h1>
                    <p class="text-slate-400">{{ __('Manage your products and track your sales') }}</p>
                </div>
                <a href="{{ route('sell.index') }}" class="btn text-white bg-purple-500 hover:bg-purple-600">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    {{ __('Add Product') }}
                </a>
            </div>

            <!-- Stats Grid -->
            <div class="grid md:grid-cols-4 gap-6 mb-8">
                <div class="bg-slate-800/50 rounded-2xl p-6 border border-slate-700/50 hover:border-green-500/30 transition-colors" data-aos="fade-up">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-slate-400 text-sm">{{ __('Total Revenue') }}</span>
                        <div class="w-10 h-10 bg-green-500/20 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="text-3xl font-bold text-white">${{ number_format($stats['total_revenue'] ?? 0, 2) }}</div>
                </div>

                <div class="bg-slate-800/50 rounded-2xl p-6 border border-slate-700/50 hover:border-blue-500/30 transition-colors" data-aos="fade-up" data-aos-delay="100">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-slate-400 text-sm">{{ __('Total Sales') }}</span>
                        <div class="w-10 h-10 bg-blue-500/20 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="text-3xl font-bold text-white">{{ $stats['total_sales'] ?? 0 }}</div>
                </div>

                <div class="bg-slate-800/50 rounded-2xl p-6 border border-slate-700/50 hover:border-purple-500/30 transition-colors" data-aos="fade-up" data-aos-delay="200">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-slate-400 text-sm">{{ __('Products') }}</span>
                        <div class="w-10 h-10 bg-purple-500/20 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                            </svg>
                        </div>
                    </div>
                    <div class="text-3xl font-bold text-white">{{ $stats['total_products'] ?? 0 }}</div>
                </div>

                <div class="bg-slate-800/50 rounded-2xl p-6 border border-slate-700/50 hover:border-yellow-500/30 transition-colors" data-aos="fade-up" data-aos-delay="300">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-slate-400 text-sm">{{ __('Avg. Rating') }}</span>
                        <div class="w-10 h-10 bg-yellow-500/20 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="text-3xl font-bold text-white">{{ number_format($stats['avg_rating'] ?? 0, 1) }}</div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid md:grid-cols-3 gap-6 mb-8">
                <a href="{{ route('sell.index') }}" class="bg-gradient-to-br from-purple-500/10 to-purple-600/10 rounded-2xl p-6 border border-purple-500/30 hover:border-purple-500/50 transition-all group" data-aos="fade-up">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-lg font-bold text-slate-100">{{ __('Add Product') }}</h3>
                        <svg class="w-6 h-6 text-purple-500 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                    </div>
                    <p class="text-slate-400 text-sm">{{ __('List a new product for sale') }}</p>
                </a>

                <a href="{{ route('seller.products.index') }}" class="bg-gradient-to-br from-blue-500/10 to-blue-600/10 rounded-2xl p-6 border border-blue-500/30 hover:border-blue-500/50 transition-all group" data-aos="fade-up" data-aos-delay="100">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-lg font-bold text-slate-100">{{ __('My Products') }}</h3>
                        <svg class="w-6 h-6 text-blue-500 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                        </svg>
                    </div>
                    <p class="text-slate-400 text-sm">{{ __('Manage your product listings') }}</p>
                </a>

            </div>

            <!-- Recent Sales -->
            <div class="bg-slate-800/50 rounded-2xl p-6 lg:p-8 border border-slate-700/50" data-aos="fade-up" data-aos-delay="300">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-slate-100">{{ __('Recent Sales') }}</h2>
                    <a href="{{ route('account.sales') }}" class="text-purple-400 hover:text-purple-300 text-sm font-medium">
                        {{ __('View All') }} →
                    </a>
                </div>

                @if(isset($recentSales) && $recentSales->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentSales as $sale)
                            <div class="flex items-center justify-between p-4 bg-slate-700/30 rounded-xl">
                                <div class="flex items-center gap-4 flex-1">
                                    <div class="w-12 h-12 bg-slate-700 rounded-lg flex items-center justify-center">
                                        <x-platform-icon :product="$sale->product ?? null" />
                                    </div>
                                    <div>
                                        <div class="text-slate-100 font-medium">{{ $sale->product->title ?? __('Product') }}</div>
                                        <div class="text-sm text-slate-400">{{ $sale->created_at->diffForHumans() }}</div>
                                    </div>
                                </div>
                                <div class="text-green-400 font-bold">+${{ number_format($sale->amount ?? 0, 2) }}</div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="w-16 h-16 bg-slate-700 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 8h6m-5 0a3 3 0 110 6H9l3 3m-3-6h6m6 1a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <p class="text-slate-400 mb-4">{{ __('No sales yet') }}</p>
                        <a href="{{ route('seller.products.create') }}" class="btn text-slate-900 bg-gradient-to-r from-white/80 via-white to-white/80 hover:bg-white inline-flex">
                            {{ __('Add Your First Product') }}
                        </a>
                    </div>
                @endif
            </div>

            <!-- Your Products -->
            <div class="bg-slate-800/50 rounded-2xl p-6 lg:p-8 border border-slate-700/50" data-aos="fade-up" data-aos-delay="400">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-slate-100">{{ __('Your Products') }}</h2>
                    <a href="{{ route('seller.products.index') }}" class="text-purple-400 hover:text-purple-300 text-sm font-medium">
                        {{ __('Manage All') }} →
                    </a>
                </div>

                @if(isset($products) && $products->count() > 0)
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($products->take(6) as $product)
                            <div class="group relative">
                                <div class="absolute inset-0 bg-gradient-to-b from-slate-800/50 to-slate-900/50 rounded-2xl -m-px opacity-0 group-hover:opacity-100 transition duration-700"></div>
                                <div class="relative bg-slate-700/30 rounded-2xl p-4">
                                    <div class="flex items-center justify-center w-16 h-16 bg-slate-700 rounded-xl mb-3 mx-auto">
                                        <x-platform-icon :product="$product" />
                                    </div>
                                    <h3 class="text-lg font-bold text-slate-100 mb-2 text-center line-clamp-1">{{ $product->title }}</h3>
                                    <div class="flex items-center justify-between">
                                        <span class="text-xl font-bold text-white">${{ number_format($product->price, 2) }}</span>
                                        <span class="text-xs px-2 py-1 rounded {{ $product->status === 'active' ? 'bg-green-500/20 text-green-400' : 'bg-slate-600 text-slate-400' }}">
                                            {{ ucfirst($product->status) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <p class="text-slate-400 mb-4">{{ __('No products listed yet') }}</p>
                        <a href="{{ route('seller.products.create') }}" class="btn text-white bg-purple-500 hover:bg-purple-600 inline-flex">
                            {{ __('Add Your First Product') }}
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </section>
</x-layouts.app>
