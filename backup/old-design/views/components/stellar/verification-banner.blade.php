@props(['user'])

@php
    $latestSubmission = $user->latestKycSubmission;
@endphp

@if(!$user->is_verified)
    @if($latestSubmission && $latestSubmission->isPending())
        <!-- Pending Verification Banner -->
        <div class="bg-gradient-to-r from-yellow-500/10 to-yellow-500/5 border border-yellow-500/20 rounded-2xl p-6 mb-8" data-aos="fade-down">
            <div class="flex items-start">
                <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-gradient-to-b from-yellow-500/20 to-yellow-500/10 mr-4 flex-shrink-0">
                    <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-bold text-yellow-400 mb-2">{{ __('Verification In Progress') }}</h3>
                    <p class="text-slate-300 text-sm mb-4">
                        {{ __('Your identity verification is being reviewed. You\'ll be notified once it\'s complete (usually within 24-48 hours).') }}
                    </p>
                    <div class="flex items-center text-sm text-slate-400">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        {{ __('Submitted') }}: {{ $latestSubmission->created_at->format('M j, Y g:i A') }}
                    </div>
                </div>
            </div>
        </div>
    @elseif($latestSubmission && $latestSubmission->isRejected())
        <!-- Rejected Verification Banner -->
        <div class="bg-gradient-to-r from-red-500/10 to-red-500/5 border border-red-500/20 rounded-2xl p-6 mb-8" data-aos="fade-down">
            <div class="flex items-start">
                <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-gradient-to-b from-red-500/20 to-red-500/10 mr-4 flex-shrink-0">
                    <svg class="w-6 h-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-bold text-red-400 mb-2">{{ __('Verification Needed') }}</h3>
                    <p class="text-slate-300 text-sm mb-4">
                        {{ __('Your previous verification was declined. Please review the feedback and submit a new verification.') }}
                    </p>
                    @if($latestSubmission->notes)
                        <div class="bg-slate-900/50 rounded-lg p-3 mb-4">
                            <p class="text-sm text-slate-400"><strong class="text-slate-300">{{ __('Feedback') }}:</strong> {{ $latestSubmission->notes }}</p>
                        </div>
                    @endif
                    <a href="{{ route('account.verification.checklist') }}" 
                       class="inline-flex items-center text-sm font-medium text-red-400 hover:text-red-300 transition-colors">
                        {{ __('Resubmit Verification') }}
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    @else
        <!-- Not Verified Banner -->
        <div class="bg-gradient-to-r from-purple-500/10 to-purple-500/5 border border-purple-500/20 rounded-2xl p-6 mb-8" data-aos="fade-down">
            <div class="flex items-start">
                <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-gradient-to-b from-purple-500/20 to-purple-500/10 mr-4 flex-shrink-0">
                    <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-bold text-slate-200 mb-2">{{ __('Verify Your Identity') }}</h3>
                    <p class="text-slate-300 text-sm mb-4">
                        {{ __('Complete identity verification to unlock selling features and build trust with buyers.') }}
                    </p>
                    <a href="{{ route('account.verification.checklist') }}" 
                       class="btn-sm text-slate-900 bg-linear-to-r from-white/80 via-white to-white/80 hover:bg-white transition duration-150 ease-in-out group">
                        {{ __('Start Verification') }}
                        <span class="tracking-normal text-purple-500 group-hover:translate-x-0.5 transition-transform duration-150 ease-in-out ml-1">-&gt;</span>
                    </a>
                </div>
            </div>
        </div>
    @endif
@endif

