<x-layouts.app>
    <x-slot name="title">{{ __('Start Selling') }} - {{ config('app.name') }}</x-slot>

    <!-- Hero Section -->
    <section class="relative pt-32 pb-16 md:pb-20">
        <div class="absolute inset-0 -z-10 -mx-28 rounded-b-[3rem] pointer-events-none overflow-hidden" aria-hidden="true">
            <div class="absolute left-1/2 -translate-x-1/2 bottom-0 -z-10">
                <img src="{{ asset('stellar-assets/images/glow-bottom.svg') }}" class="max-w-none" width="2146" height="774" alt="Hero Illustration">
            </div>
        </div>

        <!-- Particles animation -->
        <div class="absolute inset-0 -z-10" aria-hidden="true">
            <canvas data-particle-animation></canvas>
        </div>

        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="text-center max-w-3xl mx-auto mb-12">
                <div class="inline-flex font-medium bg-clip-text text-transparent bg-gradient-to-r from-purple-500 to-purple-200 pb-3 mb-4" data-aos="fade-down">
                    {{ __('Join Our Marketplace') }}
                </div>
                <h1 class="h1 bg-clip-text text-transparent bg-gradient-to-r from-slate-200/60 via-slate-200 to-slate-200/60 pb-4" data-aos="fade-down">
                    {{ __('Start Selling Today') }}
                </h1>
                <p class="text-lg text-slate-300 mb-8" data-aos="fade-down" data-aos-delay="200">
                    {{ __('Turn your digital products into profit. Join thousands of sellers earning on our platform with instant payouts and secure transactions.') }}
                </p>
            </div>

                @auth
                <!-- Choose Product Type Section -->
                <div class="max-w-5xl mx-auto">

                    <!-- Product Type Cards -->
                    <div class="grid md:grid-cols-2 gap-8 lg:gap-12 mt-2">
                        <!-- Gaming Accounts Card -->
                        <div class="group relative" data-aos="fade-up" data-aos-delay="100">
                            <div class="absolute inset-0 bg-gradient-to-br from-purple-500/20 to-purple-600/20 rounded-3xl blur-xl opacity-0 group-hover:opacity-100 transition-all duration-500"></div>
                            <a href="{{ route('sell.game.create') }}" class="relative block bg-gradient-to-br from-slate-800 to-slate-800/80 rounded-3xl p-8 lg:p-10 border border-slate-700/50 hover:border-purple-500/50 transition-all duration-300 overflow-hidden">
                                <!-- Decorative glow -->
                                <div class="absolute top-0 right-0 w-48 h-48 bg-purple-500/10 rounded-full blur-3xl -z-10"></div>
                                
                                <!-- Icon Container -->
                                <div class="flex justify-center mb-6">
                                        <div class="relative">
                                            <div class="absolute inset-0 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl blur-md opacity-50"></div>
                                            <div class="relative w-20 h-20 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center transform group-hover:scale-110 transition-transform duration-300">
                                                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z"/>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Title -->
                                    <h3 class="text-2xl lg:text-3xl font-bold text-slate-100 mb-4 text-center">
                                        {{ __('Gaming Accounts') }}
                                    </h3>

                                    <!-- Description -->
                                    <p class="text-slate-400 text-center mb-6 leading-relaxed">
                                        {{ __('Sell game accounts, in-game items, currency, and gaming-related digital products') }}
                                    </p>

                                    <!-- Features List -->
                                    <ul class="space-y-3 mb-6">
                                        <li class="flex items-center text-sm text-slate-300">
                                            <svg class="w-5 h-5 text-purple-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            {{ __('Popular games & platforms') }}
                                        </li>
                                        <li class="flex items-center text-sm text-slate-300">
                                            <svg class="w-5 h-5 text-purple-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            {{ __('Secure account transfer') }}
                                        </li>
                                        <li class="flex items-center text-sm text-slate-300">
                                            <svg class="w-5 h-5 text-purple-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            {{ __('Instant delivery system') }}
                                        </li>
                                </ul>

                                <!-- CTA -->
                                <div class="flex items-center justify-center text-white group-hover:text-purple-300 transition-colors duration-300">
                                        <span class="font-semibold mr-2">{{ __('Start Selling') }}</span>
                                        <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                        </svg>
                                </div>
                            </a>
                        </div>

                        <!-- Social Accounts Card -->
                        <div class="group relative" data-aos="fade-up" data-aos-delay="200">
                            <div class="absolute inset-0 bg-gradient-to-br from-blue-500/20 to-cyan-500/20 rounded-3xl blur-xl opacity-0 group-hover:opacity-100 transition-all duration-500"></div>
                            <a href="{{ route('sell.social.create') }}" class="relative block bg-gradient-to-br from-slate-800 to-slate-800/80 rounded-3xl p-8 lg:p-10 border border-slate-700/50 hover:border-blue-500/50 transition-all duration-300 overflow-hidden">
                                <!-- Decorative glow -->
                                <div class="absolute top-0 right-0 w-48 h-48 bg-blue-500/10 rounded-full blur-3xl -z-10"></div>
                                
                                <!-- Icon Container -->
                                <div class="flex justify-center mb-6">
                                        <div class="relative">
                                            <div class="absolute inset-0 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-2xl blur-md opacity-50"></div>
                                            <div class="relative w-20 h-20 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-2xl flex items-center justify-center transform group-hover:scale-110 transition-transform duration-300">
                                                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                                </svg>
                                            </div>
                                    </div>
                                </div>

                                <!-- Title -->
                                <h3 class="text-2xl lg:text-3xl font-bold text-slate-100 mb-4 text-center">
                                    {{ __('Social Accounts') }}
                                </h3>

                                <!-- Description -->
                                <p class="text-slate-400 text-center mb-6 leading-relaxed">
                                    {{ __('Sell social media accounts, followers, engagement packages, and social platform services') }}
                                </p>

                                <!-- Features List -->
                                <ul class="space-y-3 mb-6">
                                        <li class="flex items-center text-sm text-slate-300">
                                            <svg class="w-5 h-5 text-blue-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            {{ __('All major platforms') }}
                                        </li>
                                        <li class="flex items-center text-sm text-slate-300">
                                            <svg class="w-5 h-5 text-blue-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            {{ __('Verified account transfers') }}
                                        </li>
                                        <li class="flex items-center text-sm text-slate-300">
                                            <svg class="w-5 h-5 text-blue-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            {{ __('Safe & protected sales') }}
                                        </li>
                                </ul>

                                <!-- CTA -->
                                <div class="flex items-center justify-center text-white group-hover:text-blue-300 transition-colors duration-300">
                                    <span class="font-semibold mr-2">{{ __('Start Selling') }}</span>
                                    <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                    </svg>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center max-w-lg mx-auto" data-aos="fade-up">
                    <div class="bg-slate-800/50 rounded-2xl p-8 border border-slate-700/50 mb-6">
                        <svg class="w-16 h-16 text-purple-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        <h3 class="text-xl font-bold text-slate-100 mb-2">{{ __('Sign In Required') }}</h3>
                        <p class="text-slate-400 mb-6">{{ __('You need to sign in or create an account to start selling on our platform') }}</p>
                    </div>
                    <a href="{{ route('register') }}" class="btn text-white bg-purple-500 hover:bg-purple-600 inline-flex">
                        {{ __('Sign Up to Start Selling') }} →
                    </a>
                </div>
                @endauth
        </div>
    </section>

    <!-- Benefits Section -->
    <section class="relative pt-6 pb-16 md:pb-20">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="text-center mb-12">
                <h2 class="h3 bg-clip-text text-transparent bg-gradient-to-r from-slate-200/60 via-slate-200 to-slate-200/60 mb-4">
                    {{ __('Why Sell With Us?') }}
                </h2>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-slate-800/50 rounded-2xl p-6 lg:p-8 border border-slate-700/50" data-aos="fade-up">
                    <div class="w-12 h-12 bg-purple-500/20 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-100 mb-2">{{ __('Instant Payouts') }}</h3>
                    <p class="text-slate-400">{{ __('Get paid quickly with our automated payout system. Withdraw your earnings anytime.') }}</p>
                </div>

                <div class="bg-slate-800/50 rounded-2xl p-6 lg:p-8 border border-slate-700/50" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-12 h-12 bg-green-500/20 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-100 mb-2">{{ __('Secure Platform') }}</h3>
                    <p class="text-slate-400">{{ __('Your products and earnings are protected with bank-level security and fraud prevention.') }}</p>
                </div>

                <div class="bg-slate-800/50 rounded-2xl p-6 lg:p-8 border border-slate-700/50" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-12 h-12 bg-blue-500/20 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-100 mb-2">{{ __('Large Audience') }}</h3>
                    <p class="text-slate-400">{{ __('Reach thousands of potential buyers actively searching for digital products.') }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section removed per design cleanup -->
</x-layouts.app>
