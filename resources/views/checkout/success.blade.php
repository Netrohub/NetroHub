<x-layouts.stellar>
    <x-slot name="title">{{ __('Order Success') }} - {{ config('app.name') }}</x-slot>

<section class="relative pt-32 pb-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Success Message -->
        <div class="bg-slate-800 border border-slate-700 rounded-2xl p-8 text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-green-500/20 mb-6">
                <svg class="w-10 h-10 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            
            <h1 class="text-3xl font-bold text-slate-200 mb-2">{{ __('Payment Successful!') }}</h1>
            <p class="text-lg text-slate-400 mb-6">{{ __('Thank you for your purchase. Your order has been completed.') }}</p>
            
            <div class="inline-flex items-center px-4 py-2 bg-slate-700 rounded-lg text-sm text-slate-300">
                <span class="font-medium">{{ __('Order #:id', ['id' => $order->id]) }}</span>
                <span class="mx-2">•</span>
                <span>{{ $order->created_at->format('M d, Y') }}</span>
            </div>
        </div>

        <!-- Order Details -->
        <div class="bg-slate-800 border border-slate-700 rounded-2xl p-6 mb-8">
            <h2 class="text-xl font-bold text-slate-200 mb-6">{{ __('Order Details') }}</h2>
            
            <div class="space-y-4">
                @foreach($order->items as $item)
                    <div class="border border-slate-700 rounded-xl p-4">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-start space-x-4">
                                <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg overflow-hidden flex-shrink-0">
                                    @if($item->product->thumbnail_url)
                                        <img src="{{ $item->product->thumbnail_url }}" alt="{{ $item->product_title }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-white text-xl font-bold">
                                            {{ substr($item->product_title, 0, 1) }}
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <h3 class="font-semibold text-slate-200">{{ $item->product_title }}</h3>
                                    <p class="text-sm text-slate-400">{{ ucfirst($item->delivery_type) }} {{ __('delivery') }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="font-bold text-slate-200">${{ number_format($item->price, 2) }}</div>
                            </div>
                        </div>

                        @if($item->delivery_status === 'delivered')
                            <!-- Download Links -->
                            @if($item->delivery_payload && isset($item->delivery_payload['files']))
                                <div class="bg-blue-500/10 border border-blue-500/30 rounded-lg p-4 mb-4">
                                    <h4 class="font-medium text-blue-400 mb-2">{{ __('Download Files') }}</h4>
                                    <div class="space-y-2">
                                        @foreach($item->delivery_payload['files'] as $fileUrl)
                                            <a href="{{ $fileUrl }}" target="_blank" class="flex items-center text-sm text-blue-400 hover:text-blue-300">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                                {{ __('Download File') }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- License Keys -->
                            @if($item->delivery_payload && isset($item->delivery_payload['codes']))
                                <div class="bg-green-500/10 border border-green-500/30 rounded-lg p-4">
                                    <h4 class="font-medium text-green-400 mb-2">{{ __('Your License Key') }}</h4>
                                    @foreach($item->delivery_payload['codes'] as $code)
                                        <div class="flex items-center justify-between bg-slate-900 rounded px-4 py-2 font-mono text-sm">
                                            <code class="text-slate-300">{{ $code }}</code>
                                            <button onclick="navigator.clipboard.writeText('{{ $code }}')" class="text-green-400 hover:text-green-300">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                                </svg>
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        @else
                            <div class="bg-yellow-500/10 border border-yellow-500/30 rounded-lg p-4">
                                <p class="text-sm text-yellow-400">{{ __('Your files are being prepared and will be available shortly.') }}</p>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Order Summary -->
        <div class="bg-slate-800 border border-slate-700 rounded-2xl p-6 mb-8">
            <h2 class="text-xl font-bold text-slate-200 mb-4">{{ __('Payment Summary') }}</h2>
            
            <div class="space-y-2">
                <div class="flex justify-between text-slate-400">
                    <span>{{ __('Subtotal') }}</span>
                    <span>${{ number_format($order->subtotal, 2) }}</span>
                </div>
                <div class="flex justify-between text-sm text-slate-500">
                    <span>{{ __('Platform Fee') }}</span>
                    <span>${{ number_format($order->platform_fee, 2) }}</span>
                </div>
                <div class="border-t border-slate-700 pt-2 mt-2">
                    <div class="flex justify-between text-lg font-bold text-slate-200">
                        <span>{{ __('Total Paid') }}</span>
                        <span>${{ number_format($order->total, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex flex-col sm:flex-row gap-4">
            <a href="{{ route('products.index') }}" class="flex-1 btn text-slate-900 bg-gradient-to-r from-white/80 via-white to-white/80 hover:bg-white text-center">
                {{ __('Continue Shopping') }}
            </a>
            <a href="{{ route('home') }}" class="flex-1 btn text-slate-300 bg-slate-700 hover:bg-slate-600 border border-slate-600 text-center">
                {{ __('Go to Homepage') }}
            </a>
        </div>

        <!-- Email Confirmation Notice -->
        <div class="mt-8 bg-blue-500/10 border border-blue-500/30 rounded-xl p-4">
            <div class="flex">
                <svg class="w-5 h-5 text-blue-400 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                </svg>
                <div class="text-sm text-slate-300">
                    <p class="font-medium mb-1">{{ __('Order Confirmation Email Sent') }}</p>
                    <p>{{ __('We\'ve sent a confirmation email to :email with your order details and download links.', ['email' => $order->buyer_email]) }}</p>
                </div>
            </div>
        </div>
    </div>
</section>

</x-layouts.stellar>
