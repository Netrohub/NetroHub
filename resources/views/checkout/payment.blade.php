@extends('layouts.app')

@section('title', 'Complete Payment')

@push('styles')
<script src="https://cdn.paddle.com/paddle/v2/paddle.js"></script>
@endpush

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8">
        <h1 class="text-2xl font-bold mb-6">Complete Your Payment</h1>

        <div class="mb-6">
            <div class="flex justify-between mb-2">
                <span class="text-gray-600 dark:text-gray-400">Order Number:</span>
                <span class="font-semibold">{{ $order->order_number }}</span>
            </div>
            <div class="flex justify-between mb-2">
                <span class="text-gray-600 dark:text-gray-400">Total Amount:</span>
                <span class="font-semibold text-xl">${{ number_format($order->total, 2) }}</span>
            </div>
        </div>

        <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
            <h3 class="text-lg font-semibold mb-4">Order Items:</h3>
            @foreach($order->items as $item)
                <div class="flex justify-between mb-2">
                    <span>{{ $item->product_title }} (x{{ $item->quantity }})</span>
                    <span>${{ number_format($item->price * $item->quantity, 2) }}</span>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            <button 
                id="paddle-checkout-btn"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition">
                Pay with Paddle - ${{ number_format($order->total, 2) }}
            </button>
        </div>

        <div class="mt-4 text-center text-sm text-gray-600 dark:text-gray-400">
            <p>🔒 Secure payment powered by Paddle</p>
            <p class="mt-2">Paddle handles VAT/GST and provides localized payment methods</p>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Paddle
    Paddle.Initialize({
        @if(config('services.paddle.environment') === 'sandbox')
        environment: 'sandbox',
        @endif
        token: '{{ config('services.paddle.vendor_id') }}',
        eventCallback: function(data) {
            console.log('Paddle event:', data);
            
            // Handle successful payment
            if (data.name === 'checkout.completed') {
                window.location.href = '{{ route('checkout.success', $order) }}';
            }
        }
    });

    // Handle checkout button click
    document.getElementById('paddle-checkout-btn').addEventListener('click', function() {
        Paddle.Checkout.open({
            transactionId: '{{ $paddleTransactionId }}',
        });
    });
});
</script>
@endpush
