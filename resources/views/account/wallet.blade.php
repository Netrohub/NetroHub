<x-layouts.app>
    <x-slot name="title">{{ __('Wallet') }} - {{ config('app.name') }}</x-slot>

    <section class="relative pt-32 pb-12 md:pb-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            
            <h1 class="h2 bg-clip-text text-transparent bg-gradient-to-r from-slate-200/60 via-slate-200 to-slate-200/60 mb-8">
                {{ __('Wallet') }}
            </h1>

            <div class="lg:flex lg:gap-8">
                
                <!-- Sidebar -->
                <x-account-sidebar />

                <!-- Main Content -->
                <div class="flex-1 min-w-0 space-y-8">
                    
                    <!-- Wallet Balance Card -->
                    <div class="bg-gradient-to-br from-purple-500/20 to-purple-600/10 rounded-2xl p-8 border border-purple-500/30" data-aos="fade-up">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <div class="text-sm text-purple-300 mb-2">{{ __('Available Balance') }}</div>
                                <div class="text-5xl font-bold text-white mb-2">
                                    ${{ number_format(auth()->user()->wallet_balance ?? 0, 2) }}
                                </div>
                                <div class="text-sm text-slate-400">{{ __('Last updated: :date', ['date' => now()->format('M d, Y')]) }}</div>
                            </div>
                            <div class="w-20 h-20 bg-purple-500/20 rounded-2xl flex items-center justify-center">
                                <svg class="w-10 h-10 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                </svg>
                            </div>
                        </div>
                        
                        <div class="flex gap-4">
                            <a href="{{ route('account.payouts') }}" class="btn text-white bg-purple-500 hover:bg-purple-600 flex-1">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                {{ __('Request Payout') }}
                            </a>
                        </div>
                    </div>

                    <!-- Transaction History -->
                    <div class="bg-slate-800/50 rounded-2xl p-6 lg:p-8 border border-slate-700/50" data-aos="fade-up" data-aos-delay="100">
                        <h2 class="text-xl font-bold text-slate-100 mb-6">{{ __('Transaction History') }}</h2>
                        
                        @if(isset($transactions) && $transactions->count() > 0)
                            <div class="space-y-3">
                                @foreach($transactions as $transaction)
                                    <div class="flex items-center justify-between p-4 bg-slate-700/30 rounded-xl">
                                        <div class="flex items-center gap-4">
                                            <div class="w-10 h-10 rounded-lg flex items-center justify-center {{ $transaction->type === 'credit' ? 'bg-green-500/20' : 'bg-red-500/20' }}">
                                                <svg class="w-5 h-5 {{ $transaction->type === 'credit' ? 'text-green-400' : 'text-red-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    @if($transaction->type === 'credit')
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                                    @else
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                                    @endif
                                                </svg>
                                            </div>
                                            <div>
                                                <div class="text-slate-100 font-medium">{{ $transaction->description }}</div>
                                                <div class="text-sm text-slate-400">{{ $transaction->created_at->format('M d, Y h:i A') }}</div>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <div class="font-bold {{ $transaction->type === 'credit' ? 'text-green-400' : 'text-red-400' }}">
                                                {{ $transaction->type === 'credit' ? '+' : '-' }}${{ number_format($transaction->amount, 2) }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Pagination -->
                            @if($transactions->hasPages())
                                <div class="mt-6">
                                    {{ $transactions->links() }}
                                </div>
                            @endif
                        @else
                            <div class="text-center py-12">
                                <div class="w-16 h-16 bg-slate-700 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                </div>
                                <p class="text-slate-400">{{ __('No transactions yet') }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
