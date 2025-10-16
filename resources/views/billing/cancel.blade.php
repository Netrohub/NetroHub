<x-layouts.stellar>
    <x-slot name="title">{{ __('Subscription Cancelled') }} - {{ config('app.name') }}</x-slot>

<section class="relative pt-32 pb-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="max-w-md mx-auto bg-slate-800 border border-slate-700 rounded-2xl p-8 text-center">
            <div class="mb-6">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-slate-700/50 mb-4">
                    <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            
            <h1 class="text-3xl font-bold text-slate-200 mb-4">{{ __('Subscription Cancelled') }}</h1>
            <p class="text-slate-400 mb-8">
                {{ __('You cancelled the checkout process. No charges were made.') }}
            </p>
            
            <div class="space-y-3">
                <a href="{{ route('pricing.index') }}" class="btn text-slate-900 bg-gradient-to-r from-white/80 via-white to-white/80 hover:bg-white w-full">
                    {{ __('View Plans Again') }}
                </a>
                <a href="{{ route('home') }}" class="btn text-slate-300 bg-slate-700 hover:bg-slate-600 border border-slate-600 w-full">
                    {{ __('Go to Homepage') }}
                </a>
            </div>
        </div>
    </div>
</section>

</x-layouts.stellar>

