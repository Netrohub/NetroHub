@extends('layouts.app')

@section('title', __('Verify Email') . ' - NetroHub')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 sm:px-6 lg:px-8 py-12">
    <div class="max-w-md w-full">
        <!-- Card -->
        <div class="card">
            <!-- Icon -->
            <div class="flex justify-center mb-6">
                <div class="w-16 h-16 sm:w-20 sm:h-20 bg-primary-500/20 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 sm:w-10 sm:h-10 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>

            <!-- Title -->
            <h2 class="text-2xl sm:text-3xl font-black text-white text-center mb-4">
                {{ __('Verify Your Email') }}
            </h2>

            <!-- Message -->
            <p class="text-sm sm:text-base text-muted-300 text-center mb-6 leading-relaxed">
                {{ __('Thanks for signing up! Before getting started, please verify your email address by clicking the link we sent to:') }}
            </p>

            <div class="bg-dark-700/50 rounded-lg p-3 sm:p-4 mb-6 text-center">
                <p class="text-sm sm:text-base text-white font-semibold break-all">
                    {{ auth()->user()->email }}
                </p>
            </div>

            @if (session('status') == 'verification-link-sent')
                <x-ui.alert type="success" class="mb-6">
                    <p class="text-sm">
                        {{ __('A new verification link has been sent to your email address.') }}
                    </p>
                </x-ui.alert>
            @endif

            <!-- Resend Button -->
            <form method="POST" action="{{ route('verification.send') }}" class="mb-4">
                @csrf
                <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-5 py-3 text-sm sm:text-base font-bold bg-gaming-gradient text-white rounded-xl transition-all duration-300 shadow-gaming hover:shadow-gaming-lg min-h-[44px]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    {{ __('Resend Verification Email') }}
                </button>
            </form>

            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full px-5 py-3 text-sm font-medium text-muted-300 hover:text-white bg-dark-700/50 hover:bg-dark-700/70 rounded-xl transition-all duration-300 min-h-[44px]">
                    {{ __('Logout') }}
                </button>
            </form>

            <!-- Help Text -->
            <p class="text-xs text-muted-400 text-center mt-6">
                {{ __("Didn't receive the email? Check your spam folder or click resend above.") }}
            </p>
        </div>
    </div>
</div>
@endsection


