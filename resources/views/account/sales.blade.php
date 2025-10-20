<x-layouts.app>
    <x-slot name="title">{{ __('My Sales') }} - {{ config('app.name') }}</x-slot>

    <section class="relative pt-32 pb-12 md:pb-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            
            <h1 class="h2 bg-clip-text text-transparent bg-gradient-to-r from-slate-200/60 via-slate-200 to-slate-200/60 mb-8">
                {{ __('My Sales') }}
            </h1>

            <div class="lg:flex lg:gap-8">
                
                <!-- Sidebar -->
                <x-stellar.account-sidebar />

                <!-- Main Content -->
                <div class="flex-1 min-w-0 space-y-8">
                    
                    <!-- Sales Stats -->
                    <div class="grid md:grid-cols-3 gap-6">
                        <div class="bg-slate-800/50 rounded-2xl p-6 border border-slate-700/50" data-aos="fade-up">
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-slate-400 text-sm">{{ __('Total Sales') }}</span>
                                <div class="w-10 h-10 bg-green-500/20 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 8h6m-5 0a3 3 0 110 6H9l3 3m-3-6h6m6 1a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="text-3xl font-bold text-white">${{ number_format($totalSalesAmount ?? 0, 2) }}</div>
                        </div>

                        <div class="bg-slate-800/50 rounded-2xl p-6 border border-slate-700/50" data-aos="fade-up" data-aos-delay="100">
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-slate-400 text-sm">{{ __('Orders') }}</span>
                                <div class="w-10 h-10 bg-blue-500/20 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="text-3xl font-bold text-white">{{ $totalSalesCount ?? 0 }}</div>
                        </div>

                        <div class="bg-slate-800/50 rounded-2xl p-6 border border-slate-700/50" data-aos="fade-up" data-aos-delay="200">
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-slate-400 text-sm">{{ __('Avg. Order') }}</span>
                                <div class="w-10 h-10 bg-purple-500/20 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="text-3xl font-bold text-white">${{ number_format($avgOrderValue ?? 0, 2) }}</div>
                        </div>
                    </div>

                    <!-- Sales List -->
                    <div class="bg-slate-800/50 rounded-2xl p-6 lg:p-8 border border-slate-700/50" data-aos="fade-up" data-aos-delay="300">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-xl font-bold text-slate-100">{{ __('Recent Sales') }}</h2>
                            @if($seller ?? false)
                                <a href="{{ route('seller.dashboard') }}" class="text-purple-400 hover:text-purple-300 text-sm font-medium">
                                    {{ __('Seller Dashboard') }} →
                                </a>
                            @endif
                        </div>

                        @if(isset($sales) && $sales->count() > 0)
                            <div class="space-y-4">
                                @foreach($sales as $sale)
                                    <div class="flex items-center justify-between p-4 bg-slate-700/30 rounded-xl hover:bg-slate-700/50 transition-colors">
                                        <div class="flex items-center gap-4 flex-1">
                                            <div class="w-12 h-12 bg-slate-700 rounded-lg flex items-center justify-center">
                                                <x-platform-icon :product="$sale->product ?? null" />
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <div class="text-slate-100 font-medium truncate">{{ $sale->product->title ?? __('Product') }}</div>
                                                <div class="text-sm text-slate-400">{{ $sale->created_at->format('M d, Y') }}</div>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-green-400 font-bold">+${{ number_format($sale->amount ?? $sale->price, 2) }}</div>
                                            <span class="text-xs px-2 py-1 rounded-full bg-green-500/20 text-green-400">
                                                {{ ucfirst($sale->status ?? 'completed') }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            @if($sales->hasPages())
                                <div class="mt-6">
                                    {{ $sales->links() }}
                                </div>
                            @endif
                        @else
                            <div class="text-center py-12">
                                <div class="w-16 h-16 bg-slate-700 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 8h6m-5 0a3 3 0 110 6H9l3 3m-3-6h6m6 1a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <p class="text-slate-400 mb-4">{{ __('No sales yet') }}</p>
                                @if(!($seller ?? false))
                                    <a href="{{ route('sell.index') }}" class="btn text-slate-900 bg-gradient-to-r from-white/80 via-white to-white/80 hover:bg-white inline-flex">
                                        {{ __('Start Selling') }}
                                    </a>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
