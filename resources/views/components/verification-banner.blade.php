@if(auth()->check() && !auth()->user()->isVerified())
    @php
        $latestKyc = auth()->user()->latestKycSubmission;
    @endphp
    <div class="bg-slate-900/95 backdrop-blur-md border-b border-orange-500/30 text-white py-3 px-4 relative z-20">
        <div class="max-w-7xl mx-auto flex flex-col lg:flex-row items-center justify-between gap-4">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-orange-500/20 border border-orange-500/30 rounded-xl flex items-center justify-center mr-4">
                    <span class="text-orange-400 text-xl">⚠️</span>
                </div>
                <div>
                    <h3 class="font-bold text-lg text-white">Verify Your Account to Start Selling</h3>
                    <p class="text-sm opacity-90">
                        @if($latestKyc && $latestKyc->isPending())
                            Your identity verification is under review. We'll notify you once it's approved.
                        @elseif($latestKyc && $latestKyc->isRejected())
                            Your identity verification was rejected. Please resubmit with corrected information.
                        @else
                            Complete your identity verification to unlock selling features on our platform.
                        @endif
                    </p>
                </div>
            </div>
            <div class="flex items-center gap-4 flex-wrap">
                @if(!$latestKyc || $latestKyc->isRejected())
                    <a href="{{ route('account.kyc.show') }}" 
                       class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2.5 rounded-lg font-semibold transition-all duration-200 flex items-center shadow-lg hover:shadow-xl transform hover:scale-105 border border-orange-400/50">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ $latestKyc && $latestKyc->isRejected() ? 'Resubmit Verification' : 'Verify Now' }}
                    </a>
                @elseif($latestKyc && $latestKyc->isPending())
                    <a href="{{ route('account.kyc.status') }}" 
                       class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-2.5 rounded-lg font-semibold transition-all duration-200 flex items-center shadow-lg hover:shadow-xl transform hover:scale-105 border border-yellow-400/50">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        View Status
                    </a>
                @endif
                <a href="{{ route('account.kyc.status') }}" 
                   class="bg-slate-800/50 hover:bg-slate-700/50 text-slate-300 hover:text-white transition-all duration-200 flex items-center text-sm px-4 py-2 rounded-lg border border-slate-600 hover:border-slate-500 font-medium">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Check Status
                </a>
            </div>
        </div>
    </div>
@endif
