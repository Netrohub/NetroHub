<x-layouts.app>
    <x-slot name="title">{{ __('Billing') }} - {{ config('app.name') }}</x-slot>

<section class="relative pt-32 pb-12">
<div class="min-h-screen relative overflow-hidden bg-dark-900 py-10">
    <!-- Gaming Background Effects -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-primary-500/5 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-1/4 right-1/4 w-80 h-80 bg-secondary-500/5 rounded-full blur-3xl animate-float animation-delay-2000"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8 scroll-fade-in">
            <div class="flex items-center gap-3 mb-2">
                <a href="{{ route('account.index') }}" class="text-muted-400 hover:text-white transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <x-ui.breadcrumb :items="[
                    ['label' => 'Account', 'url' => route('account.index')],
                    ['label' => __('Billing & Subscription'), 'url' => '']
                ]" />
            </div>
            <h1 class="text-4xl font-black text-white mb-2 text-gradient">{{ __('Billing & Subscription') }}</h1>
            <p class="text-muted-300">{{ __('Manage your subscription and monitor usage limits') }}</p>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="alert-success mb-6 scroll-fade-in">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="alert-error mb-6 scroll-fade-in">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column - Current Plan & Usage -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Current Plan Card -->
                @if($subscription)
                <x-ui.card variant="gradient" class="scroll-fade-in border-primary-500/30">
                    <div class="flex items-start justify-between mb-6">
                        <div class="flex items-center gap-4">
                            <div class="p-4 bg-gaming-gradient rounded-2xl shadow-gaming">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-primary-400 font-medium">Current Plan</p>
                                <div class="flex items-center gap-3">
                                    <h2 class="text-3xl font-black text-white">{{ $subscription->plan->name }}</h2>
                                    @if($subscription->plan->slug === 'plus')
                                        <span class="badge-primary animate-pulse">PLUS</span>
                                    @elseif($subscription->plan->slug === 'pro')
                                        <span class="badge-success animate-pulse">PRO</span>
                                    @endif
                                </div>
                                <p class="text-muted-400 mt-1">
                                    @if($subscription->plan->isFree())
                                        {{ __('Free Plan') }}
                                    @else
                                        ${{ number_format($subscription->plan->getPrice($subscription->interval), 2) }} /
                                        {{ $subscription->interval === 'yearly' ? 'year' : 'month' }}
                                    @endif
                                </p>
                                @if($subscription->renews_at && !$subscription->isCancelled())
                                    <p class="text-sm text-muted-400 mt-2">
                                        {{ __('Renews on') }} {{ $subscription->renews_at->format('F d, Y') }}
                                    </p>
                                @elseif($subscription->cancel_at)
                                    <p class="text-sm text-yellow-400 mt-2 flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ __('Expires on') }} {{ $subscription->cancel_at->format('F d, Y') }}
                                    </p>
                                @endif
                            </div>
                        </div>

                        <span class="badge-{{ $subscription->status === 'active' ? 'success' : ($subscription->status === 'past_due' ? 'warning' : 'danger') }}">
                            {{ ucfirst($subscription->status) }}
                        </span>
                    </div>

                    <!-- Actions -->
                    <div class="flex flex-wrap gap-3">
                        @if(!$subscription->plan->isFree())
                            <a href="{{ route('pricing') }}" class="btn-secondary">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                                </svg>
                                {{ __('Change Plan') }}
                            </a>

                            @if(!$subscription->isCancelled())
                                <form action="{{ route('subscription.cancel-auto-renew') }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="btn-danger" onclick="return confirm('{{ __('Cancel auto-renewal? Your plan will expire at the end of the current period.') }}')">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                        {{ __('Cancel Auto-Renew') }}
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('subscription.resume') }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="btn-success">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                        </svg>
                                        {{ __('Resume Subscription') }}
                                    </button>
                                </form>
                            @endif
                        @else
                            <a href="{{ route('pricing') }}" class="btn-primary">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                                {{ __('Upgrade Now') }}
                            </a>
                        @endif
                    </div>
                </x-ui.card>
                @endif

                <!-- Usage Limits Card -->
                <x-ui.card variant="glass" class="scroll-fade-in animation-delay-100">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="p-3 bg-secondary-500/10 rounded-xl">
                            <svg class="w-6 h-6 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-white">{{ __('Usage & Limits') }}</h3>
                            <p class="text-sm text-muted-400">{{ __('Monitor your plan usage') }}</p>
                        </div>
                    </div>

                    <div class="space-y-6">
                        {{-- Boost Slots --}}
                        @if(isset($entitlements['boost_slots_remaining']))
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-sm font-semibold text-white">🚀 Boost Slots</span>
                                    <span class="text-sm text-muted-400">
                                        <span class="text-primary-400 font-bold">{{ $entitlements['boost_slots_remaining'] }}</span> remaining
                                    </span>
                                </div>
                                <x-ui.progress 
                                    :value="$entitlements['boost_slots_remaining']" 
                                    :max="$entitlements['boost_slots_total'] ?? 10" 
                                />
                            </div>
                        @endif

                        {{-- Draft Listings --}}
                        @if(isset($entitlements['draft_limit']))
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-sm font-semibold text-white">📝 Draft Listings</span>
                                    <span class="text-sm text-muted-400">
                                        <span class="text-secondary-400 font-bold">{{ $draftCount ?? 0 }}</span> / {{ $entitlements['draft_limit'] }} used
                                    </span>
                                </div>
                                <x-ui.progress 
                                    :value="$draftCount ?? 0" 
                                    :max="$entitlements['draft_limit']" 
                                />
                            </div>
                        @endif

                        {{-- Platform Fee --}}
                        @if(isset($entitlements['platform_fee_pct']))
                            <div class="p-4 bg-dark-900/50 rounded-xl border border-gaming/30">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-neon-green/10 rounded-lg flex items-center justify-center">
                                            <svg class="w-5 h-5 text-neon-green" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm text-muted-400">Platform Fee</p>
                                            <p class="text-2xl font-black text-white">{{ $entitlements['platform_fee_pct'] }}%</p>
                                        </div>
                                    </div>
                                    @if($entitlements['platform_fee_pct'] < 10)
                                        <span class="badge-success">DISCOUNTED</span>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- Upgrade Prompt if nearing limits --}}
                    @if($subscription && $subscription->plan->isFree())
                        <div class="mt-6 p-4 bg-primary-500/10 border border-primary-500/30 rounded-xl">
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-primary-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/>
                                </svg>
                                <div class="flex-1">
                                    <p class="text-sm font-semibold text-primary-300 mb-1">{{ __('Unlock More Features') }}</p>
                                    <p class="text-sm text-muted-300">{{ __('Upgrade to Plus or Pro for more boost slots, lower fees, and priority support!') }}</p>
                                    <a href="{{ route('pricing') }}" class="inline-flex items-center gap-2 text-sm text-primary-400 hover:text-primary-300 font-semibold mt-2">
                                        {{ __('View Plans') }} →
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                </x-ui.card>

                <!-- Plan Features -->
                <x-ui.card variant="glass" class="scroll-fade-in animation-delay-200">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="p-3 bg-neon-blue/10 rounded-xl">
                            <svg class="w-6 h-6 text-neon-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-white">Your Features</h3>
                            <p class="text-sm text-muted-400">What's included in your plan</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @if(isset($entitlements['priority_support']) && $entitlements['priority_support'])
                            <div class="flex items-center gap-3 p-3 bg-dark-900/50 rounded-xl">
                                <svg class="w-5 h-5 text-neon-green" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-sm text-white">Priority Support</span>
                            </div>
                        @endif

                        @if(isset($entitlements['featured_placement']) && $entitlements['featured_placement'])
                            <div class="flex items-center gap-3 p-3 bg-dark-900/50 rounded-xl">
                                <svg class="w-5 h-5 text-neon-green" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-sm text-white">Featured Placement</span>
                            </div>
                        @endif

                        <div class="flex items-center gap-3 p-3 bg-dark-900/50 rounded-xl">
                            <svg class="w-5 h-5 text-primary-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-sm text-white">{{ $entitlements['platform_fee_pct'] ?? 10 }}% Platform Fee</span>
                        </div>

                        @if(isset($entitlements['payout_fee_discount_pct']) && $entitlements['payout_fee_discount_pct'] > 0)
                            <div class="flex items-center gap-3 p-3 bg-dark-900/50 rounded-xl">
                                <svg class="w-5 h-5 text-neon-green" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-sm text-white">{{ $entitlements['payout_fee_discount_pct'] }}% Payout Discount</span>
                            </div>
                        @endif
                    </div>
                </x-ui.card>
            </div>

            <!-- Right Column - Quick Stats & Actions -->
            <div class="space-y-6">
                <!-- Quick Stats -->
                <x-ui.card variant="glass" class="scroll-fade-in animation-delay-300">
                    <h3 class="text-lg font-bold text-white mb-4">Quick Stats</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-muted-400">Total Spent</span>
                            <span class="text-lg font-bold text-white">${{ number_format($totalSpent ?? 0, 2) }}</span>
                        </div>
                        <x-ui.divider />
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-muted-400">Member Since</span>
                            <span class="text-sm font-semibold text-white">{{ auth()->user()->created_at->format('M Y') }}</span>
                        </div>
                        <x-ui.divider />
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-muted-400">Subscription Type</span>
                            <span class="badge-{{ $subscription && $subscription->interval === 'yearly' ? 'success' : 'info' }}">
                                {{ $subscription ? ucfirst($subscription->interval) : 'None' }}
                            </span>
                        </div>
                    </div>
                </x-ui.card>

                <!-- Upgrade CTA -->
                @if($subscription && !$subscription->plan->slug === 'pro')
                    <x-ui.card variant="gradient" class="border-secondary-500/30 scroll-fade-in animation-delay-500">
                        <div class="text-center">
                            <div class="w-16 h-16 bg-gaming-gradient rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-gaming">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                                </svg>
                            </div>
                            <h4 class="text-lg font-bold text-white mb-2">{{ __('Unlock Pro Features') }}</h4>
                            <p class="text-sm text-muted-300 mb-4">{{ __('Get the most out of NXO with our Pro plan') }}</p>
                            <a href="{{ route('pricing') }}" class="btn-primary w-full">
                                {{ __('View Plans') }}
                            </a>
                        </div>
                    </x-ui.card>
                @endif
            </div>
        </div>
    </div>
</div>
</section>

</x-layouts.app>


