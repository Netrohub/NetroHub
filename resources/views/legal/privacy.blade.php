@extends('layouts.app')

@section('title', 'Privacy Policy - NetroHub')
@section('description', 'Learn how NetroHub protects your privacy and handles your personal data. Read our comprehensive privacy policy for our digital marketplace platform.')

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
            <h1 class="text-4xl font-black text-white mb-4">🔒 Privacy Policy</h1>
            <p class="text-muted-300 text-lg">Last updated: {{ now()->format('F d, Y') }}</p>
        </div>

        <!-- Content -->
        <x-ui.card variant="glass" class="prose prose-invert max-w-none">
            <div class="space-y-8">
                
                <!-- KYC Verification Notice -->
                <section>
                    <h2 class="text-2xl font-bold text-white mb-4 flex items-center">
                        <span class="w-8 h-8 bg-orange-500 rounded-full flex items-center justify-center text-sm font-bold mr-3">🔐</span>
                        KYC Verification & Identity Collection
                    </h2>
                    <div class="space-y-4">
                        <p class="text-muted-300">
                            <strong class="text-white">Purpose:</strong> We collect identity verification documents (KYC - Know Your Customer) to comply with financial regulations, prevent fraud, and ensure the security of our marketplace platform.
                        </p>
                        <p class="text-muted-300">
                            <strong class="text-white">Legal Basis:</strong> This data collection is required for sellers to use our platform and is conducted in accordance with Saudi PDPL (Personal Data Protection Law) and international anti-money laundering regulations.
                        </p>
                        <p class="text-muted-300">
                            <strong class="text-white">Data Collected:</strong>
                        </p>
                        <ul class="list-disc list-inside text-muted-300 space-y-2 ml-4">
                            <li>Full legal name and date of birth</li>
                            <li>Country of residence</li>
                            <li>Government-issued ID documents (passport, national ID, driver's license)</li>
                            <li>ID number and type</li>
                            <li>Document images (front and back when applicable)</li>
                        </ul>
                        <p class="text-muted-300">
                            <strong class="text-white">Security:</strong> All identity documents are encrypted and stored securely using industry-standard encryption. Access is restricted to authorized personnel only and is subject to strict audit trails.
                        </p>
                        <p class="text-muted-300">
                            <strong class="text-white">Retention:</strong> Identity verification data is retained for the duration of your account plus 7 years as required by financial regulations. You may request deletion after account closure, subject to legal requirements.
                        </p>
                        <p class="text-muted-300">
                            <strong class="text-white">Sharing:</strong> We do not sell or share your identity verification data with third parties, except as required by law or with your explicit consent.
                        </p>
                    </div>
                </section>

                <!-- Section 1 -->
                <section>
                    <h2 class="text-2xl font-bold text-white mb-4 flex items-center">
                        <span class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center text-sm font-bold mr-3">1</span>
                        Introduction
                    </h2>
                    <div class="text-muted-300 leading-relaxed">
                        <p>At NetroHub, we value your privacy and are committed to protecting your personal data. This policy explains how we collect, use, store, and protect your information when you use our platform.</p>
                    </div>
                </section>

                <!-- Section 2 -->
                <section>
                    <h2 class="text-2xl font-bold text-white mb-4 flex items-center">
                        <span class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center text-sm font-bold mr-3">2</span>
                        Information We Collect
                    </h2>
                    <div class="text-muted-300 leading-relaxed space-y-3">
                        <div>
                            <h3 class="text-lg font-semibold text-white mb-2">Personal Information:</h3>
                            <p>Name, email, phone number, and government ID (if required for verification).</p>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-white mb-2">Account Information:</h3>
                            <p>Login credentials, profile data, and payment details.</p>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-white mb-2">Transaction Information:</h3>
                            <p>Details related to purchases, sales, and withdrawals.</p>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-white mb-2">Device & Usage Data:</h3>
                            <p>IP address, browser type, and usage statistics.</p>
                        </div>
                    </div>
                </section>

                <!-- Section 3 -->
                <section>
                    <h2 class="text-2xl font-bold text-white mb-4 flex items-center">
                        <span class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center text-sm font-bold mr-3">3</span>
                        How We Use Your Information
                    </h2>
                    <div class="text-muted-300 leading-relaxed">
                        <p class="mb-3">We use the data we collect to:</p>
                        <ul class="space-y-2 ml-4">
                            <li>• Provide and improve our services.</li>
                            <li>• Secure accounts and prevent fraud.</li>
                            <li>• Process payments and payouts.</li>
                            <li>• Communicate updates, changes, or important notifications.</li>
                            <li>• Comply with legal obligations and regulatory requirements.</li>
                        </ul>
                    </div>
                </section>

                <!-- Section 4 -->
                <section>
                    <h2 class="text-2xl font-bold text-white mb-4 flex items-center">
                        <span class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center text-sm font-bold mr-3">4</span>
                        Data Security
                    </h2>
                    <div class="text-muted-300 leading-relaxed">
                        <p>We use industry-standard encryption, secure servers, and strict access controls to protect your data. While we strive for maximum security, no method of transmission over the internet is 100% secure. We encourage you to keep your login details confidential.</p>
                    </div>
                </section>

                <!-- Section 5 -->
                <section>
                    <h2 class="text-2xl font-bold text-white mb-4 flex items-center">
                        <span class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center text-sm font-bold mr-3">5</span>
                        Data Sharing
                    </h2>
                    <div class="text-muted-300 leading-relaxed">
                        <p class="mb-3">We may share your data in the following cases:</p>
                        <ul class="space-y-2 ml-4">
                            <li>• With payment processors to complete transactions.</li>
                            <li>• With legal authorities if required by law.</li>
                            <li>• With third-party service providers strictly for operational purposes (e.g., email delivery, analytics).</li>
                        </ul>
                    </div>
                </section>

                <!-- Section 6 -->
                <section>
                    <h2 class="text-2xl font-bold text-white mb-4 flex items-center">
                        <span class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center text-sm font-bold mr-3">6</span>
                        Your Rights
                    </h2>
                    <div class="text-muted-300 leading-relaxed">
                        <p class="mb-3">You have the right to:</p>
                        <ul class="space-y-2 ml-4">
                            <li>• Access and request a copy of your data.</li>
                            <li>• Correct inaccurate or outdated information.</li>
                            <li>• Request deletion of your data, where legally permissible.</li>
                            <li>• Withdraw consent for data processing at any time.</li>
                        </ul>
                    </div>
                </section>

                <!-- Section 7 -->
                <section>
                    <h2 class="text-2xl font-bold text-white mb-4 flex items-center">
                        <span class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center text-sm font-bold mr-3">7</span>
                        Cookies
                    </h2>
                    <div class="text-muted-300 leading-relaxed">
                        <p>We use cookies to enhance your user experience, remember your preferences, and improve platform functionality. You can disable cookies in your browser settings, but some features may not function correctly.</p>
                    </div>
                </section>

                <!-- Section 8 -->
                <section>
                    <h2 class="text-2xl font-bold text-white mb-4 flex items-center">
                        <span class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center text-sm font-bold mr-3">8</span>
                        Policy Updates
                    </h2>
                    <div class="text-muted-300 leading-relaxed">
                        <p>NetroHub may update this Privacy Policy periodically. Continued use of the platform after changes means you accept the new terms.</p>
                    </div>
                </section>

                <!-- Section 9 -->
                <section>
                    <h2 class="text-2xl font-bold text-white mb-4 flex items-center">
                        <span class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center text-sm font-bold mr-3">9</span>
                        Contact Us
                    </h2>
                    <div class="text-muted-300 leading-relaxed">
                        <p>If you have any questions about this policy or how we handle your data, please contact our support team through the "Help" section on the platform.</p>
                    </div>
                </section>

            </div>
        </x-ui.card>

        <!-- Footer Actions -->
        <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('terms') }}" class="inline-flex items-center px-6 py-3 bg-dark-800 border border-gaming text-muted-300 hover:text-white hover:bg-dark-700 rounded-xl transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Terms & Conditions
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
