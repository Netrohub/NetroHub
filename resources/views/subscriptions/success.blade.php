<x-layouts.app>
    <x-slot name="title">{{ __('Subscription Activated') }} - {{ config('app.name') }}</x-slot>

<section class="relative pt-32 pb-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="max-w-md mx-auto bg-slate-800 border border-slate-700 rounded-2xl p-8 text-center">
            <div class="mb-6">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-green-500/20 mb-4">
                    <svg class="w-10 h-10 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
            </div>
            
            <h1 class="text-3xl font-bold text-slate-200 mb-4">{{ __('Subscription Activated!') }}</h1>
            <p class="text-slate-400 mb-8">
                {{ __('Your subscription has been successfully activated. Welcome to your new plan!') }}
            </p>
            
            <div class="space-y-3">
                <a href="{{ route('account.billing') }}" class="btn text-slate-900 bg-gradient-to-r from-white/80 via-white to-white/80 hover:bg-white w-full">
                    {{ __('View Billing Details') }}
                </a>
                <a href="{{ route('home') }}" class="btn text-slate-300 bg-slate-700 hover:bg-slate-600 border border-slate-600 w-full">
                    {{ __('Go to Homepage') }}
                </a>
            </div>
        </div>
    </div>
</section>

</x-layouts.app>
