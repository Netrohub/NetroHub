@extends('layouts.app')

@section('content')
<div class="min-h-screen relative overflow-hidden">
    <!-- Gaming Background Effects -->
    <div class="absolute inset-0">
        <div class="absolute top-20 left-10 w-96 h-96 bg-primary-500/20 rounded-full blur-3xl animate-float"></div>
        <div class="absolute top-40 right-10 w-96 h-96 bg-secondary-500/20 rounded-full blur-3xl animate-float animation-delay-2000"></div>
        <div class="absolute bottom-20 left-40 w-96 h-96 bg-neon-blue/10 rounded-full blur-3xl animate-float animation-delay-4000"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Gaming Header Section -->
        <div class="mb-12">
            <a href="{{ route('products.index') }}" class="inline-flex items-center text-primary-400 hover:text-primary-300 mb-8 transition-all duration-300 group">
                <div class="w-8 h-8 rounded-xl bg-primary-500/20 flex items-center justify-center mr-3 group-hover:bg-primary-500/30 transition-all duration-300 group-hover:scale-110">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </div>
                <span class="font-semibold">Back to Marketplace</span>
            </a>
        </div>

        <!-- Gaming Hero Section -->
        <div class="text-center mb-16 animate-fade-in">
            <div class="inline-flex items-center justify-center w-24 h-24 bg-gaming-gradient rounded-3xl mb-8 shadow-gaming-lg animate-pulse-slow">
                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
            </div>
            
            <h1 class="text-6xl md:text-7xl font-black text-white mb-6 leading-tight">
                What do you want to
                <span class="bg-gaming-gradient bg-clip-text text-transparent animate-glow">
                    sell today?
                </span>
            </h1>
            
            <p class="text-xl text-muted-300 max-w-3xl mx-auto leading-relaxed">
                Choose your product type and start earning money from your digital assets. 
                <span class="block mt-2 text-lg text-muted-400">Join thousands of successful sellers in the gaming community.</span>
            </p>
        </div>

        <!-- Gaming Product Type Cards -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-16">
            <!-- Game Accounts Card -->
            <x-ui.card variant="glass" hover="true" glow="true" class="group animate-fade-in animation-delay-200">
                <div class="relative">
                    <!-- Gaming Icon -->
                    <div class="relative mb-8">
                        <div class="absolute inset-0 bg-gaming-gradient rounded-3xl blur-2xl opacity-50 group-hover:opacity-75 transition-opacity duration-300"></div>
                        <div class="relative w-20 h-20 bg-gaming-gradient rounded-3xl flex items-center justify-center shadow-gaming-lg group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z" />
                            </svg>
                        </div>
                    </div>

                    <!-- Content -->
                    <h2 class="text-4xl font-black text-white mb-4 group-hover:text-primary-300 transition-colors">🎮 Game Accounts</h2>
                    <p class="text-lg text-muted-300 mb-8 leading-relaxed group-hover:text-muted-200 transition-colors">
                        Sell game accounts, in-game items, top-ups, or gaming services. 
                        Perfect for gamers looking to monetize their achievements and collections.
                    </p>

                    <!-- Gaming Features List -->
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-center text-muted-300 group-hover:text-white transition-colors">
                            <div class="w-6 h-6 bg-primary-500 rounded-full mr-4 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <span class="font-medium">Game accounts & characters</span>
                        </li>
                        <li class="flex items-center text-muted-300 group-hover:text-white transition-colors">
                            <div class="w-6 h-6 bg-primary-500 rounded-full mr-4 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <span class="font-medium">In-game items & currency</span>
                        </li>
                        <li class="flex items-center text-muted-300 group-hover:text-white transition-colors">
                            <div class="w-6 h-6 bg-primary-500 rounded-full mr-4 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <span class="font-medium">Gaming services & coaching</span>
                        </li>
                    </ul>

                    <!-- Gaming Action Button -->
                    <x-ui.button href="{{ route('sell.game.create') }}" variant="primary" size="lg" glow="true" class="w-full">
                        <span class="flex items-center justify-center">
                            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            <span class="text-lg font-bold">START SELLING GAMES</span>
                        </span>
                    </x-ui.button>
                </div>
            </x-ui.card>

            <!-- Social Accounts Card -->
            <x-ui.card variant="glass" hover="true" glow="true" class="group animate-fade-in animation-delay-400">
                <div class="relative">
                    <!-- Social Gaming Icon -->
                    <div class="relative mb-8">
                        <div class="absolute inset-0 bg-gradient-to-r from-secondary-500 to-neon-pink rounded-3xl blur-2xl opacity-50 group-hover:opacity-75 transition-opacity duration-300"></div>
                        <div class="relative w-20 h-20 bg-gradient-to-r from-secondary-500 to-neon-pink rounded-3xl flex items-center justify-center shadow-gaming-purple group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                    </div>

                    <!-- Content -->
                    <h2 class="text-4xl font-black text-white mb-4 group-hover:text-secondary-300 transition-colors">📱 Social Accounts</h2>
                    <p class="text-lg text-muted-300 mb-8 leading-relaxed group-hover:text-muted-200 transition-colors">
                        Monetize your social media presence. Sell accounts, offer shoutouts, 
                        or provide promotional services to brands and individuals.
                    </p>

                    <!-- Social Features List -->
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-center text-muted-300 group-hover:text-white transition-colors">
                            <div class="w-6 h-6 bg-secondary-500 rounded-full mr-4 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <span class="font-medium">Social media accounts</span>
                        </li>
                        <li class="flex items-center text-muted-300 group-hover:text-white transition-colors">
                            <div class="w-6 h-6 bg-secondary-500 rounded-full mr-4 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <span class="font-medium">Shoutouts & promotions</span>
                        </li>
                        <li class="flex items-center text-muted-300 group-hover:text-white transition-colors">
                            <div class="w-6 h-6 bg-secondary-500 rounded-full mr-4 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <span class="font-medium">Influence marketing</span>
                        </li>
                    </ul>

                    <!-- Social Action Button -->
                    <x-ui.button href="{{ route('sell.social.create') }}" variant="secondary" size="lg" glow="true" class="w-full">
                        <span class="flex items-center justify-center">
                            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            <span class="text-lg font-bold">START SELLING SOCIAL</span>
                        </span>
                    </x-ui.button>
                </div>
            </x-ui.card>
        </div>

        <!-- Gaming Features Section -->
        <x-ui.card variant="glass" class="animate-fade-in animation-delay-600">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-black text-white mb-6 bg-gaming-gradient bg-clip-text text-transparent">
                    Why Choose NetroHub?
                </h2>
                <p class="text-lg text-muted-300 max-w-2xl mx-auto leading-relaxed">
                    We provide everything you need to start selling and grow your business in the gaming community
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="text-center group">
                    <div class="relative mb-6">
                        <div class="absolute inset-0 bg-gradient-to-br from-green-500 to-emerald-600 rounded-3xl blur-xl opacity-50 group-hover:opacity-75 transition-opacity"></div>
                        <div class="relative w-20 h-20 bg-gradient-to-br from-green-500 to-emerald-600 rounded-3xl flex items-center justify-center mx-auto shadow-gaming-lg group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-4 group-hover:text-green-400 transition-colors">💰 Secure Payments</h3>
                    <p class="text-muted-300 leading-relaxed group-hover:text-muted-200 transition-colors">
                        Get paid safely with our trusted payment system. Multiple payment options and secure transactions with instant payouts.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="text-center group">
                    <div class="relative mb-6">
                        <div class="absolute inset-0 bg-gaming-gradient rounded-3xl blur-xl opacity-50 group-hover:opacity-75 transition-opacity"></div>
                        <div class="relative w-20 h-20 bg-gaming-gradient rounded-3xl flex items-center justify-center mx-auto shadow-gaming-lg group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-4 group-hover:text-primary-400 transition-colors">⚡ Instant Publishing</h3>
                    <p class="text-muted-300 leading-relaxed group-hover:text-muted-200 transition-colors">
                        Your products go live in minutes. No waiting, no delays. Start earning immediately with our lightning-fast platform.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="text-center group">
                    <div class="relative mb-6">
                        <div class="absolute inset-0 bg-gradient-to-br from-secondary-500 to-neon-pink rounded-3xl blur-xl opacity-50 group-hover:opacity-75 transition-opacity"></div>
                        <div class="relative w-20 h-20 bg-gradient-to-br from-secondary-500 to-neon-pink rounded-3xl flex items-center justify-center mx-auto shadow-gaming-purple group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M12 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-4 group-hover:text-secondary-400 transition-colors">🛠️ 24/7 Support</h3>
                    <p class="text-muted-300 leading-relaxed group-hover:text-muted-200 transition-colors">
                        We're here to help you succeed. Get support whenever you need it, day or night from our gaming-focused team.
                    </p>
                </div>
            </div>
        </x-ui.card>

        <!-- Gaming Bottom CTA -->
        <div class="text-center mt-16 animate-fade-in animation-delay-800">
            <div class="inline-flex items-center px-6 py-4 bg-dark-800/50 backdrop-blur-sm border border-gaming rounded-2xl mb-8">
                <svg class="w-6 h-6 mr-3 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-muted-300 font-medium">You can change the product type later in the editor</span>
            </div>
            
            <div class="flex items-center justify-center space-x-8 text-sm">
                <div class="flex items-center text-muted-400">
                    <div class="w-3 h-3 bg-green-500 rounded-full mr-3 animate-pulse"></div>
                    <span>Free to list</span>
                </div>
                <div class="flex items-center text-muted-400">
                    <div class="w-3 h-3 bg-primary-500 rounded-full mr-3 animate-pulse animation-delay-2000"></div>
                    <span>No monthly fees</span>
                </div>
                <div class="flex items-center text-muted-400">
                    <div class="w-3 h-3 bg-secondary-500 rounded-full mr-3 animate-pulse animation-delay-4000"></div>
                    <span>Secure transactions</span>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

@keyframes fade-in {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.animate-float {
    animation: float 6s ease-in-out infinite;
}

.animate-fade-in {
    animation: fade-in 0.8s ease-out forwards;
}

.animation-delay-200 {
    animation-delay: 0.2s;
}

.animation-delay-400 {
    animation-delay: 0.4s;
}

.animation-delay-600 {
    animation-delay: 0.6s;
}

.animation-delay-800 {
    animation-delay: 0.8s;
}

.animation-delay-2000 {
    animation-delay: 2s;
}

.animation-delay-4000 {
    animation-delay: 4s;
}
</style>
@endsection