<x-layouts.app>
    <x-slot name="title">{{ __('Checkout') }} - {{ config('app.name') }}</x-slot>

    <!-- Hero -->
    <section class="relative pt-32 pb-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <h1 class="h2 bg-clip-text text-transparent bg-gradient-to-r from-slate-200/60 via-slate-200 to-slate-200/60 text-center mb-2">
                {{ __('Checkout') }}
            </h1>
            <p class="text-center text-slate-400">
                {{ __('Complete your purchase securely') }}
            </p>
        </div>
    </section>

    <!-- Checkout Content -->
    <section class="relative pb-12 md:pb-20">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form">
                @csrf
                
                <div class="grid lg:grid-cols-3 gap-8">
                    <!-- Left Column - Checkout Form -->
                    <div class="lg:col-span-2 space-y-6">
                        
                        <!-- Payment Method -->
                        <div class="bg-slate-800/50 rounded-2xl p-6 lg:p-8 border border-slate-700/50" data-aos="fade-up">
                            <h2 class="text-xl font-bold text-slate-100 mb-6 flex items-center">
                                <svg class="w-6 h-6 text-purple-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                </svg>
                                {{ __('Payment Method') }}
                            </h2>

                            <div class="space-y-4">
                                @if(config('services.paddle.vendor_id'))
                                    <label class="relative flex items-center p-4 bg-slate-700/30 rounded-xl cursor-pointer hover:bg-slate-700/50 transition-colors border-2 border-transparent has-[:checked]:border-purple-500">
                                        <input type="radio" name="payment_method" value="paddle" class="sr-only peer" checked>
                                        <div class="flex items-center flex-1">
                                            <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg flex items-center justify-center mr-4">
                                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <div class="text-slate-100 font-medium">{{ __('Credit/Debit Card') }}</div>
                                                <div class="text-sm text-slate-400">{{ __('Secure payment via Paddle') }}</div>
                                            </div>
                                        </div>
                                        <div class="w-5 h-5 rounded-full border-2 border-slate-500 peer-checked:border-purple-500 peer-checked:bg-purple-500 flex items-center justify-center">
                                            <svg class="w-3 h-3 text-white hidden peer-checked:block" fill="currentColor" viewBox="0 0 12 12">
                                                <path d="M10.28.28 3.989 6.575 1.695 4.28A1 1 0 0 0 .28 5.695l3 3a1 1 0 0 0 1.414 0l7-7A1 1 0 0 0 10.28.28Z"/>
                                            </svg>
                                        </div>
                                    </label>
                                @endif

                                @if(config('services.tap.secret_key'))
                                    <label class="relative flex items-center p-4 bg-slate-700/30 rounded-xl cursor-pointer hover:bg-slate-700/50 transition-colors border-2 border-transparent has-[:checked]:border-purple-500">
                                        <input type="radio" name="payment_method" value="tap" class="sr-only peer">
                                        <div class="flex items-center flex-1">
                                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center mr-4">
                                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <div class="text-slate-100 font-medium">{{ __('Tap Payment') }}</div>
                                                <div class="text-sm text-slate-400">{{ __('Local payment methods') }}</div>
                                            </div>
                                        </div>
                                        <div class="w-5 h-5 rounded-full border-2 border-slate-500 peer-checked:border-purple-500 peer-checked:bg-purple-500"></div>
                                    </label>
                                @endif

                                @if((auth()->user()->wallet_balance ?? 0) > 0)
                                    <label class="relative flex items-center p-4 bg-slate-700/30 rounded-xl cursor-pointer hover:bg-slate-700/50 transition-colors border-2 border-transparent has-[:checked]:border-purple-500">
                                        <input type="radio" name="payment_method" value="wallet" class="sr-only peer">
                                        <div class="flex items-center flex-1">
                                            <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center mr-4">
                                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <div class="text-slate-100 font-medium">{{ __('Wallet Balance') }}</div>
                                                <div class="text-sm text-slate-400">
                                                    {{ __('Available: $:amount', ['amount' => number_format(auth()->user()->wallet_balance ?? 0, 2)]) }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="w-5 h-5 rounded-full border-2 border-slate-500 peer-checked:border-purple-500 peer-checked:bg-purple-500"></div>
                                    </label>
                                @endif
                            </div>
                        </div>

                        <!-- Billing Information -->
                        <div class="bg-slate-800/50 rounded-2xl p-6 lg:p-8 border border-slate-700/50" data-aos="fade-up" data-aos-delay="100">
                            <h2 class="text-xl font-bold text-slate-100 mb-6 flex items-center">
                                <svg class="w-6 h-6 text-purple-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                {{ __('Billing Information') }}
                            </h2>

                            <div class="grid md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm text-slate-300 font-medium mb-2">{{ __('Full Name') }}</label>
                                    <input type="text" name="billing_name" value="{{ auth()->user()->name }}" class="form-input w-full" required>
                                </div>
                                <div>
                                    <label class="block text-sm text-slate-300 font-medium mb-2">{{ __('Email') }}</label>
                                    <input type="email" name="billing_email" value="{{ auth()->user()->email }}" class="form-input w-full" required>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm text-slate-300 font-medium mb-2">{{ __('Phone') }}</label>
                                    <input type="tel" name="billing_phone" value="{{ auth()->user()->phone }}" class="form-input w-full">
                                </div>
                            </div>
                        </div>

                        <!-- Terms & Conditions -->
                        <div class="bg-slate-800/50 rounded-2xl p-6 border border-slate-700/50" data-aos="fade-up" data-aos-delay="200">
                            <label class="flex items-start cursor-pointer">
                                <input type="checkbox" name="agree_terms" class="form-checkbox text-purple-500 mt-1" required>
                                <span class="ml-3 text-sm text-slate-300">
                                    {{ __('I agree to the') }}
                                    <a href="{{ route('legal.terms') }}" target="_blank" class="text-purple-400 hover:text-purple-300">{{ __('Terms & Conditions') }}</a>
                                    {{ __('and') }}
                                    <a href="{{ route('legal.privacy') }}" target="_blank" class="text-purple-400 hover:text-purple-300">{{ __('Privacy Policy') }}</a>
                                </span>
                            </label>
                        </div>
                    </div>

                    <!-- Right Column - Order Summary -->
                    <div class="lg:col-span-1">
                        <div class="bg-slate-800/50 rounded-2xl p-6 border border-slate-700/50 sticky top-24" data-aos="fade-up" data-aos-delay="300">
                            <h3 class="text-lg font-bold text-slate-100 mb-6">{{ __('Order Summary') }}</h3>
                            
                            <!-- Cart Items -->
                            <div class="space-y-4 mb-6 pb-6 border-b border-slate-700">
                                @foreach($cartItems ?? [] as $item)
                                    <div class="flex gap-3">
                                        <div class="w-12 h-12 bg-slate-700 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <x-platform-icon :product="$item['product']" />
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="text-sm text-slate-100 font-medium truncate">{{ $item['product']->title }}</div>
                                            <div class="text-xs text-slate-400">{{ $item['product']->category->name ?? '' }}</div>
                                        </div>
                                        <div class="text-sm font-bold text-white">${{ number_format($item['product']->price, 2) }}</div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Price Breakdown -->
                            <div class="space-y-3 mb-6">
                                <div class="flex justify-between text-slate-300">
                                    <span>{{ __('Subtotal') }}</span>
                                    <span>${{ number_format($subtotal ?? 0, 2) }}</span>
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
                                    <span>${{ number_format($total ?? 0, 2) }}</span>
                                </div>
                            </div>

                            <!-- Complete Purchase Button -->
                            <button type="submit" class="btn text-white bg-purple-500 hover:bg-purple-600 w-full shadow-lg shadow-purple-500/25 mb-4">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ __('Complete Purchase') }}
                            </button>

                            <!-- Security Badges -->
                            <div class="space-y-2 text-xs text-slate-400">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ __('256-bit SSL Encryption') }}
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ __('PCI DSS Compliant') }}
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ __('Money-back Guarantee') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</x-layouts.app>
