@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Shopping Cart</h1>

        @if($cartItems->count() > 0)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Cart Items -->
                <div class="lg:col-span-2 space-y-4">
                    @foreach($cartItems as $item)
                        <div class="bg-white rounded-lg shadow-sm p-6 flex flex-col sm:flex-row gap-4">
                            <!-- Product Image -->
                            <div class="w-full sm:w-32 h-32 flex-shrink-0">
                                <a href="{{ route('products.show', $item['product']->slug) }}" class="block aspect-square bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg overflow-hidden">
                                    @if($item['product']->thumbnail_url)
                                        <img src="{{ $item['product']->thumbnail_url }}" alt="{{ $item['product']->title }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-white text-2xl font-bold">
                                            {{ substr($item['product']->title, 0, 1) }}
                                        </div>
                                    @endif
                                </a>
                            </div>

                            <!-- Product Info -->
                            <div class="flex-1">
                                <a href="{{ route('products.show', $item['product']->slug) }}" class="text-lg font-semibold text-gray-900 hover:text-blue-600 mb-2 block">
                                    {{ $item['product']->title }}
                                </a>
                                <p class="text-sm text-gray-600 mb-2">by {{ $item['product']->seller->user->name }}</p>
                                <p class="text-sm text-gray-600 line-clamp-2">{{ Str::limit($item['product']->description, 100) }}</p>
                            </div>

                            <!-- Price and Actions -->
                            <div class="flex sm:flex-col items-end justify-between sm:justify-start sm:text-right space-y-0 sm:space-y-4">
                                <div class="text-2xl font-bold text-gray-900">
                                    ${{ number_format($item['product']->price * $item['quantity'], 2) }}
                                </div>
                                
                                <form action="{{ route('cart.remove', $item['product']) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-700 text-sm font-medium">
                                        Remove
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach

                    <!-- Clear Cart -->
                    <div class="flex justify-end">
                        <form action="{{ route('cart.clear') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-gray-600 hover:text-gray-700 text-sm font-medium">
                                Clear entire cart
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-sm p-6 sticky top-8">
                        <h2 class="text-xl font-bold text-gray-900 mb-6">Order Summary</h2>
                        
                        <div class="space-y-4 mb-6">
                            <div class="flex justify-between text-gray-600">
                                <span>Subtotal</span>
                                <span class="font-medium">${{ number_format($subtotal, 2) }}</span>
                            </div>
                            
                            <div class="flex justify-between text-sm text-gray-500">
                                <span>Items</span>
                                <span>{{ $cartItems->count() }}</span>
                            </div>
                        </div>

                        <div class="border-t border-gray-200 pt-4 mb-6">
                            <div class="flex justify-between text-lg font-bold text-gray-900">
                                <span>Total</span>
                                <span>${{ number_format($total, 2) }}</span>
                            </div>
                        </div>

                        <a href="{{ route('checkout.index') }}" class="block w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg text-center transition-colors">
                            Proceed to Checkout
                        </a>

                        <a href="{{ route('products.index') }}" class="block w-full mt-4 text-center text-blue-600 hover:text-blue-700 font-medium">
                            Continue Shopping
                        </a>

                        <!-- Trust Badges -->
                        <div class="mt-6 pt-6 border-t border-gray-200 space-y-3">
                            <div class="flex items-center text-sm text-gray-600">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>Secure checkout</span>
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>Instant delivery</span>
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>24/7 Support</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Empty Cart -->
            <div class="bg-white rounded-lg shadow-sm p-12 text-center">
                <svg class="mx-auto h-24 w-24 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Your cart is empty</h2>
                <p class="text-gray-600 mb-6">Add some products to get started!</p>
                <a href="{{ route('products.index') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg transition-colors">
                    Browse Products
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

