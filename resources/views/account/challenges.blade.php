@extends('layouts.app')

@section('content')
<div class="min-h-screen relative overflow-hidden bg-dark-900 flex items-center justify-center py-10">
    <!-- Gaming Background Effects -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-primary-500/5 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-1/4 right-1/4 w-80 h-80 bg-secondary-500/5 rounded-full blur-3xl animate-float animation-delay-2000"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-gaming-gradient opacity-5 rounded-full blur-3xl"></div>
    </div>

    <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <!-- Animated Icon -->
        <div class="mb-8 animate-float">
            <div class="w-32 h-32 bg-gaming-gradient rounded-3xl mx-auto flex items-center justify-center shadow-gaming-lg mb-6">
                <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                </svg>
            </div>
        </div>

        <!-- Title -->
        <h1 class="text-5xl md:text-6xl lg:text-7xl font-black text-white mb-6 leading-tight">
            <span class="bg-gaming-gradient bg-clip-text text-transparent">Challenges</span>
        </h1>

        <!-- Subtitle -->
        <p class="text-xl md:text-2xl text-muted-300 mb-4 max-w-2xl mx-auto">
            Coming Soon
        </p>

        <p class="text-base md:text-lg text-muted-400 mb-12 max-w-xl mx-auto">
            We're cooking something special! Complete challenges, earn rewards, and unlock exclusive perks.
        </p>

        <!-- Features Preview -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12 max-w-3xl mx-auto">
            <x-ui.card variant="glass" :hover="false" class="text-center">
                <div class="w-12 h-12 bg-primary-500/20 rounded-xl mx-auto mb-4 flex items-center justify-center">
                    <svg class="w-6 h-6 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                    </svg>
                </div>
                <h3 class="font-bold text-white mb-2">Daily Challenges</h3>
                <p class="text-sm text-muted-400">Complete tasks and earn XP</p>
            </x-ui.card>

            <x-ui.card variant="glass" :hover="false" class="text-center">
                <div class="w-12 h-12 bg-secondary-500/20 rounded-xl mx-auto mb-4 flex items-center justify-center">
                    <svg class="w-6 h-6 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="font-bold text-white mb-2">Exclusive Rewards</h3>
                <p class="text-sm text-muted-400">Unlock badges and bonuses</p>
            </x-ui.card>

            <x-ui.card variant="glass" :hover="false" class="text-center">
                <div class="w-12 h-12 bg-yellow-500/20 rounded-xl mx-auto mb-4 flex items-center justify-center">
                    <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <h3 class="font-bold text-white mb-2">Level Up</h3>
                <p class="text-sm text-muted-400">Progress through ranks</p>
            </x-ui.card>
        </div>

        <!-- CTA Buttons -->
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ route('account.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gaming-gradient text-white rounded-xl font-bold hover:shadow-gaming-lg transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Account
            </a>

            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-dark-700/50 border border-gaming text-white rounded-xl font-semibold hover:bg-dark-700 transition-all">
                Browse Products
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>
            </a>
        </div>

        <!-- Coming Soon Badge -->
        <div class="mt-12 inline-flex items-center gap-2 px-4 py-2 bg-primary-500/10 border border-primary-500/30 rounded-full text-primary-400 text-sm">
            <svg class="w-4 h-4 animate-pulse" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
            </svg>
            <span>Feature launching Q2 2025</span>
        </div>
    </div>
</div>
@endsection

