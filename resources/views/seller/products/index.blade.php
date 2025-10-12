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
        <div class="mb-12 flex items-center justify-between animate-fade-in">
            <div>
                <h1 class="text-5xl font-black text-white mb-4 bg-gaming-gradient bg-clip-text text-transparent">
                    My Products
                </h1>
                <p class="text-xl text-muted-300">Manage your digital gaming products</p>
            </div>
            <a href="{{ route('seller.products.create') }}" class="inline-flex items-center justify-center px-8 py-4 bg-gaming-gradient text-white font-bold rounded-2xl hover:shadow-gaming transition-all group">
                <svg class="w-6 h-6 mr-3 group-hover:animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                New Product
            </a>
        </div>

        <!-- Gaming Products List -->
        @if($products->count() > 0)
            <x-ui.card variant="glass" class="animate-fade-in animation-delay-200">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gaming">
                        <thead class="bg-dark-800/50">
                            <tr>
                                <th class="px-8 py-4 text-left text-xs font-bold text-muted-300 uppercase tracking-wider">Product</th>
                                <th class="px-8 py-4 text-left text-xs font-bold text-muted-300 uppercase tracking-wider">Category</th>
                                <th class="px-8 py-4 text-left text-xs font-bold text-muted-300 uppercase tracking-wider">Price</th>
                                <th class="px-8 py-4 text-left text-xs font-bold text-muted-300 uppercase tracking-wider">Sales</th>
                                <th class="px-8 py-4 text-left text-xs font-bold text-muted-300 uppercase tracking-wider">Stock</th>
                                <th class="px-8 py-4 text-left text-xs font-bold text-muted-300 uppercase tracking-wider">Status</th>
                                <th class="px-8 py-4 text-left text-xs font-bold text-muted-300 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-dark-800/30 divide-y divide-gaming">
                            @foreach($products as $product)
                            <tr class="hover:bg-dark-700/50 transition-colors group">
                                <!-- Gaming Product -->
                                <td class="px-8 py-6 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-16 h-16 flex-shrink-0 bg-gaming-gradient rounded-2xl overflow-hidden relative">
                                            @if($product->thumbnail_url)
                                                <img src="{{ $product->thumbnail_url }}" alt="{{ $product->title }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-white text-xl font-black">
                                                    <x-platform-icon :product="$product" size="lg" class="filter brightness-0 invert" />
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-6">
                                            <div class="text-lg font-bold text-white group-hover:text-primary-400 transition-colors">{{ Str::limit($product->title, 40) }}</div>
                                            <div class="text-sm text-muted-400 mt-1 space-y-1">
                                                @if($product->metadata['platform'] ?? false)
                                                <div class="flex items-center gap-1">
                                                    <x-platform-icon :product="$product" size="xs" />
                                                    <span>{{ $product->metadata['platform'] }}</span>
                                                </div>
                                                @endif
                                                <div class="flex items-center">
                                                    <svg class="w-4 h-4 mr-1 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                                    </svg>
                                                    {{ $product->reviews_count }} reviews
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                
                                <!-- Gaming Category -->
                                <td class="px-8 py-6 whitespace-nowrap">
                                    <x-ui.badge class="bg-dark-700/50 text-muted-300 border border-gaming flex items-center gap-1.5">
                                        <x-platform-icon :category="$product->category->name" size="xs" />
                                        {{ $product->category->name }}
                                    </x-ui.badge>
                                </td>
                                
                                <!-- Gaming Price -->
                                <td class="px-8 py-6 whitespace-nowrap">
                                    <div class="text-xl font-bold text-white">${{ number_format($product->price, 2) }}</div>
                                </td>
                                
                                <!-- Gaming Sales -->
                                <td class="px-8 py-6 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                        </svg>
                                        <span class="text-lg font-bold text-green-400">{{ $product->sales_count }}</span>
                                    </div>
                                </td>
                                
                                <!-- Gaming Stock -->
                                <td class="px-8 py-6 whitespace-nowrap">
                                    @if($product->delivery_type === 'file')
                                        <x-ui.badge class="bg-green-500/20 text-green-400 border-green-500/50">
                                            ∞ Unlimited
                                        </x-ui.badge>
                                    @else
                                        <div class="text-lg font-bold {{ $product->stock_count > 0 ? 'text-white' : 'text-red-400' }}">
                                            {{ $product->stock_count }}
                                        </div>
                                    @endif
                                </td>
                                
                                <!-- Gaming Status -->
                                <td class="px-8 py-6 whitespace-nowrap">
                                    <x-ui.badge class="
                                        @if($product->status === 'active') bg-green-500/20 text-green-400 border-green-500/50
                                        @elseif($product->status === 'draft') bg-muted-500/20 text-muted-400 border-muted-500/50
                                        @elseif($product->status === 'paused') bg-yellow-500/20 text-yellow-400 border-yellow-500/50
                                        @else bg-red-500/20 text-red-400 border-red-500/50
                                        @endif
                                    ">
                                        {{ ucfirst($product->status) }}
                                    </x-ui.badge>
                                </td>
                                
                                <!-- Gaming Actions -->
                                <td class="px-8 py-6 whitespace-nowrap">
                                    <div class="flex items-center space-x-4">
                                        <a href="{{ route('products.show', $product->slug) }}" 
                                           class="p-2 bg-primary-500/20 hover:bg-primary-500/30 border border-primary-500/50 rounded-xl text-primary-400 hover:text-primary-300 transition-all hover:shadow-gaming" 
                                           title="View">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('seller.products.edit', $product) }}" 
                                           class="p-2 bg-secondary-500/20 hover:bg-secondary-500/30 border border-secondary-500/50 rounded-xl text-secondary-400 hover:text-secondary-300 transition-all hover:shadow-gaming-purple" 
                                           title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('seller.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="p-2 bg-red-500/20 hover:bg-red-500/30 border border-red-500/50 rounded-xl text-red-400 hover:text-red-300 transition-all hover:shadow-lg" 
                                                    title="Delete">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </x-ui.card>

            <!-- Gaming Pagination -->
            <div class="mt-12 text-center">
                {{ $products->links() }}
            </div>
        @else
            <!-- Gaming Empty State -->
            <x-ui.card variant="glass" class="text-center py-20 animate-fade-in animation-delay-200">
                <div class="inline-flex items-center justify-center w-32 h-32 bg-gradient-to-br from-muted-600 to-muted-700 rounded-3xl mb-12 shadow-2xl">
                    <svg class="w-16 h-16 text-muted-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
                <h2 class="text-4xl font-black text-white mb-6 bg-gaming-gradient bg-clip-text text-transparent">
                    No Products Yet
                </h2>
                <p class="text-xl text-muted-300 mb-12 max-w-md mx-auto leading-relaxed">
                    Create your first gaming product and start building your digital empire!
                </p>
                <div class="flex flex-col sm:flex-row gap-6 justify-center">
                    <a href="{{ route('seller.products.create') }}" 
                       class="inline-flex items-center justify-center px-8 py-4 bg-gaming-gradient text-white font-bold rounded-2xl hover:shadow-gaming transition-all group">
                        <svg class="w-6 h-6 mr-3 group-hover:animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Create Your First Product
                    </a>
                    <a href="{{ route('sell.index') }}" 
                       class="inline-flex items-center justify-center px-8 py-4 border border-gaming text-white font-semibold rounded-2xl hover:bg-dark-700/50 transition-all">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        Quick Sell
                    </a>
                </div>
                
                <!-- Gaming Tips -->
                <div class="mt-16 max-w-2xl mx-auto">
                    <h3 class="text-2xl font-bold text-white mb-8 flex items-center justify-center">
                        <svg class="w-6 h-6 mr-3 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                        </svg>
                        Pro Tips
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="text-center">
                            <div class="w-12 h-12 bg-primary-500/20 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                <svg class="w-6 h-6 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                            </div>
                            <h4 class="text-lg font-bold text-white mb-2">Quality First</h4>
                            <p class="text-sm text-muted-400">Create high-quality products that gamers will love</p>
                        </div>
                        <div class="text-center">
                            <div class="w-12 h-12 bg-secondary-500/20 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                <svg class="w-6 h-6 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h4 class="text-lg font-bold text-white mb-2">Fair Pricing</h4>
                            <p class="text-sm text-muted-400">Price your products competitively to attract buyers</p>
                        </div>
                        <div class="text-center">
                            <div class="w-12 h-12 bg-green-500/20 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <h4 class="text-lg font-bold text-white mb-2">Great Service</h4>
                            <p class="text-sm text-muted-400">Provide excellent customer support for repeat business</p>
                        </div>
                    </div>
                </div>
            </x-ui.card>
        @endif
    </div>
</div>

<style>
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

@keyframes fade-in {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.animate-float {
    animation: float 6s ease-in-out infinite;
}

.animate-fade-in {
    animation: fade-in 0.8s ease-out forwards;
}

.animation-delay-200 {
    animation-delay: 0.2s;
}

.animation-delay-2000 {
    animation-delay: 2s;
}

.animation-delay-4000 {
    animation-delay: 4s;
}
</style>
@endsection