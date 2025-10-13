@extends('layouts.app')

@section('title', 'Refund Policy - NetroHub')
@section('description', 'Learn about NetroHub\'s refund policy for digital products. Understand your rights and our procedures for refunds and disputes.')

@section('content')
<div class="min-h-screen relative overflow-hidden bg-dark-900 py-10 sm:py-12 md:py-16">
    <!-- Gaming Background Effects -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-1/4 left-1/4 w-64 h-64 sm:w-96 sm:h-96 bg-primary-500/5 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-1/4 right-1/4 w-64 h-64 sm:w-80 sm:h-80 bg-secondary-500/5 rounded-full blur-3xl animate-float animation-delay-2000"></div>
    </div>

    <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-8 sm:mb-10 md:mb-12">
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-black text-white mb-3 sm:mb-4">💰 Refund Policy</h1>
            <p class="text-muted-300 text-sm sm:text-base md:text-lg">Last updated: {{ now()->format('F d, Y') }}</p>
        </div>

        <!-- Content -->
        <x-ui.card variant="glass" class="prose prose-invert max-w-none">
            <div class="space-y-6 sm:space-y-8">
                
                <!-- Section 1 -->
                <section>
                    <h2 class="text-xl sm:text-2xl font-bold text-white mb-3 sm:mb-4 flex items-center">
                        <span class="w-7 h-7 sm:w-8 sm:h-8 bg-green-500 rounded-full flex items-center justify-center text-xs sm:text-sm font-bold mr-2 sm:mr-3">1</span>
                        Overview
                    </h2>
                    <div class="text-sm sm:text-base text-muted-300 space-y-3 sm:space-y-4 leading-relaxed">
                        <p>
                            At NetroHub, we strive to ensure customer satisfaction with every purchase. Due to the nature of digital products, all sales are generally final. However, we understand that issues may arise, and we're committed to resolving them fairly.
                        </p>
                        <p>
                            This Refund Policy explains the circumstances under which refunds may be issued and the process for requesting them.
                        </p>
                    </div>
                </section>

                <!-- Section 2 -->
                <section>
                    <h2 class="text-xl sm:text-2xl font-bold text-white mb-3 sm:mb-4 flex items-center">
                        <span class="w-7 h-7 sm:w-8 sm:h-8 bg-blue-500 rounded-full flex items-center justify-center text-xs sm:text-sm font-bold mr-2 sm:mr-3">2</span>
                        Refund Eligibility
                    </h2>
                    <div class="text-sm sm:text-base text-muted-300 space-y-3 sm:space-y-4 leading-relaxed">
                        <p class="font-semibold text-white">Refunds may be granted in the following situations:</p>
                        <ul class="list-disc list-inside space-y-2 ml-2 sm:ml-4">
                            <li>The product was not as described in the listing</li>
                            <li>The product codes/credentials were invalid or already used</li>
                            <li>The seller failed to deliver the product within the specified timeframe</li>
                            <li>Technical issues prevented access to purchased content</li>
                            <li>The product was fraudulent or violated our policies</li>
                        </ul>
                        <p class="font-semibold text-red-400 mt-4">Refunds will NOT be granted for:</p>
                        <ul class="list-disc list-inside space-y-2 ml-2 sm:ml-4">
                            <li>Change of mind after receiving valid product access</li>
                            <li>Buyer's remorse or discovering a better price elsewhere</li>
                            <li>Failure to read the product description carefully</li>
                            <li>Products that have been successfully accessed/used</li>
                            <li>Requests made after 72 hours of delivery</li>
                        </ul>
                    </div>
                </section>

                <!-- Section 3 -->
                <section>
                    <h2 class="text-xl sm:text-2xl font-bold text-white mb-3 sm:mb-4 flex items-center">
                        <span class="w-7 h-7 sm:w-8 sm:h-8 bg-purple-500 rounded-full flex items-center justify-center text-xs sm:text-sm font-bold mr-2 sm:mr-3">3</span>
                        Refund Request Process
                    </h2>
                    <div class="text-sm sm:text-base text-muted-300 space-y-3 sm:space-y-4 leading-relaxed">
                        <p class="font-semibold text-white">To request a refund:</p>
                        <ol class="list-decimal list-inside space-y-2 ml-2 sm:ml-4">
                            <li>Open a dispute from your Order History within 72 hours of delivery</li>
                            <li>Provide detailed explanation and evidence (screenshots, error messages, etc.)</li>
                            <li>Our moderation team will review your case within 24-48 hours</li>
                            <li>You'll receive a decision notification via email and platform notifications</li>
                            <li>If approved, refunds are processed within 5-10 business days</li>
                        </ol>
                    </div>
                </section>

                <!-- Section 4 -->
                <section>
                    <h2 class="text-xl sm:text-2xl font-bold text-white mb-3 sm:mb-4 flex items-center">
                        <span class="w-7 h-7 sm:w-8 sm:h-8 bg-orange-500 rounded-full flex items-center justify-center text-xs sm:text-sm font-bold mr-2 sm:mr-3">4</span>
                        Refund Methods
                    </h2>
                    <div class="text-sm sm:text-base text-muted-300 space-y-3 sm:space-y-4 leading-relaxed">
                        <p>
                            Approved refunds will be issued using the original payment method whenever possible:
                        </p>
                        <ul class="list-disc list-inside space-y-2 ml-2 sm:ml-4">
                            <li><strong>Credit/Debit Cards:</strong> Refunded to the original card (5-10 business days)</li>
                            <li><strong>PayPal:</strong> Refunded to your PayPal account (2-5 business days)</li>
                            <li><strong>Platform Wallet:</strong> Credited immediately to your NetroHub wallet</li>
                        </ul>
                    </div>
                </section>

                <!-- Section 5 -->
                <section>
                    <h2 class="text-xl sm:text-2xl font-bold text-white mb-3 sm:mb-4 flex items-center">
                        <span class="w-7 h-7 sm:w-8 sm:h-8 bg-red-500 rounded-full flex items-center justify-center text-xs sm:text-sm font-bold mr-2 sm:mr-3">5</span>
                        Dispute Resolution
                    </h2>
                    <div class="text-sm sm:text-base text-muted-300 space-y-3 sm:space-y-4 leading-relaxed">
                        <p>
                            We encourage buyers and sellers to communicate directly to resolve issues. However, if a resolution cannot be reached:
                        </p>
                        <ul class="list-disc list-inside space-y-2 ml-2 sm:ml-4">
                            <li>NetroHub's moderation team will mediate the dispute</li>
                            <li>Both parties must provide evidence to support their claims</li>
                            <li>Our decision is final and binding for both parties</li>
                            <li>Repeated fraudulent disputes may result in account suspension</li>
                        </ul>
                    </div>
                </section>

                <!-- Section 6 -->
                <section>
                    <h2 class="text-xl sm:text-2xl font-bold text-white mb-3 sm:mb-4 flex items-center">
                        <span class="w-7 h-7 sm:w-8 sm:h-8 bg-yellow-500 rounded-full flex items-center justify-center text-xs sm:text-sm font-bold mr-2 sm:mr-3">6</span>
                        Seller Protection
                    </h2>
                    <div class="text-sm sm:text-base text-muted-300 space-y-3 sm:space-y-4 leading-relaxed">
                        <p>
                            Sellers are protected against fraudulent refund requests when they can prove:
                        </p>
                        <ul class="list-disc list-inside space-y-2 ml-2 sm:ml-4">
                            <li>Valid product codes/credentials were provided</li>
                            <li>Product was delivered as described</li>
                            <li>Communication logs showing good faith efforts</li>
                            <li>Evidence that buyer successfully accessed the product</li>
                        </ul>
                    </div>
                </section>

                <!-- Section 7 -->
                <section>
                    <h2 class="text-xl sm:text-2xl font-bold text-white mb-3 sm:mb-4 flex items-center">
                        <span class="w-7 h-7 sm:w-8 sm:h-8 bg-indigo-500 rounded-full flex items-center justify-center text-xs sm:text-sm font-bold mr-2 sm:mr-3">7</span>
                        Contact Us
                    </h2>
                    <div class="text-sm sm:text-base text-muted-300 space-y-3 sm:space-y-4 leading-relaxed">
                        <p>
                            If you have questions about our Refund Policy or need assistance with a refund request, please contact us:
                        </p>
                        <ul class="list-none space-y-2 ml-2 sm:ml-4">
                            <li>📧 Email: support@netrohub.com</li>
                            <li>💬 Discord: <a href="{{ \App\Models\Setting::get('discord_url', 'https://discord.gg/your-server') }}" target="_blank" rel="noopener noreferrer" class="text-indigo-400 hover:text-indigo-300 underline">Join our community server</a></li>
                            <li>📝 Support Portal: Through your account dashboard</li>
                        </ul>
                    </div>
                </section>

                <!-- Footer Note -->
                <div class="mt-6 sm:mt-8 p-4 sm:p-6 bg-primary-500/10 border border-primary-500/30 rounded-lg sm:rounded-xl">
                    <p class="text-xs sm:text-sm text-primary-200 leading-relaxed">
                        <strong>Note:</strong> This Refund Policy is subject to change. We will notify users of any significant changes via email and platform notifications. Continued use of NetroHub after changes constitutes acceptance of the updated policy.
                    </p>
                </div>
            </div>
        </x-ui.card>

        <!-- Back Button -->
        <div class="mt-6 sm:mt-8 text-center">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-5 py-3 sm:px-6 sm:py-3 text-sm sm:text-base font-bold bg-dark-800/70 hover:bg-dark-700/70 text-white rounded-lg sm:rounded-xl transition-all duration-300 shadow-lg hover:shadow-gaming min-h-[44px]">
                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Home
            </a>
        </div>
    </div>
</div>
@endsection

