@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Success Message -->
        <div class="bg-white rounded-lg shadow-sm p-8 text-center mb-8">
            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Payment Successful!</h1>
            <p class="text-lg text-gray-600 mb-6">Thank you for your purchase. Your order has been completed.</p>
            
            <div class="inline-flex items-center px-4 py-2 bg-gray-100 rounded-lg text-sm text-gray-700">
                <span class="font-medium">Order #{{ $order->id }}</span>
                <span class="mx-2">•</span>
                <span>{{ $order->created_at->format('M d, Y') }}</span>
            </div>
        </div>

        <!-- Order Details -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Order Details</h2>
            
            <div class="space-y-4">
                @foreach($order->items as $item)
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-start space-x-4">
                                <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg overflow-hidden flex-shrink-0">
                                    @if($item->product->thumbnail_url)
                                        <img src="{{ $item->product->thumbnail_url }}" alt="{{ $item->product_title }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-white text-xl font-bold">
                                            {{ substr($item->product_title, 0, 1) }}
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900">{{ $item->product_title }}</h3>
                                    <p class="text-sm text-gray-600">{{ ucfirst($item->delivery_type) }} delivery</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="font-bold text-gray-900">${{ number_format($item->price, 2) }}</div>
                            </div>
                        </div>

                        @if($item->delivery_status === 'delivered')
                            <!-- Download Links -->
                            @if($item->delivery_payload && isset($item->delivery_payload['files']))
                                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                                    <h4 class="font-medium text-blue-900 mb-2">Download Files</h4>
                                    <div class="space-y-2">
                                        @foreach($item->delivery_payload['files'] as $fileUrl)
                                            <a href="{{ $fileUrl }}" target="_blank" class="flex items-center text-sm text-blue-600 hover:text-blue-700">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                                Download File
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- License Keys -->
                            @if($item->delivery_payload && isset($item->delivery_payload['codes']))
                                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                    <h4 class="font-medium text-green-900 mb-2">Your License Key</h4>
                                    @foreach($item->delivery_payload['codes'] as $code)
                                        <div class="flex items-center justify-between bg-white rounded px-4 py-2 font-mono text-sm">
                                            <code>{{ $code }}</code>
                                            <button onclick="navigator.clipboard.writeText('{{ $code }}')" class="text-green-600 hover:text-green-700">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                                </svg>
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        @else
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                <p class="text-sm text-yellow-800">Your files are being prepared and will be available shortly.</p>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Order Summary -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Payment Summary</h2>
            
            <div class="space-y-2">
                <div class="flex justify-between text-gray-600">
                    <span>Subtotal</span>
                    <span>${{ number_format($order->subtotal, 2) }}</span>
                </div>
                <div class="flex justify-between text-sm text-gray-500">
                    <span>Platform Fee</span>
                    <span>${{ number_format($order->platform_fee, 2) }}</span>
                </div>
                <div class="border-t border-gray-200 pt-2 mt-2">
                    <div class="flex justify-between text-lg font-bold text-gray-900">
                        <span>Total Paid</span>
                        <span>${{ number_format($order->total, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex flex-col sm:flex-row gap-4">
            <a href="{{ route('products.index') }}" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg text-center transition-colors">
                Continue Shopping
            </a>
            <a href="{{ route('home') }}" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-900 font-bold py-3 px-6 rounded-lg text-center transition-colors">
                Go to Homepage
            </a>
        </div>

        <!-- Email Confirmation Notice -->
        <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex">
                <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                </svg>
                <div class="text-sm text-blue-800">
                    <p class="font-medium mb-1">Order Confirmation Email Sent</p>
                    <p>We've sent a confirmation email to <strong>{{ $order->buyer_email }}</strong> with your order details and download links.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
