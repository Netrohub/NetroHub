<x-layouts.stellar>
    <x-slot name="title">{{ __('Billing & Subscription') }} - {{ config('app.name') }}</x-slot>

<section class="relative pt-32 pb-12">
<div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold text-white mb-8">Billing & Subscription</h1>
        
        @if(session('success'))
        <div class="bg-green-600 text-white px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
        @endif
        
        @if(session('error'))
        <div class="bg-red-600 text-white px-4 py-3 rounded mb-6">
            {{ session('error') }}
        </div>
        @endif
        
        <!-- Current Plan Card -->
        <div class="bg-gray-800 rounded-lg p-6 mb-6">
            <h2 class="text-xl font-bold text-white mb-4">Current Plan</h2>
            @if($subscription && $plan)
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <p class="text-2xl font-bold text-blue-500">{{ $plan->name }}</p>
                        <p class="text-gray-400">
                            @if($plan->isFree())
                                Free Plan
                            @else
                                ${{ $subscription->interval === 'yearly' ? number_format($plan->price_year/12, 2) : number_format($plan->price_month, 2) }}/month
                                @if($subscription->interval === 'yearly')
                                    <span class="text-sm">(Billed annually at ${{ number_format($plan->price_year, 2) }})</span>
                                @endif
                            @endif
                        </p>
                        @if($subscription->renews_at)
                            <p class="text-sm text-gray-400 mt-2">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                {{ __('Renews on') }} {{ $subscription->renews_at->format('F j, Y') }}
                            </p>
                        @endif
                        @if($subscription->cancel_at)
                            <p class="text-sm text-yellow-500 mt-2 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                Cancels on {{ $subscription->cancel_at->format('F j, Y') }}
                            </p>
                        @endif
                    </div>
                    <div class="flex flex-col sm:flex-row gap-2">
                        <a href="{{ route('pricing.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-center transition-colors">
                            {{ __('Change Plan') }}
                        </a>
                        @if(!$plan->isFree() && !$subscription->isCancelled())
                            <form action="{{ route('subscription.cancel') }}" method="POST" class="inline">
                                @csrf
                                <button onclick="return confirm('{{ __('Are you sure you want to cancel? Your plan will remain active until the end of the billing period.') }}')" 
                                        class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded transition-colors">
                                    {{ __('Cancel Auto-Renew') }}
                                </button>
                            </form>
                        @elseif($subscription->isCancelled())
                            <form action="{{ route('subscription.resume') }}" method="POST" class="inline">
                                @csrf
                                <button class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded transition-colors">
                                    {{ __('Resume Subscription') }}
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @else
                <p class="text-gray-400 mb-4">{{ __('No active subscription') }}</p>
                <a href="{{ route('pricing.index') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded transition-colors">
                    {{ __('View Plans') }}
                </a>
            @endif
        </div>
        
        <!-- Your Entitlements -->
        <div class="bg-gray-800 rounded-lg p-6">
            <h2 class="text-xl font-bold text-white mb-4">Your Benefits & Limits</h2>
            <div class="grid md:grid-cols-2 gap-4">
                @forelse($entitlements as $ent)
                    <div class="bg-gray-700 rounded p-4">
                        <p class="text-gray-300 text-sm mb-1">{{ ucwords(str_replace('_', ' ', $ent->key)) }}</p>
                        <p class="text-2xl font-bold text-white">
                            {{ is_bool($ent->getValue()) ? ($ent->getValue() ? 'Yes' : 'No') : $ent->getValue() }}
                            @if(str_contains($ent->key, '_pct'))
                                %
                            @endif
                        </p>
                        @if($ent->reset_period === 'monthly' && $ent->period_end)
                            <p class="text-xs text-gray-400 mt-1">
                                <svg class="w-3 h-3 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                Resets {{ $ent->period_end->diffForHumans() }}
                            </p>
                        @endif
                    </div>
                @empty
                    <p class="text-gray-400 col-span-2">No entitlements found</p>
                @endforelse
            </div>
        </div>
        
        <!-- Need Help -->
        <div class="bg-gray-800 rounded-lg p-6 mt-6">
            <h2 class="text-xl font-bold text-white mb-2">{{ __('Need Help?') }}</h2>
            <p class="text-gray-400 mb-4">{{ __('Have questions about your subscription or billing?') }}</p>
            <a href="{{ route('account.index') }}" class="text-blue-400 hover:text-blue-300">
                {{ __('Contact Support') }} →
            </a>
        </div>
    </div>
</div>
</section>

</x-layouts.stellar>

