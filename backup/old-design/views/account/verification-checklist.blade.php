<x-layouts.stellar>
    <x-slot name="title">{{ __('Complete Verification') }} - {{ config('app.name') }}</x-slot>

    <section class="relative pt-32 pb-16">
        <div class="max-w-3xl mx-auto px-4 sm:px-6">
            <div class="text-center mb-10">
                <h1 class="h2 bg-clip-text text-transparent bg-gradient-to-r from-slate-200/60 via-slate-200 to-slate-200/60">{{ __('Before you can sell, complete these steps') }}</h1>
                <p class="text-slate-400 mt-2">{{ __('Verify your account to unlock selling features') }}</p>
            </div>

            <div class="space-y-4">
                @php($user = auth()->user())

                <!-- Phone -->
                <div class="flex items-center justify-between bg-slate-800/60 border border-slate-700/50 rounded-2xl p-5">
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-xl bg-purple-500/20 flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h2l3 7-1.5 3A2 2 0 008 17h8m0 0a2 2 0 002-2V7a2 2 0 00-2-2h-6"/></svg>
                        </div>
                        <div>
                            <p class="font-semibold text-slate-100">{{ __('Verify Phone Number') }}</p>
                            <p class="text-sm text-slate-400">{{ __('Secure your account and enable selling') }}</p>
                        </div>
                    </div>
                    @if($user && $user->isPhoneVerified())
                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-500/20 text-green-300">{{ __('Completed') }}</span>
                    @else
                        <a href="{{ route('account.phone.show') }}" class="btn btn-sm text-white bg-purple-600 hover:bg-purple-700">{{ __('Verify') }}</a>
                    @endif
                </div>

                <!-- Email -->
                <div class="flex items-center justify-between bg-slate-800/60 border border-slate-700/50 rounded-2xl p-5">
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-xl bg-indigo-500/20 flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0z"/></svg>
                        </div>
                        <div>
                            <p class="font-semibold text-slate-100">{{ __('Verify Email') }}</p>
                            <p class="text-sm text-slate-400">{{ __('Confirm your email address') }}</p>
                        </div>
                    </div>
                    @if($user && $user->hasVerifiedEmail())
                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-500/20 text-green-300">{{ __('Completed') }}</span>
                    @else
                        <a href="{{ route('verification.notice') }}" class="btn btn-sm text-white bg-indigo-600 hover:bg-indigo-700">{{ __('Verify') }}</a>
                    @endif
                </div>

                <!-- Identity -->
                <div class="flex items-center justify-between bg-slate-800/60 border border-slate-700/50 rounded-2xl p-5">
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-xl bg-emerald-500/20 flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <div>
                            <p class="font-semibold text-slate-100">{{ __('Verify Identity (KYC)') }}</p>
                            <p class="text-sm text-slate-400">{{ __('Government ID verification required to sell') }}</p>
                        </div>
                    </div>
                    @php($kycVerified = auth()->user()?->seller?->isKycVerified())
                    @if($kycVerified)
                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-500/20 text-green-300">{{ __('Completed') }}</span>
                    @else
                        <a href="{{ route('account.verification.checklist') }}" class="btn btn-sm text-white bg-emerald-600 hover:bg-emerald-700">{{ __('Verify') }}</a>
                    @endif
                </div>
            </div>

            <div class="text-center mt-10">
                @if($user && $user->isPhoneVerified() && $user->hasVerifiedEmail() && $kycVerified)
                    <a href="{{ route('sell.index') }}" class="btn text-slate-900 bg-white hover:bg-white/90">{{ __('All set — Start Selling') }}</a>
                @else
                    <span class="text-slate-400 text-sm">{{ __('Complete all steps to unlock selling features') }}</span>
                @endif
            </div>
        </div>
    </section>
</x-layouts.stellar>


