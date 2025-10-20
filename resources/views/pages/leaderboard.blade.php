<x-layouts.app>
    <x-slot name="title">{{ __('Leaderboard') }} - {{ config('app.name') }}</x-slot>

<section class="relative pt-32 pb-12">
<div class="min-h-screen bg-gray-900 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-white mb-4">Seller Leaderboard</h1>
            <p class="text-lg text-gray-400">Top performing sellers ranked by reviews and sales volume</p>
        </div>

        <!-- Leaderboard Tabs -->
        <div class="flex justify-center mb-8">
            <div class="bg-gray-800 p-1 rounded-lg inline-flex" x-data="{ activeTab: 'sellers' }">
                <button @click="activeTab = 'sellers'" 
                        :class="activeTab === 'sellers' ? 'bg-blue-600 text-white' : 'text-gray-400'"
                        class="px-6 py-2 rounded-md font-medium transition-colors">
                    Top Sellers
                </button>
                <button @click="activeTab = 'products'" 
                        :class="activeTab === 'products' ? 'bg-blue-600 text-white' : 'text-gray-400'"
                        class="px-6 py-2 rounded-md font-medium transition-colors">
                    Popular Products
                </button>
            </div>
        </div>

        <!-- Top Sellers Tab -->
        <div x-show="activeTab === 'sellers'" class="space-y-6">
            <div class="bg-gray-800 rounded-lg p-6">
                <h2 class="text-xl font-bold text-white mb-6 flex items-center">
                    <svg class="w-6 h-6 text-yellow-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Top Sellers
                </h2>
                
                @if($topSellers->count() > 0)
                    <div class="space-y-4">
                        @foreach($topSellers as $index => $seller)
                        <div class="flex items-center justify-between p-4 bg-gray-700 rounded-lg hover:bg-gray-650 transition-colors">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    @if($index < 3)
                                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-white font-bold
                                            {{ $index === 0 ? 'bg-yellow-500' : ($index === 1 ? 'bg-gray-400' : 'bg-orange-600') }}">
                                            {{ $index + 1 }}
                                        </div>
                                    @else
                                        <div class="w-8 h-8 rounded-full bg-gray-600 flex items-center justify-center text-white font-bold">
                                            {{ $index + 1 }}
                                        </div>
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full mr-3"></div>
                                        <div>
                                            <p class="text-white font-medium">{{ $seller->user->name }}</p>
                                            <p class="text-gray-400 text-sm">{{ $seller->products()->count() }} products</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="flex items-center mb-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-4 h-4 {{ $i <= $seller->rating ? 'text-yellow-400' : 'text-gray-600' }}" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @endfor
                                    <span class="text-white font-bold ml-2">{{ number_format($seller->rating, 1) }}</span>
                                </div>
                                <p class="text-gray-400 text-sm">Rating</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <p class="text-gray-400">No sellers found.</p>
                    </div>
                @endif
            </div>
        </div>


        <!-- Popular Products Tab -->
        <div x-show="activeTab === 'products'" class="space-y-6">
            <div class="bg-gray-800 rounded-lg p-6">
                <h2 class="text-xl font-bold text-white mb-6 flex items-center">
                    <svg class="w-6 h-6 text-purple-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                    Most Popular Products
                </h2>
                
                @if($popularProducts->count() > 0)
                    <div class="grid md:grid-cols-2 gap-6">
                        @foreach($popularProducts as $index => $product)
                        <div class="bg-gray-700 rounded-lg p-4 hover:bg-gray-650 transition-colors">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-500 rounded-lg mr-3 flex items-center justify-center">
                                        <span class="text-white font-bold text-sm">#{{ $index + 1 }}</span>
                                    </div>
                                    <div>
                                        <p class="text-white font-medium">{{ $product->title }}</p>
                                        <p class="text-gray-400 text-sm">{{ $product->seller->user->name }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <div class="flex items-center text-gray-400">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    {{ $product->sales_count }} sales
                                </div>
                                <div class="text-white font-bold">
                                    ${{ number_format($product->price, 2) }}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <p class="text-gray-400">No products found.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Stats Section -->
        <div class="grid md:grid-cols-4 gap-6 mt-12">
            <div class="bg-gray-800 rounded-lg p-6 text-center">
                <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-white mb-2">Active Sellers</h3>
                <p class="text-3xl font-bold text-blue-400">{{ $stats['active_sellers'] }}</p>
                <p class="text-gray-400 text-sm">Verified sellers</p>
            </div>
            
            <div class="bg-gray-800 rounded-lg p-6 text-center">
                <div class="w-12 h-12 bg-green-600 rounded-lg flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-white mb-2">Total Products</h3>
                <p class="text-3xl font-bold text-green-400">{{ $stats['total_products'] }}</p>
                <p class="text-gray-400 text-sm">Active listings</p>
            </div>
            
            <div class="bg-gray-800 rounded-lg p-6 text-center">
                <div class="w-12 h-12 bg-purple-600 rounded-lg flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-white mb-2">Total Sales</h3>
                <p class="text-3xl font-bold text-purple-400">{{ \App\Models\Product::sum('sales_count') }}</p>
                <p class="text-gray-400 text-sm">All time</p>
            </div>
            
            <div class="bg-gray-800 rounded-lg p-6 text-center">
                <div class="w-12 h-12 bg-yellow-600 rounded-lg flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-white mb-2">Avg Rating</h3>
                <p class="text-3xl font-bold text-yellow-400">{{ number_format($stats['avg_rating'], 1) }}</p>
                <p class="text-gray-400 text-sm">Seller ratings</p>
            </div>
        </div>
    </div>
</div>
</section>

</x-layouts.app>
