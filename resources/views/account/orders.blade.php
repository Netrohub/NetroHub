<x-layouts.stellar>
    <x-slot name="title">{{ __('My Orders') }} - {{ config('app.name') }}</x-slot>

    <section class="relative pt-32 pb-12 md:pb-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            
            <h1 class="h2 bg-clip-text text-transparent bg-gradient-to-r from-slate-200/60 via-slate-200 to-slate-200/60 mb-8">
                {{ __('My Orders') }}
            </h1>

            <div class="lg:flex lg:gap-8">
                
                <!-- Sidebar -->
                <x-stellar.account-sidebar />

                <!-- Main Content -->
                <div class="flex-1 min-w-0">
                    
                    <!-- Filters -->
                    <div class="bg-slate-800/50 rounded-2xl p-6 border border-slate-700/50 mb-8" data-aos="fade-up">
                        <form method="GET" class="grid md:grid-cols-3 gap-4">
                            <div>
                                <select name="status" onchange="this.form.submit()" class="form-select w-full">
                                    <option value="">{{ __('All Statuses') }}</option>
                                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
                                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>{{ __('Completed') }}</option>
                                    <option value="refunded" {{ request('status') === 'refunded' ? 'selected' : '' }}>{{ __('Refunded') }}</option>
                                    <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>{{ __('Failed') }}</option>
                                </select>
                            </div>
                            <div>
                                <input type="search" name="search" placeholder="{{ __('Search orders...') }}" value="{{ request('search') }}" class="form-input w-full">
                            </div>
                            <div>
                                <select name="sort" onchange="this.form.submit()" class="form-select w-full">
                                    <option value="latest" {{ request('sort') === 'latest' ? 'selected' : '' }}>{{ __('Latest First') }}</option>
                                    <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>{{ __('Oldest First') }}</option>
                                    <option value="amount_high" {{ request('sort') === 'amount_high' ? 'selected' : '' }}>{{ __('Amount: High to Low') }}</option>
                                    <option value="amount_low" {{ request('sort') === 'amount_low' ? 'selected' : '' }}>{{ __('Amount: Low to High') }}</option>
                                </select>
                            </div>
                        </form>
                    </div>

                    <!-- Orders List -->
                    @if(isset($orders) && $orders->count() > 0)
                        <div class="space-y-6">
                            @foreach($orders as $order)
                                <div class="bg-slate-800/50 rounded-2xl border border-slate-700/50 overflow-hidden hover:border-purple-500/30 transition-colors" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 5) * 50 }}">
                                    <!-- Order Header -->
                                    <div class="p-6 border-b border-slate-700/50">
                                        <div class="flex flex-wrap items-center justify-between gap-4">
                                            <div class="flex items-center gap-4">
                                                <div class="w-12 h-12 bg-slate-700 rounded-lg flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <div class="text-slate-100 font-bold">{{ __('Order #:id', ['id' => $order->id]) }}</div>
                                                    <div class="text-sm text-slate-400">{{ $order->created_at->format('M d, Y h:i A') }}</div>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <div class="text-2xl font-bold text-white mb-1">${{ number_format($order->total, 2) }}</div>
                                                <span class="inline-flex items-center text-xs px-3 py-1 rounded-full {{ 
                                                    $order->status === 'completed' ? 'bg-green-500/20 text-green-400 border border-green-500/30' : 
                                                    ($order->status === 'pending' ? 'bg-yellow-500/20 text-yellow-400 border border-yellow-500/30' : 
                                                    'bg-red-500/20 text-red-400 border border-red-500/30') 
                                                }}">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Order Items -->
                                    <div class="p-6">
                                        <div class="space-y-3">
                                            @foreach($order->items as $item)
                                                <div class="flex items-center gap-4">
                                                    <div class="w-12 h-12 bg-slate-700 rounded-lg flex items-center justify-center flex-shrink-0">
                                                        <x-platform-icon :product="$item->product" />
                                                    </div>
                                                    <div class="flex-1 min-w-0">
                                                        <div class="text-slate-100 font-medium truncate">{{ $item->product->title }}</div>
                                                        <div class="text-sm text-slate-400">{{ $item->product->category->name ?? '' }}</div>
                                                    </div>
                                                    <div class="text-white font-bold">${{ number_format($item->price, 2) }}</div>
                                                </div>
                                            @endforeach
                                        </div>

                                        <!-- Actions -->
                                        <div class="mt-6 pt-6 border-t border-slate-700/50 flex flex-wrap gap-3">
                                            @if($order->status === 'completed')
                                                <a href="{{ route('orders.delivery', $order) }}" class="btn text-white bg-purple-500 hover:bg-purple-600">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                    </svg>
                                                    {{ __('View Items') }}
                                                </a>
                                            @endif
                                            <a href="#" class="btn text-slate-300 hover:text-white bg-slate-700 hover:bg-slate-600">
                                                {{ __('View Receipt') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        @if($orders->hasPages())
                            <div class="mt-8">
                                {{ $orders->links() }}
                            </div>
                        @endif
                    @else
                        <div class="bg-slate-800/50 rounded-2xl p-12 border border-slate-700/50 text-center" data-aos="fade-up">
                            <div class="w-20 h-20 bg-slate-700 rounded-full flex items-center justify-center mx-auto mb-6">
                                <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-slate-100 mb-2">{{ __('No orders yet') }}</h3>
                            <p class="text-slate-400 mb-6">{{ __('Start shopping to see your orders here') }}</p>
                            <a href="{{ route('products.index') }}" class="btn text-slate-900 bg-gradient-to-r from-white/80 via-white to-white/80 hover:bg-white inline-flex">
                                {{ __('Browse Products') }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</x-layouts.stellar>
