@extends('layouts.app')

@section('content')
<div class="min-h-screen relative overflow-hidden bg-dark-900 py-10">
    <!-- Gaming Background Effects -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-primary-500/5 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-1/4 right-1/4 w-80 h-80 bg-secondary-500/5 rounded-full blur-3xl animate-float animation-delay-2000"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center gap-3 mb-2">
                <a href="{{ route('account.index') }}" class="text-muted-400 hover:text-white transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <h1 class="text-4xl font-black text-white bg-gaming-gradient bg-clip-text text-transparent">Payouts / Cashbox</h1>
            </div>
            <p class="text-muted-300">Track and manage your payouts</p>
        </div>

        @if(!auth()->user()->seller)
            <x-ui.alert type="info" class="mb-6">
                <p class="font-semibold">{{ __('Seller Account Required') }}</p>
                <p class="text-sm mt-1">{{ __('You need to become a seller to receive payouts.') }}</p>
                <a href="{{ route('sell.index') }}" class="inline-flex items-center gap-2 mt-3 px-4 py-2 bg-primary-500 text-white rounded-xl hover:bg-primary-600 transition">
                    {{ __('Start Selling') }}
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </a>
            </x-ui.alert>
        @else
            <!-- Wallet Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <x-ui.card variant="glass" :hover="false">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-muted-400 text-sm mb-1">Available Balance</p>
                            <p class="text-3xl font-black text-white">${{ number_format(auth()->user()->seller->getWalletBalance(), 2) }}</p>
                        </div>
                        <div class="w-12 h-12 bg-green-500/20 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </x-ui.card>

                <x-ui.card variant="glass" :hover="false">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-muted-400 text-sm mb-1">Total Earned</p>
                            <p class="text-3xl font-black text-white">${{ number_format(auth()->user()->seller->walletTransactions()->whereIn('type', ['sale', 'adjustment'])->sum('amount'), 2) }}</p>
                        </div>
                        <div class="w-12 h-12 bg-primary-500/20 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                        </div>
                    </div>
                </x-ui.card>

                <x-ui.card variant="glass" :hover="false">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-muted-400 text-sm mb-1">Total Payouts</p>
                            <p class="text-3xl font-black text-white">${{ number_format(abs(auth()->user()->seller->walletTransactions()->where('type', 'payout')->sum('amount')), 2) }}</p>
                        </div>
                        <div class="w-12 h-12 bg-secondary-500/20 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                    </div>
                </x-ui.card>
            </div>

            <!-- Payout Request -->
            <x-ui.card variant="glass" class="mb-8">
                <h2 class="text-2xl font-bold text-white mb-4">Request Payout</h2>
                <p class="text-muted-300 mb-6">Minimum payout amount is $50. Payouts are processed within 3-5 business days.</p>
                
                <form action="{{ route('account.payouts') }}" method="POST" class="max-w-2xl">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-muted-300 mb-2">Payout Amount</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-white font-semibold">$</span>
                                <input type="number" name="amount" min="50" step="0.01" max="{{ auth()->user()->seller->getWalletBalance() }}" class="w-full pl-8 pr-4 py-3 bg-dark-700/50 border border-gaming rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="50.00" required>
                            </div>
                            <p class="text-xs text-muted-400 mt-1">Available: ${{ number_format(auth()->user()->seller->getWalletBalance(), 2) }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-muted-300 mb-2">Payment Method</label>
                            <select name="payment_method" class="w-full px-4 py-3 bg-dark-700/50 border border-gaming rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-primary-500" required>
                                <option value="">Select method</option>
                                <option value="paypal">PayPal</option>
                                <option value="bank_transfer">Bank Transfer</option>
                                <option value="crypto">Cryptocurrency</option>
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-muted-300 mb-2">Payment Details</label>
                            <textarea name="payment_details" rows="3" class="w-full px-4 py-3 bg-dark-700/50 border border-gaming rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="Enter your payment account details (email, wallet address, etc.)" required></textarea>
                            <p class="text-xs text-muted-400 mt-1">Enter your PayPal email, bank account details, or crypto wallet address</p>
                        </div>
                    </div>

                    <button type="submit" class="mt-6 px-6 py-3 bg-gaming-gradient text-white rounded-xl font-bold hover:shadow-gaming-lg transition-all">
                        Request Payout
                    </button>
                </form>
            </x-ui.card>

            <!-- Payout History -->
            <x-ui.card variant="glass">
                <h2 class="text-2xl font-bold text-white mb-6">Payout History</h2>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="text-left text-muted-400 border-b border-gaming">
                            <tr>
                                <th class="px-4 py-3">Date</th>
                                <th class="px-4 py-3">Amount</th>
                                <th class="px-4 py-3">Method</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3">Notes</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gaming">
                            @forelse(auth()->user()->seller->payoutRequests()->latest()->paginate(15) as $payout)
                                <tr class="hover:bg-dark-800/50">
                                    <td class="px-4 py-4 text-white">{{ $payout->created_at->format('M d, Y') }}</td>
                                    <td class="px-4 py-4 font-semibold text-white">${{ number_format($payout->amount, 2) }}</td>
                                    <td class="px-4 py-4 text-muted-300">{{ ucfirst(str_replace('_', ' ', $payout->payment_method)) }}</td>
                                    <td class="px-4 py-4">
                                        @if($payout->status === 'completed')
                                            <x-ui.badge color="green" size="sm">Completed</x-ui.badge>
                                        @elseif($payout->status === 'pending')
                                            <x-ui.badge color="yellow" size="sm">Pending</x-ui.badge>
                                        @elseif($payout->status === 'processing')
                                            <x-ui.badge color="blue" size="sm">Processing</x-ui.badge>
                                        @else
                                            <x-ui.badge color="red" size="sm">{{ ucfirst($payout->status) }}</x-ui.badge>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 text-muted-400 text-xs">{{ $payout->notes ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-10 text-center">
                                        <div class="flex flex-col items-center gap-3">
                                            <svg class="w-12 h-12 text-muted-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                            </svg>
                                            <p class="text-muted-400">No payout requests yet</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if(auth()->user()->seller->payoutRequests()->count() > 0)
                    <div class="mt-6">
                        {{ auth()->user()->seller->payoutRequests()->latest()->paginate(15)->links() }}
                    </div>
                @endif
            </x-ui.card>
        @endif
    </div>
</div>
@endsection

