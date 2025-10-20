@props(['user'])

@if($user->is_verified)
    <!-- Verified Badge -->
    <div {{ $attributes->merge(['class' => 'inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-gradient-to-r from-green-500/20 to-green-500/10 border border-green-500/30 text-green-400']) }}>
        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
        </svg>
        {{ __('Verified') }}
    </div>
@else
    @php
        $latestSubmission = $user->latestKycSubmission;
    @endphp
    
    @if($latestSubmission && $latestSubmission->isPending())
        <!-- Pending Badge -->
        <div {{ $attributes->merge(['class' => 'inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-gradient-to-r from-yellow-500/20 to-yellow-500/10 border border-yellow-500/30 text-yellow-400']) }}>
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ __('Pending') }}
        </div>
    @else
        <!-- Not Verified Badge -->
        <div {{ $attributes->merge(['class' => 'inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-gradient-to-r from-slate-700/50 to-slate-700/30 border border-slate-600/30 text-slate-400']) }}>
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
            {{ __('Not Verified') }}
        </div>
    @endif
@endif

