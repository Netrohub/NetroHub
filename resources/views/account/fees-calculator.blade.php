@extends('layouts.app')

@section('content')
<div class="min-h-screen relative overflow-hidden bg-dark-900 py-10">
    <!-- Gaming Background Effects -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-primary-500/5 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-1/4 right-1/4 w-80 h-80 bg-secondary-500/5 rounded-full blur-3xl animate-float animation-delay-2000"></div>
    </div>

    <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center gap-3 mb-2">
                <a href="{{ route('account.index') }}" class="text-muted-400 hover:text-white transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <h1 class="text-4xl font-black text-white bg-gaming-gradient bg-clip-text text-transparent">Fees Calculator</h1>
            </div>
            <p class="text-muted-300">Calculate your earnings after platform fees</p>
        </div>

        <!-- Calculator -->
        <x-ui.card variant="glass">
            <div class="max-w-2xl mx-auto">
                <!-- Sale Amount Input -->
                <div class="mb-8">
                    <label class="block text-sm font-medium text-muted-300 mb-3">Sale Amount</label>
                    <div class="relative">
                        <span class="absolute left-6 top-1/2 -translate-y-1/2 text-white font-bold text-2xl">$</span>
                        <input 
                            type="number" 
                            id="saleAmount" 
                            min="0" 
                            step="0.01" 
                            value="100"
                            class="w-full pl-12 pr-6 py-4 bg-dark-700/50 border-2 border-gaming rounded-2xl text-white text-2xl font-bold focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                            placeholder="0.00"
                        >
                    </div>
                    <p class="text-xs text-muted-400 mt-2">Enter the price you want to sell your product for</p>
                </div>

                <!-- Your Plan Info -->
                @php
                    $userPlan = auth()->user()->getPlanName();
                    $platformFee = match($userPlan) {
                        'Pro' => 5,
                        'Plus' => 7.5,
                        default => 10,
                    };
                @endphp

                <div class="mb-8 p-4 bg-dark-700/30 rounded-xl border border-gaming">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-muted-400">Your Current Plan</p>
                            <p class="text-lg font-bold text-white">{{ $userPlan }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-muted-400">Platform Fee</p>
                            <p class="text-lg font-bold text-white" id="currentFee">{{ $platformFee }}%</p>
                        </div>
                    </div>
                </div>

                <!-- Fee Breakdown -->
                <div class="space-y-4 mb-8">
                    <div class="flex items-center justify-between py-3 border-b border-gaming">
                        <span class="text-muted-300">Sale Amount</span>
                        <span class="text-white font-semibold" id="displaySaleAmount">$100.00</span>
                    </div>

                    <div class="flex items-center justify-between py-3 border-b border-gaming">
                        <div class="flex items-center gap-2">
                            <span class="text-muted-300">Platform Fee ({{ $platformFee }}%)</span>
                            <div class="group relative">
                                <svg class="w-4 h-4 text-muted-500 cursor-help" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
                                </svg>
                                <div class="hidden group-hover:block absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-64 p-3 bg-dark-800 border border-gaming rounded-xl text-xs text-muted-300 z-10">
                                    NetroHub charges a platform fee to cover hosting, support, and payment processing
                                </div>
                            </div>
                        </div>
                        <span class="text-red-400 font-semibold" id="platformFeeAmount">-$10.00</span>
                    </div>

                    <div class="flex items-center justify-between py-4 bg-green-500/10 rounded-xl px-4">
                        <span class="text-green-400 font-bold">You Receive</span>
                        <span class="text-green-400 font-black text-2xl" id="youReceive">$90.00</span>
                    </div>
                </div>

                <!-- Comparison Table -->
                <div class="mt-8">
                    <h3 class="text-xl font-bold text-white mb-4">Compare Plans</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="text-left text-muted-400 border-b border-gaming">
                                <tr>
                                    <th class="px-4 py-3">Plan</th>
                                    <th class="px-4 py-3">Platform Fee</th>
                                    <th class="px-4 py-3 text-right">You Get</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gaming">
                                <tr class="{{ $userPlan === 'Free' ? 'bg-primary-500/10' : '' }}">
                                    <td class="px-4 py-3">
                                        <span class="font-semibold text-white">Free</span>
                                        @if($userPlan === 'Free')
                                            <span class="ml-2 text-xs text-primary-400">(Current)</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-white">10%</td>
                                    <td class="px-4 py-3 text-right text-white font-semibold" id="freePlanAmount">$90.00</td>
                                </tr>
                                <tr class="{{ $userPlan === 'Plus' ? 'bg-primary-500/10' : '' }}">
                                    <td class="px-4 py-3">
                                        <span class="font-semibold text-white">Plus</span>
                                        @if($userPlan === 'Plus')
                                            <span class="ml-2 text-xs text-primary-400">(Current)</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-white">7.5%</td>
                                    <td class="px-4 py-3 text-right text-white font-semibold" id="plusPlanAmount">$92.50</td>
                                </tr>
                                <tr class="{{ $userPlan === 'Pro' ? 'bg-primary-500/10' : '' }}">
                                    <td class="px-4 py-3">
                                        <span class="font-semibold text-white">Pro</span>
                                        @if($userPlan === 'Pro')
                                            <span class="ml-2 text-xs text-primary-400">(Current)</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-white">5%</td>
                                    <td class="px-4 py-3 text-right text-white font-semibold" id="proPlanAmount">$95.00</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    @if($userPlan !== 'Pro')
                        <div class="mt-6 p-4 bg-gradient-to-r from-primary-500/10 to-secondary-500/10 rounded-xl border border-primary-500/30">
                            <p class="text-sm text-muted-300 mb-3">
                                Upgrade to {{ $userPlan === 'Free' ? 'Plus or Pro' : 'Pro' }} to save on fees and keep more of your earnings!
                            </p>
                            <a href="{{ route('pricing.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gaming-gradient text-white rounded-xl hover:shadow-gaming-lg transition font-semibold text-sm">
                                View Plans
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </x-ui.card>

        <!-- Info Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
            <x-ui.card variant="glass" :hover="false">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 bg-blue-500/20 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-white mb-1">No Hidden Fees</h4>
                        <p class="text-sm text-muted-400">What you see is what you get. No surprise deductions.</p>
                    </div>
                </div>
            </x-ui.card>

            <x-ui.card variant="glass" :hover="false">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 bg-green-500/20 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-white mb-1">Instant Payouts</h4>
                        <p class="text-sm text-muted-400">Withdraw your earnings anytime, minimum $50.</p>
                    </div>
                </div>
            </x-ui.card>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const saleAmountInput = document.getElementById('saleAmount');
    const displaySaleAmount = document.getElementById('displaySaleAmount');
    const platformFeeAmount = document.getElementById('platformFeeAmount');
    const youReceive = document.getElementById('youReceive');
    const freePlanAmount = document.getElementById('freePlanAmount');
    const plusPlanAmount = document.getElementById('plusPlanAmount');
    const proPlanAmount = document.getElementById('proPlanAmount');

    const currentPlan = '{{ $userPlan }}';
    const platformFeePercent = parseFloat('{{ $platformFee }}');

    function calculateFees() {
        const amount = parseFloat(saleAmountInput.value) || 0;
        
        // Current plan calculation
        const platformFee = amount * (platformFeePercent / 100);
        const netAmount = amount - platformFee;

        // Display current plan
        displaySaleAmount.textContent = '$' + amount.toFixed(2);
        platformFeeAmount.textContent = '-$' + platformFee.toFixed(2);
        youReceive.textContent = '$' + netAmount.toFixed(2);

        // Comparison table
        freePlanAmount.textContent = '$' + (amount * 0.90).toFixed(2);
        plusPlanAmount.textContent = '$' + (amount * 0.925).toFixed(2);
        proPlanAmount.textContent = '$' + (amount * 0.95).toFixed(2);
    }

    saleAmountInput.addEventListener('input', calculateFees);
    
    // Initial calculation
    calculateFees();
});
</script>
@endsection

