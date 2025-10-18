<x-layouts.stellar>
    <x-slot name="title">{{ __('About Us') }} - {{ config('app.name') }}</x-slot>

    <!-- Hero Section -->
    <section class="relative pt-32 pb-16 md:pt-52 md:pb-32 overflow-hidden">
        <!-- Background Effects -->
        <div class="absolute inset-0 -z-10">
            <div class="absolute top-1/4 left-1/4 w-64 h-64 bg-purple-500/10 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-1/4 right-1/4 w-64 h-64 bg-blue-500/10 rounded-full blur-3xl animate-pulse animation-delay-2000"></div>
        </div>

        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl font-black bg-clip-text text-transparent bg-gradient-to-r from-purple-400 via-purple-500 to-blue-500 mb-6" data-aos="fade-down">
                    {{ __('About NetroHub') }}
                </h1>
                <p class="text-xl text-slate-300 max-w-3xl mx-auto leading-relaxed" data-aos="fade-down" data-aos-delay="200">
                    {{ __('Your trusted platform for buying and selling digital accounts safely and securely. We connect verified sellers with buyers worldwide.') }}
                </p>
            </div>
        </div>
    </section>

    <!-- Mission Section -->
    <section class="py-16 md:py-24">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div data-aos="fade-right">
                    <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">
                        {{ __('Our Mission') }}
                    </h2>
                    <p class="text-lg text-slate-300 mb-6 leading-relaxed">
                        {{ __('At NetroHub, we believe in creating a safe, transparent, and efficient marketplace for digital accounts. Our mission is to bridge the gap between sellers and buyers while ensuring the highest standards of security and trust.') }}
                    </p>
                    <p class="text-lg text-slate-300 leading-relaxed">
                        {{ __('We are committed to providing a platform where users can trade digital assets with confidence, backed by our robust verification system and dedicated support team.') }}
                    </p>
                </div>
                <div class="relative" data-aos="fade-left">
                    <div class="bg-gradient-to-br from-purple-500/20 to-blue-500/20 rounded-3xl p-8 border border-purple-500/30">
                        <div class="text-6xl mb-4">🎯</div>
                        <h3 class="text-2xl font-bold text-white mb-4">{{ __('Trust & Security First') }}</h3>
                        <p class="text-slate-300">{{ __('Every transaction is protected by our advanced security measures and verification processes.') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Values Section -->
    <section class="py-16 md:py-24 bg-slate-800/30">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">
                    {{ __('Our Core Values') }}
                </h2>
                <p class="text-lg text-slate-300 max-w-2xl mx-auto">
                    {{ __('The principles that guide everything we do at NetroHub') }}
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="text-center" data-aos="fade-up" data-aos-delay="100">
                    <div class="bg-gradient-to-br from-green-500/20 to-emerald-500/20 rounded-2xl p-8 border border-green-500/30 mb-6">
                        <div class="text-5xl mb-4">🔒</div>
                        <h3 class="text-xl font-bold text-white mb-3">{{ __('Security') }}</h3>
                        <p class="text-slate-300">{{ __('Advanced encryption and verification systems protect every transaction and user data.') }}</p>
                    </div>
                </div>

                <div class="text-center" data-aos="fade-up" data-aos-delay="200">
                    <div class="bg-gradient-to-br from-blue-500/20 to-cyan-500/20 rounded-2xl p-8 border border-blue-500/30 mb-6">
                        <div class="text-5xl mb-4">🤝</div>
                        <h3 class="text-xl font-bold text-white mb-3">{{ __('Trust') }}</h3>
                        <p class="text-slate-300">{{ __('Transparent processes and verified sellers ensure every transaction is legitimate and secure.') }}</p>
                    </div>
                </div>

                <div class="text-center" data-aos="fade-up" data-aos-delay="300">
                    <div class="bg-gradient-to-br from-purple-500/20 to-pink-500/20 rounded-2xl p-8 border border-purple-500/30 mb-6">
                        <div class="text-5xl mb-4">⚡</div>
                        <h3 class="text-xl font-bold text-white mb-3">{{ __('Innovation') }}</h3>
                        <p class="text-slate-300">{{ __('Cutting-edge technology and features that make trading digital accounts seamless and efficient.') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-16 md:py-24">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">
                    {{ __('Why Choose NetroHub?') }}
                </h2>
                <p class="text-lg text-slate-300 max-w-2xl mx-auto">
                    {{ __('Discover what makes us the leading platform for digital account trading') }}
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center" data-aos="fade-up" data-aos-delay="100">
                    <div class="bg-slate-800/50 rounded-2xl p-6 border border-slate-700/50 hover:border-purple-500/30 transition-all group">
                        <div class="text-4xl mb-4 group-hover:scale-110 transition-transform">🛡️</div>
                        <h3 class="text-lg font-bold text-white mb-3">{{ __('Verified Sellers') }}</h3>
                        <p class="text-slate-400 text-sm">{{ __('All sellers undergo rigorous verification to ensure authenticity and reliability.') }}</p>
                    </div>
                </div>

                <div class="text-center" data-aos="fade-up" data-aos-delay="200">
                    <div class="bg-slate-800/50 rounded-2xl p-6 border border-slate-700/50 hover:border-purple-500/30 transition-all group">
                        <div class="text-4xl mb-4 group-hover:scale-110 transition-transform">💳</div>
                        <h3 class="text-lg font-bold text-white mb-3">{{ __('Secure Payments') }}</h3>
                        <p class="text-slate-400 text-sm">{{ __('Multiple payment options with escrow protection for safe transactions.') }}</p>
                    </div>
                </div>

                <div class="text-center" data-aos="fade-up" data-aos-delay="300">
                    <div class="bg-slate-800/50 rounded-2xl p-6 border border-slate-700/50 hover:border-purple-500/30 transition-all group">
                        <div class="text-4xl mb-4 group-hover:scale-110 transition-transform">🎮</div>
                        <h3 class="text-lg font-bold text-white mb-3">{{ __('Wide Selection') }}</h3>
                        <p class="text-slate-400 text-sm">{{ __('Gaming accounts, social media profiles, and more from trusted sellers.') }}</p>
                    </div>
                </div>

                <div class="text-center" data-aos="fade-up" data-aos-delay="400">
                    <div class="bg-slate-800/50 rounded-2xl p-6 border border-slate-700/50 hover:border-purple-500/30 transition-all group">
                        <div class="text-4xl mb-4 group-hover:scale-110 transition-transform">📞</div>
                        <h3 class="text-lg font-bold text-white mb-3">{{ __('24/7 Support') }}</h3>
                        <p class="text-slate-400 text-sm">{{ __('Round-the-clock customer support to help with any questions or issues.') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-16 md:py-24 bg-gradient-to-r from-purple-500/10 to-blue-500/10">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">
                    {{ __('Our Impact') }}
                </h2>
                <p class="text-lg text-slate-300">
                    {{ __('Numbers that speak for themselves') }}
                </p>
            </div>

            <div class="grid md:grid-cols-4 gap-8">
                <div class="text-center" data-aos="fade-up" data-aos-delay="100">
                    <div class="text-4xl md:text-5xl font-black text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-blue-400 mb-2">
                        <span data-count="10000" data-duration="2000">0</span>+
                    </div>
                    <p class="text-slate-300 font-semibold">{{ __('Active Users') }}</p>
                </div>

                <div class="text-center" data-aos="fade-up" data-aos-delay="200">
                    <div class="text-4xl md:text-5xl font-black text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-blue-400 mb-2">
                        <span data-count="50000" data-duration="2000">0</span>+
                    </div>
                    <p class="text-slate-300 font-semibold">{{ __('Successful Transactions') }}</p>
                </div>

                <div class="text-center" data-aos="fade-up" data-aos-delay="300">
                    <div class="text-4xl md:text-5xl font-black text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-blue-400 mb-2">
                        <span data-count="99" data-duration="2000">0</span>%
                    </div>
                    <p class="text-slate-300 font-semibold">{{ __('Satisfaction Rate') }}</p>
                </div>

                <div class="text-center" data-aos="fade-up" data-aos-delay="400">
                    <div class="text-4xl md:text-5xl font-black text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-blue-400 mb-2">
                        <span data-count="24" data-duration="2000">0</span>/7
                    </div>
                    <p class="text-slate-300 font-semibold">{{ __('Support Available') }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="py-16 md:py-24">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">
                    {{ __('Our Commitment') }}
                </h2>
                <p class="text-lg text-slate-300 max-w-2xl mx-auto">
                    {{ __('We are dedicated to providing the best possible experience for our users') }}
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="text-center" data-aos="fade-up" data-aos-delay="100">
                    <div class="bg-slate-800/50 rounded-2xl p-8 border border-slate-700/50">
                        <div class="text-5xl mb-4">🚀</div>
                        <h3 class="text-xl font-bold text-white mb-4">{{ __('Continuous Innovation') }}</h3>
                        <p class="text-slate-300">{{ __('We constantly improve our platform with new features and technologies to enhance user experience.') }}</p>
                    </div>
                </div>

                <div class="text-center" data-aos="fade-up" data-aos-delay="200">
                    <div class="bg-slate-800/50 rounded-2xl p-8 border border-slate-700/50">
                        <div class="text-5xl mb-4">🌍</div>
                        <h3 class="text-xl font-bold text-white mb-4">{{ __('Global Reach') }}</h3>
                        <p class="text-slate-300">{{ __('Serving users worldwide with localized support and multiple language options.') }}</p>
                    </div>
                </div>

                <div class="text-center" data-aos="fade-up" data-aos-delay="300">
                    <div class="bg-slate-800/50 rounded-2xl p-8 border border-slate-700/50">
                        <div class="text-5xl mb-4">💎</div>
                        <h3 class="text-xl font-bold text-white mb-4">{{ __('Premium Quality') }}</h3>
                        <p class="text-slate-300">{{ __('Only the highest quality digital accounts and services make it to our platform.') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 md:py-24 bg-gradient-to-r from-purple-500/20 to-blue-500/20">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-6" data-aos="fade-up">
                {{ __('Ready to Get Started?') }}
            </h2>
            <p class="text-lg text-slate-300 mb-8" data-aos="fade-up" data-aos-delay="200">
                {{ __('Join thousands of satisfied users who trust NetroHub for their digital account trading needs.') }}
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center" data-aos="fade-up" data-aos-delay="400">
                @auth
                    @if(auth()->user()->hasVerifiedEmail() && auth()->user()->is_verified && auth()->user()->phone_verified_at)
                        <a href="{{ route('sell.index') }}" class="btn text-white bg-gradient-to-r from-purple-500 to-blue-500 hover:from-purple-600 hover:to-blue-600 px-8 py-3 rounded-xl font-bold transition-all duration-300 shadow-lg hover:shadow-xl">
                            {{ __('Start Selling') }} 🚀
                        </a>
                    @else
                        <a href="{{ route('account.verification.checklist') }}" class="btn text-white bg-gradient-to-r from-purple-500 to-blue-500 hover:from-purple-600 hover:to-blue-600 px-8 py-3 rounded-xl font-bold transition-all duration-300 shadow-lg hover:shadow-xl">
                            {{ __('Get Verified') }} ✅
                        </a>
                    @endif
                @else
                    <a href="{{ route('register') }}" class="btn text-white bg-gradient-to-r from-purple-500 to-blue-500 hover:from-purple-600 hover:to-blue-600 px-8 py-3 rounded-xl font-bold transition-all duration-300 shadow-lg hover:shadow-xl">
                        {{ __('Create Account') }} 🎯
                    </a>
                @endauth
                <a href="{{ route('products.index') }}" class="btn text-slate-200 hover:text-white bg-slate-700/50 hover:bg-slate-600/50 px-8 py-3 rounded-xl font-bold transition-all duration-300">
                    {{ __('Browse Products') }} 📦
                </a>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="py-16 md:py-24">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-6" data-aos="fade-up">
                {{ __('Get in Touch') }}
            </h2>
            <p class="text-lg text-slate-300 mb-8" data-aos="fade-up" data-aos-delay="200">
                {{ __('Have questions or need support? We\'re here to help!') }}
            </p>
            <div class="grid md:grid-cols-3 gap-8">
                <div data-aos="fade-up" data-aos-delay="300">
                    <div class="bg-slate-800/50 rounded-2xl p-6 border border-slate-700/50">
                        <div class="text-4xl mb-4">📧</div>
                        <h3 class="text-lg font-bold text-white mb-2">{{ __('Email Support') }}</h3>
                        <p class="text-slate-400 text-sm mb-4">{{ __('Get help via email') }}</p>
                        <a href="mailto:support@netrohub.com" class="text-purple-400 hover:text-purple-300 transition-colors">
                            support@netrohub.com
                        </a>
                    </div>
                </div>

                <div data-aos="fade-up" data-aos-delay="400">
                    <div class="bg-slate-800/50 rounded-2xl p-6 border border-slate-700/50">
                        <div class="text-4xl mb-4">💬</div>
                        <h3 class="text-lg font-bold text-white mb-2">{{ __('Live Chat') }}</h3>
                        <p class="text-slate-400 text-sm mb-4">{{ __('Chat with our support team') }}</p>
                        <a href="#" class="text-purple-400 hover:text-purple-300 transition-colors">
                            {{ __('Start Chat') }}
                        </a>
                    </div>
                </div>

                <div data-aos="fade-up" data-aos-delay="500">
                    <div class="bg-slate-800/50 rounded-2xl p-6 border border-slate-700/50">
                        <div class="text-4xl mb-4">📚</div>
                        <h3 class="text-lg font-bold text-white mb-2">{{ __('Help Center') }}</h3>
                        <p class="text-slate-400 text-sm mb-4">{{ __('Browse our knowledge base') }}</p>
                        <a href="#" class="text-purple-400 hover:text-purple-300 transition-colors">
                            {{ __('View Articles') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

</x-layouts.stellar>
