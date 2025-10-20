<x-layouts.app>
    <x-slot name="title">{{ __('Pricing') }} - {{ config('app.name') }}</x-slot>

    <!-- Hero -->
    <section class="relative pt-32 pb-16 md:pb-20">
        <!-- Radial gradient -->
        <div class="absolute flex items-center justify-center top-0 -translate-y-1/2 left-1/2 -translate-x-1/2 pointer-events-none -z-10 w-[800px] aspect-square" aria-hidden="true">
            <div class="absolute inset-0 translate-z-0 bg-purple-500 rounded-full blur-[120px] opacity-30"></div>
            <div class="absolute w-64 h-64 translate-z-0 bg-purple-400 rounded-full blur-[80px] opacity-70"></div>
        </div>

        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <!-- Section header -->
            <div class="text-center pb-12 md:pb-16">
                <div class="inline-flex font-medium bg-clip-text text-transparent bg-gradient-to-r from-purple-500 to-purple-200 pb-3" data-aos="fade-down">
                    {{ __('Flexible Pricing') }}
                </div>
                <h1 class="h1 bg-clip-text text-transparent bg-gradient-to-r from-slate-200/60 via-slate-200 to-slate-200/60 pb-4" data-aos="fade-down">
                    {{ __('Choose Your Plan') }}
                </h1>
                <div class="max-w-3xl mx-auto">
                    <p class="text-lg text-slate-400" data-aos="fade-down" data-aos-delay="200">
                        {{ __('Choose the perfect plan for your needs. All plans include secure payments, instant delivery, and 24/7 support.') }}
                    </p>
                </div>
            </div>

            <!-- Pricing Toggle -->
            <div class="flex justify-center mb-12" x-data="{ annual: {{ request('interval') === 'yearly' ? 'true' : 'false' }} }">
                <div class="inline-flex items-center bg-slate-800/50 rounded-full p-1 border border-slate-700">
                    <button 
                        @click="annual = false" 
                        class="px-6 py-2 rounded-full text-sm font-medium transition-colors duration-200"
                        :class="!annual ? 'bg-purple-500 text-white' : 'text-slate-400 hover:text-slate-200'">
                        {{ __('Monthly') }}
                    </button>
                    <button 
                        @click="annual = true" 
                        class="px-6 py-2 rounded-full text-sm font-medium transition-colors duration-200 flex items-center"
                        :class="annual ? 'bg-purple-500 text-white' : 'text-slate-400 hover:text-slate-200'">
                        {{ __('Annual') }}
                        <span class="ml-2 text-xs bg-green-500/20 text-green-400 px-2 py-0.5 rounded-full">{{ __('Save 20%') }}</span>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Cards -->
    <section class="pb-16 md:pb-20">
        <div class="max-w-6xl mx-auto px-4 sm:px-6" x-data="{ annual: {{ request('interval') === 'yearly' ? 'true' : 'false' }} }">
            @if(isset($plans) && $plans->count() > 0)
                <div class="grid md:grid-cols-{{ min($plans->count(), 3) }} gap-8">
                    @foreach($plans as $plan)
                        <div class="relative" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                            <!-- Highlight popular plan -->
                            @if($plan->is_popular ?? $loop->index === 1)
                                <div class="absolute -top-4 left-1/2 -translate-x-1/2 z-10">
                                    <span class="inline-flex items-center px-4 py-1 bg-purple-500 text-white text-xs font-bold rounded-full shadow-lg">
                                        {{ __('Most Popular') }}
                                    </span>
                                </div>
                            @endif

                            <div class="relative h-full bg-slate-800/50 rounded-2xl p-6 lg:p-8 border-2 {{ ($plan->is_popular ?? $loop->index === 1) ? 'border-purple-500 shadow-xl shadow-purple-500/20' : 'border-slate-700' }}">
                                <!-- Plan Header -->
                                <div class="text-center mb-6">
                                    <h3 class="text-xl font-bold text-slate-100 mb-2">{{ $plan->name }}</h3>
                                    @php
                                        $monthly = $plan->monthly_price ?? ($plan->price ?? 0);
                                        $annualTotal = $plan->yearly_price ?? ($monthly * 12 * 0.8);
                                        $annualMonthly = round($annualTotal / 12, 2);
                                        $savePct = $monthly > 0 ? round((1 - ($annualMonthly / $monthly)) * 100) : 0;
                                    @endphp
                                    <div class="text-4xl font-bold text-white mb-1">
                                        <span x-show="!annual">${{ number_format($monthly, 2) }}</span>
                                        <span x-show="annual">${{ number_format($annualMonthly, 2) }}</span>
                                        <span class="text-sm text-slate-400 font-normal">/{{ __('mo') }}</span>
                                    </div>
                                    <div class="text-xs text-slate-400" x-show="annual">
                                        {{ __('Billed annually') }} • ${{ number_format($annualTotal, 2) }}
                                        @if($savePct > 0)
                                            <span class="ml-2 px-2 py-0.5 rounded-full bg-green-500/20 text-green-400">{{ __('Save') }} {{ $savePct }}%</span>
                                        @endif
                                    </div>
                                    <p class="text-slate-400 text-sm">{{ $plan->description ?? '' }}</p>
                                </div>

                                <!-- Features List -->
                                <ul class="space-y-3 mb-8">
                                    @if(!empty($plan->features))
                                        @foreach($plan->features as $feature)
                                            <li class="flex items-start text-sm text-slate-300">
                                                <svg class="w-5 h-5 text-purple-500 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                </svg>
                                                <span class="text-slate-300">
                                                    {{ is_object($feature) ? ($feature->label ?? $feature->name ?? '') : (is_array($feature) ? ($feature['label'] ?? $feature['name'] ?? '') : (string) $feature) }}
                                                    @if(is_object($feature) && !empty($feature->is_new))
                                                        <span class="inline-flex items-center px-2 py-0.5 text-xs font-medium text-blue-400 bg-blue-900/30 rounded ml-2">{{ __('New') }}</span>
                                                    @endif
                                                </span>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>

                                <!-- CTA Button -->
                                @auth
                                    <form method="POST" x-bind:action="annual ? '{{ route('subscription.subscribe', [$plan, 'yearly']) }}' : '{{ route('subscription.subscribe', [$plan, 'monthly']) }}'">
                                        @csrf
                                        <button type="submit" class="btn w-full {{ ($plan->is_popular ?? $loop->index === 1) ? 'text-white bg-purple-500 hover:bg-purple-600 shadow-lg shadow-purple-500/25' : 'text-slate-900 bg-gradient-to-r from-white/80 via-white to-white/80 hover:bg-white' }} transition duration-150 ease-in-out group">
                                            {{ __('Get Started') }}
                                            <span class="tracking-normal {{ ($plan->is_popular ?? $loop->index === 1) ? 'text-purple-300' : 'text-purple-500' }} group-hover:translate-x-0.5 transition-transform duration-150 ease-in-out ml-1">→</span>
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('login') }}?redirect={{ urlencode(route('pricing.index')) }}" 
                                       class="btn w-full {{ ($plan->is_popular ?? $loop->index === 1) ? 'text-white bg-purple-500 hover:bg-purple-600 shadow-lg shadow-purple-500/25' : 'text-slate-900 bg-gradient-to-r from-white/80 via-white to-white/80 hover:bg-white' }} transition duration-150 ease-in-out group">
                                        {{ __('Get Started') }}
                                        <span class="tracking-normal {{ ($plan->is_popular ?? $loop->index === 1) ? 'text-purple-300' : 'text-purple-500' }} group-hover:translate-x-0.5 transition-transform duration-150 ease-in-out ml-1">→</span>
                                    </a>
                                @endauth
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- No plans available -->
                <div class="text-center py-12">
                    <p class="text-slate-400">{{ __('No pricing plans available at the moment.') }}</p>
                </div>
            @endif
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="pb-16 md:pb-20">
        <div class="max-w-3xl mx-auto px-4 sm:px-6">
            <div class="text-center mb-12">
                <h2 class="h3 text-slate-100 mb-4">{{ __('Frequently Asked Questions') }}</h2>
                <p class="text-slate-400">{{ __('Have questions? We have answers.') }}</p>
            </div>

            <div class="space-y-4" x-data="{ activeIndex: null }">
                @php
                $faqs = [
                    ['q' => __('How does billing work?'), 'a' => __('We bill you automatically at the start of each billing period. You can cancel anytime.')],
                    ['q' => __('Can I change my plan later?'), 'a' => __('Yes, you can upgrade or downgrade your plan at any time from your account settings.')],
                    ['q' => __('What payment methods do you accept?'), 'a' => __('We accept all major credit cards, PayPal, and various local payment methods.')],
                    ['q' => __('Is there a refund policy?'), 'a' => __('Yes, we offer a 30-day money-back guarantee on all plans.')],
                ];
                @endphp

                @foreach($faqs as $index => $faq)
                    <div class="bg-slate-800/50 rounded-2xl border border-slate-700/50 overflow-hidden">
                        <button 
                            @click="activeIndex = activeIndex === {{ $index }} ? null : {{ $index }}"
                            class="w-full text-left px-6 py-4 flex items-center justify-between hover:bg-slate-800/30 transition-colors">
                            <span class="font-medium text-slate-100">{{ $faq['q'] }}</span>
                            <svg 
                                class="w-5 h-5 text-purple-500 transition-transform duration-200"
                                :class="{ 'rotate-180': activeIndex === {{ $index }} }"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div 
                            x-show="activeIndex === {{ $index }}"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 -translate-y-2"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 -translate-y-2"
                            class="px-6 pb-4">
                            <p class="text-slate-400">{{ $faq['a'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="pb-16">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="relative bg-gradient-to-r from-purple-500/10 to-purple-600/10 rounded-3xl p-8 md:p-12 border border-purple-500/20 overflow-hidden">
                <!-- Background decoration -->
                <div class="absolute inset-0 -z-10 opacity-20" aria-hidden="true">
                    <div class="absolute inset-0 bg-gradient-to-r from-purple-500 to-purple-600 blur-3xl"></div>
                </div>
                
                <div class="text-center">
                    <h2 class="h3 text-slate-100 mb-4">{{ __('Still have questions?') }}</h2>
                    <p class="text-lg text-slate-300 mb-8">
                        {{ __('Our team is here to help. Contact us and we\'ll get back to you within 24 hours.') }}
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('home') }}#contact" class="btn text-white bg-purple-500 hover:bg-purple-600">
                            {{ __('Contact Sales') }}
                        </a>
                        <a href="{{ route('products.index') }}" class="btn text-slate-200 hover:text-white bg-slate-900/25 hover:bg-slate-900/30">
                            {{ __('Browse Products') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
