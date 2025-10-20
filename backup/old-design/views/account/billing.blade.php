<x-layouts.stellar>
    <x-slot name="title">{{ __('Billing & Subscription') }} - {{ config('app.name') }}</x-slot>

<section class="relative pt-32 pb-12">
<div class="min-h-screen py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Billing & Subscription</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-2">{{ __('Manage your subscription and billing settings') }}</p>
        </div>

        @if(session('success'))
        <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-400 px-4 py-3 rounded-lg mb-6">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-400 px-4 py-3 rounded-lg mb-6">
            {{ session('error') }}
        </div>
        @endif

        <div class="grid md:grid-cols-3 gap-8">
            <!-- Current Plan -->
            <div class="md:col-span-2 space-y-6">
                <!-- Plan Card -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Current Plan</h2>
                    
                    @if($subscription)
                    <div class="flex items-start justify-between">
                        <div>
                            <div class="flex items-center gap-3">
                                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $subscription->plan->name }}</h3>
                                @if($subscription->plan->slug === 'plus')
                                <span class="inline-flex items-center px-2 py-1 text-xs font-medium text-blue-400 bg-blue-900/30 rounded">PLUS</span>
                                @elseif($subscription->plan->slug === 'pro')
                                <span class="inline-flex items-center px-2 py-1 text-xs font-medium text-purple-400 bg-purple-900/30 rounded">PRO</span>
                                @endif
                            </div>
                            
                            <p class="text-gray-600 dark:text-gray-400 mt-2">
                                ${{ number_format($subscription->plan->getPrice($subscription->interval), 2) }} /
                                {{ $subscription->interval === 'yearly' ? 'year' : 'month' }}
                            </p>

                            @if($subscription->renews_at && !$subscription->isCancelled())
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                                {{ __('Renews on') }} {{ $subscription->renews_at->format('F d, Y') }}
                            </p>
                            @elseif($subscription->cancel_at)
                            <p class="text-sm text-yellow-600 dark:text-yellow-400 mt-2">
                                ⚠️ {{ __('Expires on') }} {{ $subscription->cancel_at->format('F d, Y') }}
                            </p>
                            @endif
                        </div>

                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            {{ $subscription->status === 'active' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : '' }}
                            {{ $subscription->status === 'past_due' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400' : '' }}
                            {{ $subscription->status === 'cancelled' ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' : '' }}
                        ">
                            {{ ucfirst($subscription->status) }}
                        </span>
                    </div>

                    <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700 flex gap-4">
                        @if(!$subscription->plan->isFree())
                        <a href="{{ route('pricing') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition">
                            {{ __('Change Plan') }}
                        </a>

                        @if(!$subscription->isCancelled())
                        <form action="{{ route('subscription.cancel-auto-renew') }}" method="POST">
                            @csrf
                            <button type="submit" onclick="return confirm('{{ __('Are you sure you want to cancel auto-renewal?') }}')" 
                                class="px-4 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 rounded-lg font-medium transition">
                                {{ __('Cancel Auto-Renew') }}
                            </button>
                        </form>
                        @else
                        <form action="{{ route('subscription.resume') }}" method="POST">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition">
                                {{ __('Resume Subscription') }}
                            </button>
                        </form>
                        @endif
                        @else
                        <a href="{{ route('pricing') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition">
                            {{ __('Upgrade Now') }}
                        </a>
                        @endif
                    </div>
                    @else
                    <p class="text-gray-600 dark:text-gray-400">{{ __('You don\'t have an active subscription.') }}</p>
                    <a href="{{ route('pricing') }}" class="inline-block mt-4 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition">
                        {{ __('View Plans') }}
                    </a>
                    @endif
                </div>

                <!-- Payment History -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Payment History</h2>
                    
                    @if($subscription && $subscription->paddle_subscription_id)
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                        View your complete invoice history in your 
                        <a href="https://vendors.paddle.com" target="_blank" class="text-blue-600 hover:text-blue-700 underline">Paddle account</a>
                    </p>
                    @else
                    <p class="text-gray-500 dark:text-gray-400">{{ __('No payment history available.') }}</p>
                    @endif
                </div>
            </div>

            <!-- Entitlements Sidebar -->
            <div class="space-y-6">
                <!-- Benefits Card -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Your Benefits</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-gray-600 dark:text-gray-400">Platform Fee</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ $entitlements['platform_fee_pct'] ?? 10 }}%</span>
                            </div>
                        </div>

                        @if(isset($entitlements['payout_fee_discount_pct']) && $entitlements['payout_fee_discount_pct'] > 0)
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-gray-600 dark:text-gray-400">Payout Fee Discount</span>
                                <span class="font-medium text-green-600 dark:text-green-400">-{{ $entitlements['payout_fee_discount_pct'] }}%</span>
                            </div>
                        </div>
                        @endif

                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-gray-600 dark:text-gray-400">Boost Slots</span>
                                <span class="font-medium text-gray-900 dark:text-white">
                                    {{ $entitlements['boost_slots_remaining'] ?? 0 }} / {{ $entitlements['boost_slots'] ?? 1 }}
                                </span>
                            </div>
                            @php
                                $boostSlots = $entitlements['boost_slots'] ?? 1;
                                $boostRemaining = $entitlements['boost_slots_remaining'] ?? 0;
                                $boostPercentage = $boostSlots > 0 ? ($boostRemaining / $boostSlots) * 100 : 0;
                            @endphp
                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $boostPercentage }}%"></div>
                            </div>
                        </div>

                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-gray-600 dark:text-gray-400">Draft Storage</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ $entitlements['draft_limit'] ?? 1 }} listings</span>
                            </div>
                        </div>

                        @if($entitlements['priority_support'] ?? false)
                        <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                            <div class="flex items-center text-sm text-green-600 dark:text-green-400">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                Priority Support
                            </div>
                        </div>
                        @endif

                        @if($entitlements['featured_placement'] ?? false)
                        <div>
                            <div class="flex items-center text-sm text-purple-600 dark:text-purple-400">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                Featured Placement
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-6">
                    <h4 class="font-semibold text-blue-900 dark:text-blue-400 mb-2">{{ __('Need Help?') }}</h4>
                    <p class="text-sm text-blue-800 dark:text-blue-300 mb-4">
                        {{ __('Have questions about your subscription? We\'re here to help!') }}
                    </p>
                    <a href="#" class="text-sm text-blue-600 dark:text-blue-400 hover:underline font-medium">
                        {{ __('Contact Support') }} →
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
</section>

</x-layouts.stellar>

