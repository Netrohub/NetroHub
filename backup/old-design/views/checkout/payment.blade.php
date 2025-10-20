<x-layouts.stellar>
    <x-slot name="title">{{ __('Complete Payment') }} - {{ config('app.name') }}</x-slot>

@push('styles')
<script src="https://cdn.paddle.com/paddle/v2/paddle.js"></script>
@endpush

<section class="relative pt-32 pb-12">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-slate-800 border border-slate-700 rounded-2xl p-8">
            <h1 class="text-2xl font-bold text-slate-200 mb-6">{{ __('Complete Your Payment') }}</h1>

            <div class="mb-6">
                <div class="flex justify-between mb-2">
                    <span class="text-slate-400">{{ __('Order Number:') }}</span>
                    <span class="font-semibold text-slate-200">{{ $order->order_number }}</span>
                </div>
                <div class="flex justify-between mb-2">
                    <span class="text-slate-400">{{ __('Total Amount:') }}</span>
                    <span class="font-semibold text-xl text-slate-200">${{ number_format($order->total, 2) }}</span>
                </div>
            </div>

            <div class="border-t border-slate-700 pt-6">
                <h3 class="text-lg font-semibold text-slate-200 mb-4">{{ __('Order Items:') }}</h3>
                @foreach($order->items as $item)
                    <div class="flex justify-between mb-2 text-slate-300">
                        <span>{{ $item->product_title }} (x{{ $item->quantity }})</span>
                        <span>${{ number_format($item->price * $item->quantity, 2) }}</span>
                    </div>
                @endforeach
            </div>

            <div class="mt-8">
                <button 
                    id="paddle-checkout-btn"
                    class="btn text-slate-900 bg-gradient-to-r from-white/80 via-white to-white/80 hover:bg-white w-full">
                    {{ __('Pay with Paddle') }} - ${{ number_format($order->total, 2) }}
                </button>
            </div>

            <div class="mt-4 text-center text-sm text-slate-400">
                <p>🔒 {{ __('Secure payment powered by Paddle') }}</p>
                <p class="mt-2">{{ __('Paddle handles VAT/GST and provides localized payment methods') }}</p>
            </div>
        </div>
    </div>
</section>

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

</x-layouts.stellar>
