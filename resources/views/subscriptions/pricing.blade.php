<x-layouts.stellar>
    <x-slot name="title">{{ __('Pricing') }} - {{ config('app.name') }}</x-slot>

<section class="relative pt-32 pb-12">
<div class="py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-white mb-4">Choose Your Plan</h1>
            <p class="text-xl text-gray-400">{{ __('Unlock powerful features and grow your business') }}</p>
        </div>

        <!-- Monthly/Annual Toggle -->
        <div class="flex justify-center items-center mb-12">
            <span class="text-gray-400 mr-3">Monthly</span>
            <label class="relative inline-block w-14 h-8 cursor-pointer">
                <input type="checkbox" id="billing-toggle" class="sr-only peer" />
                <div class="w-14 h-8 bg-gray-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-6 after:content-[''] after:absolute after:top-1 after:left-1 after:bg-white after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-blue-600"></div>
            </label>
            <span class="text-gray-400 ml-3">Annual <span class="inline-flex items-center px-2 py-1 text-xs font-medium text-green-400 bg-green-900/30 rounded ml-2">Save up to 17%</span></span>
        </div>

        <!-- Pricing Cards -->
        <div class="grid md:grid-cols-3 gap-8 max-w-7xl mx-auto">
            @foreach($plans as $plan)
            <div class="bg-gray-800 rounded-2xl p-8 {{ $plan->slug === 'plus' ? 'ring-2 ring-blue-500' : '' }} relative">
                @if($plan->slug === 'plus')
                <div class="absolute top-0 right-8 transform -translate-y-1/2">
                    <span class="inline-flex items-center px-4 py-1 text-xs font-medium text-white bg-blue-600 rounded-full">
                        POPULAR
                    </span>
                </div>
                @endif

                <!-- Plan Name -->
                <h3 class="text-2xl font-bold text-white mb-2">{{ $plan->name }}</h3>
                
                <!-- Price -->
                <div class="mb-6">
                    <div class="flex items-baseline">
                        <span class="text-5xl font-bold text-white monthly-price-{{ $plan->id }}">
                            ${{ number_format($plan->price_month, 2) }}
                        </span>
                        <span class="text-5xl font-bold text-white yearly-price-{{ $plan->id }}" style="display: none;">
                            ${{ number_format($plan->price_year / 12, 2) }}
                        </span>
                        <span class="text-gray-400 ml-2">/month</span>
                    </div>
                    @if($plan->price_year > 0)
                    <p class="text-sm text-gray-500 mt-1 yearly-billing-{{ $plan->id }}" style="display: none;">
                        Billed ${{ number_format($plan->price_year, 2) }} annually
                    </p>
                    @endif
                </div>

                <!-- CTA Button -->
                <div class="mb-8">
                    @auth
                        @if($currentPlan && $currentPlan->id === $plan->id)
                            <button disabled class="w-full py-3 px-6 rounded-lg font-semibold bg-gray-700 text-gray-400 cursor-not-allowed">
                                Current Plan
                            </button>
                        @elseif($plan->isFree())
                            <form action="{{ route('subscription.subscribe', ['plan' => $plan->slug, 'interval' => 'monthly']) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full py-3 px-6 rounded-lg font-semibold bg-gray-700 text-white hover:bg-gray-600 transition">
                                    Switch to Free
                                </button>
                            </form>
                        @else
                            <button onclick="subscribe('{{ $plan->slug }}')" class="w-full py-3 px-6 rounded-lg font-semibold {{ $plan->slug === 'plus' ? 'bg-blue-600 hover:bg-blue-700' : 'bg-gray-700 hover:bg-gray-600' }} text-white transition subscribe-btn">
                                @if($currentPlan && $currentPlan->price_month < $plan->price_month)
                                    Upgrade
                                @elseif($currentPlan && $currentPlan->price_month > $plan->price_month)
                                    Downgrade
                                @else
                                    Subscribe
                                @endif
                            </button>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="block w-full py-3 px-6 rounded-lg font-semibold text-center {{ $plan->slug === 'plus' ? 'bg-blue-600 hover:bg-blue-700' : 'bg-gray-700 hover:bg-gray-600' }} text-white transition">
                            Get Started
                        </a>
                    @endauth
                </div>

                <!-- Features List -->
                <ul class="space-y-4">
                    @foreach($plan->features as $feature)
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                        <span class="text-gray-300 text-sm">
                            {{ $feature->label }}
                            @if($feature->is_new)
                            <span class="inline-flex items-center px-2 py-0.5 text-xs font-medium text-blue-400 bg-blue-900/30 rounded ml-2">New</span>
                            @endif
                        </span>
                    </li>
                    @endforeach
                </ul>
            </div>
            @endforeach
        </div>

        <!-- FAQ Section -->
        <div class="mt-20 max-w-3xl mx-auto">
            <h2 class="text-3xl font-bold text-white text-center mb-8">Frequently Asked Questions</h2>
            
            <div class="space-y-4">
                <details class="bg-gray-800 rounded-lg p-6 group">
                    <summary class="font-semibold text-white cursor-pointer list-none flex items-center justify-between">
                        <span>Can I cancel my subscription anytime?</span>
                        <svg class="w-5 h-5 text-gray-400 group-open:rotate-180 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </summary>
                    <p class="text-gray-400 mt-4">Yes, you can cancel your subscription at any time. Your plan will remain active until the end of your current billing period.</p>
                </details>

                <details class="bg-gray-800 rounded-lg p-6 group">
                    <summary class="font-semibold text-white cursor-pointer list-none flex items-center justify-between">
                        <span>What payment methods do you accept?</span>
                        <svg class="w-5 h-5 text-gray-400 group-open:rotate-180 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </summary>
                    <p class="text-gray-400 mt-4">We accept all major credit cards, debit cards, and various local payment methods through Paddle.</p>
                </details>

                <details class="bg-gray-800 rounded-lg p-6 group">
                    <summary class="font-semibold text-white cursor-pointer list-none flex items-center justify-between">
                        <span>Can I upgrade or downgrade my plan?</span>
                        <svg class="w-5 h-5 text-gray-400 group-open:rotate-180 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </summary>
                    <p class="text-gray-400 mt-4">Yes! You can upgrade immediately with prorated charges. Downgrades take effect at the end of your current billing period.</p>
                </details>

                <details class="bg-gray-800 rounded-lg p-6 group">
                    <summary class="font-semibold text-white cursor-pointer list-none flex items-center justify-between">
                        <span>Do you offer refunds?</span>
                        <svg class="w-5 h-5 text-gray-400 group-open:rotate-180 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </summary>
                    <p class="text-gray-400 mt-4">We offer a 7-day money-back guarantee. If you're not satisfied, contact support within 7 days for a full refund.</p>
                </details>

                <details class="bg-gray-800 rounded-lg p-6 group">
                    <summary class="font-semibold text-white cursor-pointer list-none flex items-center justify-between">
                        <span>What happens when I cancel?</span>
                        <svg class="w-5 h-5 text-gray-400 group-open:rotate-180 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </summary>
                    <p class="text-gray-400 mt-4">When you cancel, you'll keep your premium features until the end of your billing period. After that, you'll automatically switch to the Free plan.</p>
                </details>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
const billingToggle = document.getElementById('billing-toggle');
const plans = @json($plans->pluck('id'));

// Toggle between monthly and annual pricing
billingToggle.addEventListener('change', function() {
    const isAnnual = this.checked;
    
    plans.forEach(planId => {
        const monthlyPrice = document.querySelector(`.monthly-price-${planId}`);
        const yearlyPrice = document.querySelector(`.yearly-price-${planId}`);
        const yearlyBilling = document.querySelector(`.yearly-billing-${planId}`);
        
        if (monthlyPrice && yearlyPrice) {
            if (isAnnual) {
                monthlyPrice.style.display = 'none';
                yearlyPrice.style.display = 'inline';
                if (yearlyBilling) yearlyBilling.style.display = 'block';
            } else {
                monthlyPrice.style.display = 'inline';
                yearlyPrice.style.display = 'none';
                if (yearlyBilling) yearlyBilling.style.display = 'none';
            }
        }
    });
});

// Subscribe function
function subscribe(planSlug) {
    const isAnnual = billingToggle.checked;
    const interval = isAnnual ? 'yearly' : 'monthly';
    window.location.href = `/subscribe/${planSlug}/${interval}`;
}
</script>
@endpush

</section>

</x-layouts.stellar>

