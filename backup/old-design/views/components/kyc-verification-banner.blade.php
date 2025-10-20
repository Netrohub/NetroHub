@if(auth()->check() && auth()->user()->seller && !auth()->user()->seller->isKycVerified())
    <div class="bg-gradient-to-r from-orange-600 to-red-600 text-white py-4 px-4 relative z-40">
        <div class="max-w-7xl mx-auto flex flex-col lg:flex-row items-center justify-between gap-4">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center mr-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-lg">⚠️ Verify Your Account to Start Selling</h3>
                    <p class="text-sm opacity-90">
                        @if(auth()->user()->seller->isKycPending())
                            Your KYC verification is under review. We'll notify you once it's approved.
                        @elseif(auth()->user()->seller->isKycRejected())
                            Your KYC verification was rejected. Please resubmit with corrected information.
                        @else
                            Complete your identity verification to unlock selling features on our platform.
                        @endif
                    </p>
                </div>
            </div>
            <div class="flex items-center gap-4 flex-wrap">
                @if(auth()->user()->seller->isKycRejected() || !auth()->user()->seller->kyc_submitted_at)
                    <a href="{{ route('kyc.verification.show') }}" 
                       class="bg-white text-black hover:bg-gray-100 hover:text-gray-900 px-8 py-3 rounded-xl font-black transition-all duration-200 flex items-center shadow-2xl hover:shadow-white/30 transform hover:scale-105 border-2 border-gray-300 hover:border-gray-400 ring-2 ring-white/20 hover:ring-white/30">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ auth()->user()->seller->isKycRejected() ? 'Resubmit Verification' : 'Verify Now' }}
                    </a>
                @elseif(auth()->user()->seller->isKycPending())
                    <a href="{{ route('kyc.status') }}" 
                       class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-3 rounded-xl font-bold transition-all duration-200 flex items-center shadow-lg hover:shadow-xl transform hover:scale-105">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        View Status
                    </a>
                @endif
                <a href="{{ route('kyc.status') }}" 
                   class="bg-white/20 hover:bg-white/30 text-white hover:text-white transition-all duration-200 flex items-center text-sm px-6 py-3 rounded-lg border-2 border-white/30 hover:border-white/50 font-semibold">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Check Status
                </a>
            </div>
        </div>
    </div>
@endif
