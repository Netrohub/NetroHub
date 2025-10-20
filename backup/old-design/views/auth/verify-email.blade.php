<x-layouts.stellar-auth>
    <x-slot name="title">{{ __('Verify Email') }} - {{ config('app.name') }}</x-slot>

<section class="relative">
    <!-- Illustration -->
    <div class="md:block absolute left-1/2 -translate-x-1/2 -mt-36 blur-2xl opacity-70 pointer-events-none -z-10" aria-hidden="true">
        <img src="{{ asset('stellar-assets/images/auth-illustration.svg') }}" class="max-w-none" width="1440" height="450" alt="Page Illustration">
    </div>

    <div class="relative max-w-6xl mx-auto px-4 sm:px-6">
        <div class="pt-24 pb-12 md:pt-32 md:pb-16">

            <!-- Page header -->
            <div class="max-w-3xl mx-auto text-center pb-12">
                <!-- Logo -->
                <div class="mb-5">
                    <a class="inline-flex" href="{{ route('home') }}">
                        <div class="relative flex items-center justify-center w-16 h-16 border border-transparent rounded-2xl shadow-2xl [background:linear-gradient(var(--color-slate-900),var(--color-slate-900))_padding-box,conic-gradient(var(--color-slate-400),var(--color-slate-700)_25%,var(--color-slate-700)_75%,var(--color-slate-400)_100%)_border-box] before:absolute before:inset-0 before:bg-slate-800/30 before:rounded-2xl">
                            <svg class="w-8 h-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </a>
                </div>
                <!-- Page title -->
                <h1 class="h2 bg-clip-text text-transparent bg-linear-to-r from-slate-200/60 via-slate-200 to-slate-200/60">{{ __('Verify Your Email') }}</h1>
            </div>
            
            <!-- Form -->
            <div class="max-w-sm mx-auto">
                <!-- Message -->
                <p class="text-slate-300 text-center mb-6">
                    {{ __('Thanks for signing up! Before getting started, please verify your email address by clicking the link we sent to:') }}
                </p>

                <div class="bg-slate-800 border border-slate-700 rounded-xl p-4 mb-6 text-center">
                    <p class="text-slate-200 font-medium break-all">
                        {{ auth()->user()->email }}
                    </p>
                </div>

                @if (session('status') == 'verification-link-sent')
                    <div class="bg-green-500/10 border border-green-500/50 text-green-300 px-4 py-3 rounded-xl mb-6">
                        <p class="text-sm">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    </div>
                @endif

                <!-- Resend Button -->
                <form method="POST" action="{{ route('verification.send') }}" class="mb-4">
                    @csrf
                    <button type="submit" class="btn text-slate-900 bg-gradient-to-r from-white/80 via-white to-white/80 hover:bg-white w-full">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        {{ __('Resend Verification Email') }}
                    </button>
                </form>

                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn text-slate-300 bg-slate-800 hover:bg-slate-700 border border-slate-700 w-full">
                        {{ __('Logout') }}
                    </button>
                </form>

                <!-- Help Text -->
                <p class="text-xs text-slate-400 text-center mt-6">
                    {{ __("Didn't receive the email? Check your spam folder or click resend above.") }}
                </p>
            </div>

        </div>
    </div>
</section>

</x-layouts.stellar-auth>


