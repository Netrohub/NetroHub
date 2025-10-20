<x-layouts.app>
    <x-slot name="title">{{ __('Payouts') }} - {{ config('app.name') }}</x-slot>

    <section class="relative pt-32 pb-12 md:pb-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            
            <h1 class="h2 bg-clip-text text-transparent bg-gradient-to-r from-slate-200/60 via-slate-200 to-slate-200/60 mb-8">
                {{ __('Payout Requests') }}
            </h1>

            <div class="lg:flex lg:gap-8">
                
                <!-- Sidebar -->
                <x-account-sidebar />

                <!-- Main Content -->
                <div class="flex-1 min-w-0 space-y-8">
                    
                    <!-- Available Balance -->
                    <div class="bg-gradient-to-br from-green-500/20 to-green-600/10 rounded-2xl p-6 border border-green-500/30" data-aos="fade-up">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="text-sm text-green-300 mb-1">{{ __('Available for Withdrawal') }}</div>
                                <div class="text-4xl font-bold text-white">
                                    ${{ number_format(auth()->user()->wallet_balance ?? 0, 2) }}
                                </div>
                            </div>
                            <a href="#request-payout" class="btn text-white bg-green-500 hover:bg-green-600">
                                {{ __('Request Payout') }}
                            </a>
                        </div>
                    </div>

                    <!-- Request New Payout -->
                    <div id="request-payout" class="bg-slate-800/50 rounded-2xl p-6 lg:p-8 border border-slate-700/50" data-aos="fade-up" data-aos-delay="100">
                        <h2 class="text-xl font-bold text-slate-100 mb-6">{{ __('Request New Payout') }}</h2>
                        
                        <form action="{{ route('seller.payouts.store') }}" method="POST">
                            @csrf
                            <div class="space-y-6">
                                <div>
                                    <label class="block text-sm text-slate-300 font-medium mb-2">{{ __('Amount') }}</label>
                                    <div class="relative">
                                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">$</span>
                                        <input type="number" name="amount" step="0.01" min="10" max="{{ auth()->user()->wallet_balance ?? 0 }}" 
                                               class="form-input w-full pl-8" placeholder="0.00" required>
                                    </div>
                                    <p class="text-xs text-slate-500 mt-1">{{ __('Minimum: $10.00') }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm text-slate-300 font-medium mb-2">{{ __('Payment Method') }}</label>
                                    <select name="payment_method" class="form-select w-full" required>
                                        <option value="">{{ __('Select method') }}</option>
                                        <option value="bank_transfer">{{ __('Bank Transfer') }}</option>
                                        <option value="paypal">{{ __('PayPal') }}</option>
                                        <option value="wise">{{ __('Wise') }}</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm text-slate-300 font-medium mb-2">{{ __('Notes (Optional)') }}</label>
                                    <textarea name="notes" rows="3" class="form-textarea w-full" placeholder="{{ __('Add any notes or special instructions...') }}"></textarea>
                                </div>

                                <button type="submit" class="btn text-white bg-purple-500 hover:bg-purple-600">
                                    {{ __('Submit Request') }}
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Payout History -->
                    <div class="bg-slate-800/50 rounded-2xl p-6 lg:p-8 border border-slate-700/50" data-aos="fade-up" data-aos-delay="200">
                        <h2 class="text-xl font-bold text-slate-100 mb-6">{{ __('Payout History') }}</h2>
                        
                        @if(isset($payouts) && $payouts->count() > 0)
                            <div class="space-y-4">
                                @foreach($payouts as $payout)
                                    <div class="p-4 bg-slate-700/30 rounded-xl">
                                        <div class="flex items-center justify-between mb-2">
                                            <div class="text-slate-100 font-medium">{{ __('Payout Request #:id', ['id' => $payout->id]) }}</div>
                                            <span class="text-xs px-2 py-1 rounded-full {{ 
                                                $payout->status === 'completed' ? 'bg-green-500/20 text-green-400' : 
                                                ($payout->status === 'pending' ? 'bg-yellow-500/20 text-yellow-400' : 
                                                'bg-red-500/20 text-red-400') 
                                            }}">
                                                {{ ucfirst($payout->status) }}
                                            </span>
                                        </div>
                                        <div class="flex items-center justify-between text-sm">
                                            <span class="text-slate-400">{{ $payout->created_at->format('M d, Y') }}</span>
                                            <span class="text-white font-bold">${{ number_format($payout->amount, 2) }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            @if($payouts->hasPages())
                                <div class="mt-6">
                                    {{ $payouts->links() }}
                                </div>
                            @endif
                        @else
                            <div class="text-center py-12">
                                <div class="w-16 h-16 bg-slate-700 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                </div>
                                <p class="text-slate-400">{{ __('No payout requests yet') }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
