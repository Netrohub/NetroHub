<x-layouts.stellar>
    <x-slot name="title">{{ __('Shopping Cart') }} - {{ config('app.name') }}</x-slot>

    <!-- Hero -->
    <section class="relative pt-32 pb-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <h1 class="h2 bg-clip-text text-transparent bg-gradient-to-r from-slate-200/60 via-slate-200 to-slate-200/60 text-center mb-2">
                {{ __('Shopping Cart') }}
            </h1>
            <p class="text-center text-slate-400">
                {{ $cartItems->count() }} {{ $cartItems->count() === 1 ? __('item') : __('items') }} {{ __('in your cart') }}
            </p>
        </div>
    </section>

    <!-- Cart Content -->
    <section class="relative pb-12 md:pb-20">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            
            @if($cartItems->count() > 0)
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Cart Items -->
                    <div class="lg:col-span-2 space-y-4">
                        @foreach($cartItems as $item)
                            <div class="bg-slate-800/50 rounded-2xl p-6 border border-slate-700/50 hover:border-slate-600 transition-colors" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
                                <div class="flex gap-4">
                                    <!-- Product Icon/Image -->
                                    <div class="w-20 h-20 bg-slate-700 rounded-xl flex items-center justify-center flex-shrink-0">
                                        <x-platform-icon :product="$item['product']" size="lg" />
                                    </div>

                                    <!-- Product Info -->
                                    <div class="flex-grow min-w-0">
                                        <a href="{{ route('products.show', $item['product']->slug) }}" class="text-lg font-bold text-slate-100 hover:text-purple-400 transition-colors block mb-1 truncate">
                                            {{ $item['product']->title }}
                                        </a>
                                        @if($item['product']->category)
                                            <span class="inline-block text-xs text-slate-400 bg-slate-700 px-2 py-1 rounded mb-2">
                                                {{ $item['product']->category->name }}
                                            </span>
                                        @endif
                                        @if($item['product']->seller)
                                            <p class="text-sm text-slate-400 flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                </svg>
                                                {{ $item['product']->seller->user->name }}
                                            </p>
                                        @endif
                                    </div>

                                    <!-- Price & Actions -->
                                    <div class="flex flex-col items-end justify-between">
                                        <div class="text-2xl font-bold text-white">
                                            ${{ number_format($item['product']->price, 2) }}
                                        </div>
                                        
                                        <!-- Remove Button -->
                                        <form action="{{ route('cart.remove', $item['product']) }}" method="POST" onsubmit="return confirm('{{ __('Remove this item from cart?') }}')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-400 hover:text-red-300 p-2 rounded-lg hover:bg-red-500/10 transition-colors">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <!-- Clear Cart Button -->
                        <div class="pt-4">
                            <form action="{{ route('cart.clear') }}" method="POST" onsubmit="return confirm('{{ __('Are you sure you want to clear your cart?') }}')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-slate-400 hover:text-red-400 text-sm transition-colors">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                    {{ __('Clear all items') }}
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="lg:col-span-1">
                        <div class="bg-slate-800/50 rounded-2xl p-6 border border-slate-700/50 sticky top-24" data-aos="fade-up" data-aos-delay="200">
                            <h3 class="text-lg font-bold text-slate-100 mb-6">{{ __('Order Summary') }}</h3>
                            
                            <div class="space-y-3 mb-6">
                                <div class="flex justify-between text-slate-300">
                                    <span>{{ __('Subtotal') }}</span>
                                    <span>${{ number_format($subtotal ?? array_sum(array_map(fn($item) => $item['product']->price, $cartItems->toArray())), 2) }}</span>
                                </div>
                                <div class="flex justify-between text-slate-300">
                                    <span>{{ __('Tax') }}</span>
                                    <span>${{ number_format($tax ?? 0, 2) }}</span>
                                </div>
                                @if(isset($discount) && $discount > 0)
                                    <div class="flex justify-between text-green-400">
                                        <span>{{ __('Discount') }}</span>
                                        <span>-${{ number_format($discount, 2) }}</span>
                                    </div>
                                @endif
                            </div>

                            <div class="border-t border-slate-700 pt-4 mb-6">
                                <div class="flex justify-between text-xl font-bold text-white">
                                    <span>{{ __('Total') }}</span>
                                    <span>${{ number_format($total ?? (($subtotal ?? 0) + ($tax ?? 0) - ($discount ?? 0)), 2) }}</span>
                                </div>
                            </div>

                            <!-- Promo Code -->
                            <div class="mb-6">
                                <form action="{{ route('cart.index') }}" method="GET" class="flex gap-2">
                                    <input 
                                        type="text" 
                                        name="promo"
                                        placeholder="{{ __('Promo code') }}" 
                                        class="form-input flex-1"
                                        value="{{ request('promo') }}"
                                    />
                                    <button type="submit" class="btn text-slate-300 hover:text-white bg-slate-700 hover:bg-slate-600 px-4">
                                        {{ __('Apply') }}
                                    </button>
                                </form>
                            </div>

                            <!-- Checkout Button -->
                            <a href="{{ route('checkout.index') }}" 
                               class="btn text-white bg-purple-500 hover:bg-purple-600 w-full shadow-lg shadow-purple-500/25 mb-4">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                </svg>
                                {{ __('Proceed to Checkout') }}
                            </a>

                            <!-- Continue Shopping -->
                            <a href="{{ route('products.index') }}" 
                               class="btn text-slate-300 hover:text-white bg-slate-700 hover:bg-slate-600 w-full">
                                {{ __('Continue Shopping') }}
                            </a>

                            <!-- Trust Badges -->
                            <div class="mt-6 pt-6 border-t border-slate-700">
                                <div class="space-y-3 text-sm text-slate-400">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ __('Secure Payment') }}
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ __('Instant Delivery') }}
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ __('24/7 Support') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- Empty Cart State -->
                <div class="text-center py-16" data-aos="fade-up">
                    <div class="inline-flex items-center justify-center w-24 h-24 bg-slate-800 rounded-full mb-6">
                        <svg class="w-12 h-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-100 mb-2">{{ __('Your cart is empty') }}</h3>
                    <p class="text-slate-400 mb-8">{{ __('Add some products to get started!') }}</p>
                    <a href="{{ route('products.index') }}" 
                       class="btn text-slate-900 bg-gradient-to-r from-white/80 via-white to-white/80 hover:bg-white inline-flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        {{ __('Browse Products') }}
                    </a>
                </div>
            @endif
        </div>
    </section>
</x-layouts.stellar>
