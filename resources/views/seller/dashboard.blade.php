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
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gaming-gradient rounded-3xl mb-6 shadow-gaming-lg">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
            </div>
            <h1 class="text-5xl font-black text-white mb-4 bg-gaming-gradient bg-clip-text text-transparent">
                Seller Dashboard
            </h1>
            <p class="text-xl text-muted-300">
                Welcome back, <span class="text-primary-400 font-bold">{{ $seller->display_name }}</span>! 🎮
            </p>
        </div>

        <!-- Gaming Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
            <!-- Gaming Total Products -->
            <x-ui.card variant="glass" hover="true" class="animate-fade-in animation-delay-200">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-muted-300 mb-2">📦 Total Products</p>
                        <p class="text-4xl font-black text-white mb-1">{{ $stats['total_products'] }}</p>
                        <p class="text-sm text-green-400">{{ $stats['active_products'] }} active</p>
                    </div>
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-500 to-primary-500 rounded-2xl blur-xl opacity-50"></div>
                        <div class="relative w-16 h-16 bg-gradient-to-br from-blue-500 to-primary-500 rounded-2xl flex items-center justify-center shadow-gaming-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                    </div>
                </div>
            </x-ui.card>

            <!-- Gaming Total Sales -->
            <x-ui.card variant="glass" hover="true" class="animate-fade-in animation-delay-300">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-muted-300 mb-2">💰 Total Sales</p>
                        <p class="text-4xl font-black text-white mb-1">{{ $stats['total_sales'] }}</p>
                        <p class="text-sm text-muted-400">All time</p>
                    </div>
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-br from-green-500 to-emerald-500 rounded-2xl blur-xl opacity-50"></div>
                        <div class="relative w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-500 rounded-2xl flex items-center justify-center shadow-gaming-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                        </div>
                    </div>
                </div>
            </x-ui.card>

            <!-- Gaming Revenue -->
            <x-ui.card variant="glass" hover="true" class="animate-fade-in animation-delay-400">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-muted-300 mb-2">💎 Revenue</p>
                        <p class="text-4xl font-black text-white mb-1">${{ number_format($stats['revenue'], 2) }}</p>
                        <p class="text-sm text-muted-400">Total earnings</p>
                    </div>
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-br from-secondary-500 to-neon-pink rounded-2xl blur-xl opacity-50"></div>
                        <div class="relative w-16 h-16 bg-gradient-to-br from-secondary-500 to-neon-pink rounded-2xl flex items-center justify-center shadow-gaming-purple">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </x-ui.card>

            <!-- Gaming Wallet Balance -->
            <x-ui.card variant="glass" hover="true" class="animate-fade-in animation-delay-500">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-muted-300 mb-2">💳 Wallet Balance</p>
                        <p class="text-4xl font-black text-white mb-1">${{ number_format($stats['wallet_balance'], 2) }}</p>
                        <p class="text-sm text-muted-400">Available to withdraw</p>
                    </div>
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-2xl blur-xl opacity-50"></div>
                        <div class="relative w-16 h-16 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-2xl flex items-center justify-center shadow-gaming-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </x-ui.card>

            <!-- Gaming Pending Payouts -->
            <x-ui.card variant="glass" hover="true" class="animate-fade-in animation-delay-600">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-muted-300 mb-2">⏳ Pending Payouts</p>
                        <p class="text-4xl font-black text-white mb-1">{{ $stats['pending_payouts'] }}</p>
                        <p class="text-sm text-muted-400">Awaiting approval</p>
                    </div>
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-br from-orange-500 to-red-500 rounded-2xl blur-xl opacity-50"></div>
                        <div class="relative w-16 h-16 bg-gradient-to-br from-orange-500 to-red-500 rounded-2xl flex items-center justify-center shadow-gaming-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </x-ui.card>

            <!-- Gaming Quick Actions -->
            <x-ui.card variant="glass" class="animate-fade-in animation-delay-700 bg-gaming-gradient-dark border-gaming">
                <div class="space-y-6">
                    <h3 class="text-xl font-bold text-white flex items-center">
                        <svg class="w-6 h-6 mr-3 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        Quick Actions
                    </h3>
                    <div class="space-y-3">
                        <a href="{{ route('seller.products.create') }}" class="block w-full bg-primary-500/20 hover:bg-primary-500/30 border border-primary-500/50 rounded-2xl px-4 py-3 text-sm font-semibold text-white transition-all hover:shadow-gaming">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-3 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                + New Product
                            </div>
                        </a>
                        <a href="{{ route('seller.wallet.index') }}" class="block w-full bg-secondary-500/20 hover:bg-secondary-500/30 border border-secondary-500/50 rounded-2xl px-4 py-3 text-sm font-semibold text-white transition-all hover:shadow-gaming-purple">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-3 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                </svg>
                                View Wallet
                            </div>
                        </a>
                    </div>
                </div>
            </x-ui.card>
        </div>

        <!-- Gaming Recent Sales -->
        <x-ui.card variant="glass" class="mb-12 animate-fade-in animation-delay-800">
            <div class="px-8 py-6 border-b border-gaming">
                <h2 class="text-3xl font-bold text-white flex items-center">
                    <svg class="w-8 h-8 mr-3 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                    Recent Sales
                </h2>
            </div>
            <div class="overflow-x-auto">
                @if($recentSales->count() > 0)
                    <table class="min-w-full divide-y divide-gaming">
                        <thead class="bg-dark-800/50">
                            <tr>
                                <th class="px-8 py-4 text-left text-xs font-bold text-muted-300 uppercase tracking-wider">Product</th>
                                <th class="px-8 py-4 text-left text-xs font-bold text-muted-300 uppercase tracking-wider">Buyer</th>
                                <th class="px-8 py-4 text-left text-xs font-bold text-muted-300 uppercase tracking-wider">Amount</th>
                                <th class="px-8 py-4 text-left text-xs font-bold text-muted-300 uppercase tracking-wider">Date</th>
                                <th class="px-8 py-4 text-left text-xs font-bold text-muted-300 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-dark-800/30 divide-y divide-gaming">
                            @foreach($recentSales as $sale)
                            <tr class="hover:bg-dark-700/50 transition-colors">
                                <td class="px-8 py-4 whitespace-nowrap">
                                    <div class="text-sm font-semibold text-white">{{ $sale->product->title }}</div>
                                </td>
                                <td class="px-8 py-4 whitespace-nowrap">
                                    <div class="text-sm text-muted-300">{{ $sale->order->user->name }}</div>
                                </td>
                                <td class="px-8 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-green-400">${{ number_format($sale->seller_amount, 2) }}</div>
                                </td>
                                <td class="px-8 py-4 whitespace-nowrap">
                                    <div class="text-sm text-muted-400">{{ $sale->created_at->diffForHumans() }}</div>
                                </td>
                                <td class="px-8 py-4 whitespace-nowrap">
                                    <x-ui.badge class="
                                        @if($sale->status === 'completed') bg-green-500/20 text-green-400 border-green-500/50
                                        @elseif($sale->status === 'pending') bg-yellow-500/20 text-yellow-400 border-yellow-500/50
                                        @else bg-muted-500/20 text-muted-400 border-muted-500/50
                                        @endif
                                    ">
                                        {{ ucfirst($sale->status) }}
                                    </x-ui.badge>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="px-8 py-16 text-center">
                        <div class="inline-flex items-center justify-center w-20 h-20 bg-muted-600/20 rounded-3xl mb-6">
                            <svg class="w-10 h-10 text-muted-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-2">No Sales Yet</h3>
                        <p class="text-muted-400 mb-6">Start selling products to see your sales here!</p>
                        <a href="{{ route('seller.products.create') }}" class="inline-flex items-center justify-center px-6 py-3 bg-gaming-gradient text-white font-semibold rounded-2xl hover:shadow-gaming transition-all">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Create Your First Product
                        </a>
                    </div>
                @endif
            </div>
        </x-ui.card>

        <!-- Gaming Top Products -->
        <x-ui.card variant="glass" class="animate-fade-in animation-delay-900">
            <div class="px-8 py-6 border-b border-gaming">
                <h2 class="text-3xl font-bold text-white flex items-center">
                    <svg class="w-8 h-8 mr-3 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                    </svg>
                    Top Selling Products
                </h2>
            </div>
            <div class="p-8">
                @if($topProducts->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($topProducts as $product)
                        <a href="{{ route('seller.products.edit', $product) }}" class="group">
                            <x-ui.card variant="glass" hover="true" class="h-full">
                                <div class="flex items-start space-x-4">
                                    <div class="w-20 h-20 bg-gaming-gradient rounded-2xl flex-shrink-0 relative overflow-hidden">
                                        @if($product->thumbnail_url)
                                            <img src="{{ $product->thumbnail_url }}" alt="{{ $product->title }}" class="w-full h-full object-cover rounded-2xl">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-white text-2xl font-black">
                                                {{ substr($product->title, 0, 1) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-lg font-bold text-white truncate group-hover:text-primary-400 transition-colors">{{ $product->title }}</h3>
                                        <div class="flex items-center mt-2 space-x-4">
                                            <div class="flex items-center text-green-400">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                                </svg>
                                                <span class="text-sm font-medium">{{ $product->sales_count }} sales</span>
                                            </div>
                                        </div>
                                        <div class="text-2xl font-black text-white mt-2">${{ number_format($product->price, 2) }}</div>
                                    </div>
                                </div>
                            </x-ui.card>
                        </a>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="inline-flex items-center justify-center w-20 h-20 bg-muted-600/20 rounded-3xl mb-6">
                            <svg class="w-10 h-10 text-muted-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-2">No Products Yet</h3>
                        <p class="text-muted-400 mb-6">Create your first product and start selling!</p>
                        <a href="{{ route('seller.products.create') }}" class="inline-flex items-center justify-center px-6 py-3 bg-gaming-gradient text-white font-semibold rounded-2xl hover:shadow-gaming transition-all">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Create Your First Product
                        </a>
                    </div>
                @endif
            </div>
        </x-ui.card>
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

.animation-delay-300 {
    animation-delay: 0.3s;
}

.animation-delay-400 {
    animation-delay: 0.4s;
}

.animation-delay-500 {
    animation-delay: 0.5s;
}

.animation-delay-600 {
    animation-delay: 0.6s;
}

.animation-delay-700 {
    animation-delay: 0.7s;
}

.animation-delay-800 {
    animation-delay: 0.8s;
}

.animation-delay-900 {
    animation-delay: 0.9s;
}

.animation-delay-2000 {
    animation-delay: 2s;
}

.animation-delay-4000 {
    animation-delay: 4s;
}
</style>
@endsection