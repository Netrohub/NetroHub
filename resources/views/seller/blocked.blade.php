<x-layouts.app>
    <x-slot name="title">{{ __('Account Blocked') }} - {{ config('app.name') }}</x-slot>

<section class="relative pt-32 pb-12">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="bg-slate-800 border border-slate-700 rounded-2xl p-8 text-center">
            <div class="text-6xl mb-4">🚫</div>
            <h1 class="text-3xl font-bold text-slate-200 mb-4">{{ __('Seller Account Blocked') }}</h1>
            <p class="text-slate-400 mb-6">
                {{ __('Your seller account has been temporarily blocked by our administrators.') }}
            </p>
            <p class="text-slate-400 mb-8">
                {{ __('If you believe this is an error, please contact our support team.') }}
            </p>
            <a href="{{ route('home') }}" class="btn text-slate-900 bg-gradient-to-r from-white/80 via-white to-white/80 hover:bg-white">
                {{ __('Return to Home') }}
            </a>
        </div>
    </div>
</section>

</x-layouts.app>
