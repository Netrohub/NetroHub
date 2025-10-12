@extends('layouts.app')

@section('title', 'Terms & Conditions - NetroHub')
@section('description', 'Read NetroHub\'s Terms & Conditions for our digital marketplace platform. Learn about our policies for buying and selling social media and gaming accounts.')

@section('content')
<div class="min-h-screen relative overflow-hidden bg-dark-900 py-10">
    <!-- Gaming Background Effects -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-primary-500/5 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-1/4 right-1/4 w-80 h-80 bg-secondary-500/5 rounded-full blur-3xl animate-float animation-delay-2000"></div>
    </div>

    <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-black text-white mb-4">Terms & Conditions</h1>
            <p class="text-muted-300 text-lg">Last updated: {{ now()->format('F d, Y') }}</p>
        </div>

        <!-- Content -->
        <x-ui.card variant="glass" class="prose prose-invert max-w-none">
            <div class="space-y-8">
                
                <!-- Section 1 -->
                <section>
                    <h2 class="text-2xl font-bold text-white mb-4 flex items-center">
                        <span class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center text-sm font-bold mr-3">1</span>
                        About NetroHub
                    </h2>
                    <div class="text-muted-300 leading-relaxed">
                        <p>NetroHub is a digital marketplace that allows users across the GCC to securely buy and sell premium social media accounts and gaming accounts. We act as a trusted intermediary between buyers and sellers, providing a safe environment, secure payment processing, and a transparent transaction process.</p>
                        <p class="mt-4">By using NetroHub, you agree to abide by the following terms and conditions.</p>
                    </div>
                </section>

                <!-- Section 2 -->
                <section>
                    <h2 class="text-2xl font-bold text-white mb-4 flex items-center">
                        <span class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center text-sm font-bold mr-3">2</span>
                        Account Listings
                    </h2>
                    <div class="text-muted-300 leading-relaxed space-y-3">
                        <p>• Sellers must only list accounts that they legally own. Listing accounts obtained illegally or without authorization is strictly prohibited.</p>
                        <p>• Each account may only be listed once. Duplicate listings of the same account will be removed.</p>
                        <p>• Accounts that are banned, suspended, or disabled by their original platform cannot be listed.</p>
                    </div>
                </section>

                <!-- Section 3 -->
                <section>
                    <h2 class="text-2xl font-bold text-white mb-4 flex items-center">
                        <span class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center text-sm font-bold mr-3">3</span>
                        Ownership and Responsibility
                    </h2>
                    <div class="text-muted-300 leading-relaxed space-y-3">
                        <p>• Sellers are fully responsible for the ownership, authenticity, and legality of the accounts they list.</p>
                        <p>• Any attempt to reclaim or recover a sold account is strictly prohibited and may lead to permanent suspension, legal action, and financial liability.</p>
                    </div>
                </section>

                <!-- Section 4 -->
                <section>
                    <h2 class="text-2xl font-bold text-white mb-4 flex items-center">
                        <span class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center text-sm font-bold mr-3">4</span>
                        Transactions and Payouts
                    </h2>
                    <div class="text-muted-300 leading-relaxed space-y-3">
                        <p>• Once a sale is completed and no dispute is raised within 12 hours, the seller's balance will be credited.</p>
                        <p>• Withdrawals are processed within 1 to 4 business days. Users are responsible for providing accurate payout details.</p>
                        <p>• NetroHub is not liable for any losses caused by incorrect withdrawal information.</p>
                    </div>
                </section>

                <!-- Section 5 -->
                <section>
                    <h2 class="text-2xl font-bold text-white mb-4 flex items-center">
                        <span class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center text-sm font-bold mr-3">5</span>
                        Disputes and Buyer Protection
                    </h2>
                    <div class="text-muted-300 leading-relaxed space-y-3">
                        <p>• Buyers may open a dispute within 12 hours of purchase. After this window, NetroHub will not mediate disputes.</p>
                        <p>• NetroHub's role is limited to dispute resolution within the platform. Any communication or agreements made outside of NetroHub are at the user's own risk.</p>
                    </div>
                </section>

                <!-- Section 6 -->
                <section>
                    <h2 class="text-2xl font-bold text-white mb-4 flex items-center">
                        <span class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center text-sm font-bold mr-3">6</span>
                        Platform Conduct
                    </h2>
                    <div class="text-muted-300 leading-relaxed space-y-3">
                        <p>• Abusive, harmful, or inappropriate language and behavior will result in permanent account suspension and potential balance confiscation.</p>
                        <p>• Users must not include external contact information or links in listings, descriptions, or messages to bypass the platform.</p>
                        <p>• Using NetroHub for currency exchange, money transfers, or any illegal activities is strictly prohibited.</p>
                    </div>
                </section>

                <!-- Section 7 -->
                <section>
                    <h2 class="text-2xl font-bold text-white mb-4 flex items-center">
                        <span class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center text-sm font-bold mr-3">7</span>
                        Account Usage
                    </h2>
                    <div class="text-muted-300 leading-relaxed space-y-3">
                        <p>• Each user is allowed to create and maintain one account only. Duplicate accounts will be permanently banned, and balances may be forfeited.</p>
                        <p>• Accounts cannot be transferred, shared, or sold outside of NetroHub.</p>
                    </div>
                </section>

                <!-- Section 8 -->
                <section>
                    <h2 class="text-2xl font-bold text-white mb-4 flex items-center">
                        <span class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center text-sm font-bold mr-3">8</span>
                        Refunds & Cancellations
                    </h2>
                    <div class="text-muted-300 leading-relaxed space-y-3">
                        <p>• All digital sales on NetroHub are final and non-refundable.</p>
                        <p>• Order cancellations are only possible with seller approval before the delivery is confirmed.</p>
                    </div>
                </section>

                <!-- Section 9 -->
                <section>
                    <h2 class="text-2xl font-bold text-white mb-4 flex items-center">
                        <span class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center text-sm font-bold mr-3">9</span>
                        Fees and Commissions
                    </h2>
                    <div class="text-muted-300 leading-relaxed space-y-3">
                        <p>• NetroHub charges a service fee ranging from 3% to 10% depending on the type of account and service.</p>
                        <p>• The platform reserves the right to update its fees, commissions, or payout policies at any time without prior notice.</p>
                    </div>
                </section>

                <!-- Section 10 -->
                <section>
                    <h2 class="text-2xl font-bold text-white mb-4 flex items-center">
                        <span class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center text-sm font-bold mr-3">10</span>
                        Platform Rights
                    </h2>
                    <div class="text-muted-300 leading-relaxed space-y-3">
                        <p>• NetroHub reserves the right to refuse, remove, or reject any listing without explanation.</p>
                        <p>• In cases of fraud, violation of local laws, or breach of terms, NetroHub may permanently suspend accounts and confiscate any remaining balance.</p>
                        <p>• The platform also reserves the right to request additional verification documents for compliance and security purposes.</p>
                    </div>
                </section>

                <!-- Section 11 -->
                <section>
                    <h2 class="text-2xl font-bold text-white mb-4 flex items-center">
                        <span class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center text-sm font-bold mr-3">11</span>
                        Acceptance of Terms
                    </h2>
                    <div class="text-muted-300 leading-relaxed">
                        <p>By continuing to use NetroHub after any changes to these Terms & Conditions, you automatically accept the updated terms. If you do not agree, you must stop using the platform immediately.</p>
                    </div>
                </section>

            </div>
        </x-ui.card>

        <!-- Footer Actions -->
        <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('privacy') }}" class="inline-flex items-center px-6 py-3 bg-dark-800 border border-gaming text-muted-300 hover:text-white hover:bg-dark-700 rounded-xl transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
                Privacy Policy
            </a>
            <a href="{{ route('home') }}" class="inline-flex items-center px-6 py-3 bg-gaming-gradient text-white rounded-xl hover:shadow-gaming transition-all">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Back to Home
            </a>
        </div>
    </div>
</div>
@endsection
