@extends('layouts.app')

@section('title', 'Pricing - Choose Your Plan')

@section('content')
<div class="min-h-screen bg-gray-900 py-12 px-4 sm:px-6 lg:px-8" x-data="{ interval: 'monthly' }">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-white mb-4">Choose Your Plan</h1>
            <p class="text-lg text-gray-400">Unlock more features and grow your business</p>
        </div>

        <!-- Monthly/Annual Toggle -->
        <div class="flex justify-center mb-12">
            <div class="bg-gray-800 p-1 rounded-lg inline-flex">
                <button @click="interval = 'monthly'" 
                        :class="interval === 'monthly' ? 'bg-blue-600 text-white' : 'text-gray-400'"
                        class="px-6 py-2 rounded-md font-medium transition-colors">
                    Monthly
                </button>
                <button @click="interval = 'yearly'" 
                        :class="interval === 'yearly' ? 'bg-blue-600 text-white' : 'text-gray-400'"
                        class="px-6 py-2 rounded-md font-medium transition-colors">
                    Annual <span class="text-green-400 text-sm ml-1">(Save up to 17%)</span>
                </button>
            </div>
        </div>

        <!-- Pricing Cards -->
        <div class="grid md:grid-cols-3 gap-8 mb-12">
            @foreach($plans as $plan)
            <div class="bg-gray-800 rounded-lg p-8 {{ $plan->slug === 'plus' ? 'ring-2 ring-blue-500 transform scale-105' : '' }}">
                <!-- Plan Name -->
                <div class="mb-6">
                    <h3 class="text-2xl font-bold text-white mb-2">{{ $plan->name }}</h3>
                    @if($plan->slug === 'plus')
                    <span class="inline-block bg-blue-600 text-white text-xs px-2 py-1 rounded">POPULAR</span>
                    @endif
                </div>

                <!-- Price -->
                <div class="mb-8">
                    <div x-show="interval === 'monthly'">
                        <span class="text-4xl font-bold text-white">${{ number_format($plan->price_month, 2) }}</span>
                        <span class="text-gray-400">/month</span>
                    </div>
                    <div x-show="interval === 'yearly'" x-cloak>
                        <span class="text-4xl font-bold text-white">${{ number_format($plan->price_year / 12, 2) }}</span>
                        <span class="text-gray-400">/month</span>
                        <div class="text-sm text-gray-400 mt-1">
                            Billed annually ({{ number_format($plan->price_year, 2) }})
                        </div>
                    </div>
                </div>

                <!-- CTA Button -->
                <div class="mb-8">
                    @if(config('app.debug'))
                        <div class="text-xs text-gray-400 mb-2">
                            Debug: Current Plan: {{ $currentPlan ? $currentPlan->name . ' ($' . $currentPlan->price_month . ')' : 'None' }} | 
                            New Plan: {{ $plan->name }} (${{ $plan->price_month }})
                        </div>
                    @endif
                    @if($currentPlan && $currentPlan->id === $plan->id)
                        <button disabled class="w-full bg-gray-700 text-gray-400 py-3 rounded-lg font-medium cursor-not-allowed">
                            Current Plan
                        </button>
                    @elseif($plan->isFree() && !auth()->check())
                        <a href="{{ route('register') }}" class="block w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-medium text-center transition-colors">
                            Get Started
                        </a>
                    @elseif($plan->isFree())
                        <form action="{{ route('subscription.subscribe', [$plan, 'monthly']) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-medium transition-colors">
                                Downgrade to Free
                            </button>
                        </form>
                    @elseif(!auth()->check())
                        <a href="{{ route('login') }}" class="block w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-medium text-center transition-colors">
                            Subscribe
                        </a>
                    @elseif($currentPlan && $currentPlan->price_month < $plan->price_month)
                        <form action="{{ route('subscription.change', [$plan, ':interval']) }}" method="POST" 
                              x-bind:action="'{{ route('subscription.change', [$plan, '']) }}/' + interval">
                            @csrf
                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-medium transition-colors">
                                Upgrade
                            </button>
                        </form>
                    @elseif($currentPlan && $currentPlan->price_month > $plan->price_month)
                        <form action="{{ route('subscription.change', [$plan, ':interval']) }}" method="POST"
                              x-bind:action="'{{ route('subscription.change', [$plan, '']) }}/' + interval">
                            @csrf
                            <button type="submit" class="w-full bg-gray-600 hover:bg-gray-700 text-white py-3 rounded-lg font-medium transition-colors">
                                Downgrade (at period end)
                            </button>
                        </form>
                    @else
                        <form action="{{ route('subscription.subscribe', [$plan, ':interval']) }}" method="POST"
                              x-bind:action="'{{ route('subscription.subscribe', [$plan, '']) }}/' + interval">
                            @csrf
                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-medium transition-colors">
                                Subscribe
                            </button>
                        </form>
                    @endif
                </div>

                <!-- Features List -->
                <div class="space-y-4">
                    @foreach($plan->features as $feature)
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-gray-300 text-sm">
                            {{ $feature->label }}
                            @if($feature->is_new)
                            <span class="inline-block bg-green-600 text-white text-xs px-2 py-0.5 rounded ml-2">NEW</span>
                            @endif
                        </span>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>

        <!-- FAQ Section -->
        <div class="max-w-3xl mx-auto bg-gray-800 rounded-lg p-8">
            <h2 class="text-2xl font-bold text-white mb-6">Frequently Asked Questions</h2>
            <div class="space-y-6">
                <div>
                    <h3 class="text-lg font-medium text-white mb-2">Can I cancel anytime?</h3>
                    <p class="text-gray-400">Yes, you can cancel your subscription at any time. Your plan will remain active until the end of your billing period.</p>
                </div>
                <div>
                    <h3 class="text-lg font-medium text-white mb-2">What happens when I upgrade?</h3>
                    <p class="text-gray-400">When you upgrade, you'll be charged a prorated amount immediately and get instant access to your new plan features.</p>
                </div>
                <div>
                    <h3 class="text-lg font-medium text-white mb-2">What happens when I downgrade?</h3>
                    <p class="text-gray-400">Downgrades take effect at the end of your current billing period. You'll keep your current features until then.</p>
                </div>
                <div>
                    <h3 class="text-lg font-medium text-white mb-2">Do you offer refunds?</h3>
                    <p class="text-gray-400">We offer a 30-day money-back guarantee on all paid plans. Contact support for refund requests.</p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<style>
    [x-cloak] { display: none !important; }
</style>
@endpush
@endsection

