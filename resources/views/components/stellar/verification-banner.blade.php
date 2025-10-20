@props(['user'])

<!-- Verification Banner Component -->
@if($user && !$user->is_verified)
    <div class="bg-gradient-to-r from-yellow-500/10 to-orange-500/10 border border-yellow-500/30 rounded-2xl p-6 mb-8">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                </svg>
            </div>
            <div class="ml-4 flex-1">
                <h3 class="text-lg font-semibold text-yellow-300 mb-2">
                    {{ __('Account Verification Required') }}
                </h3>
                <p class="text-yellow-200/80 mb-4">
                    {{ __('Complete your account verification to access all features and increase your account security.') }}
                </p>
                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('account.verification-checklist') }}" class="inline-flex items-center px-4 py-2 bg-yellow-500/20 border border-yellow-500/50 rounded-lg text-yellow-300 hover:bg-yellow-500/30 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ __('Start Verification') }}
                    </a>
                    <a href="{{ route('account.phone-verification') }}" class="inline-flex items-center px-4 py-2 bg-primary/20 border border-primary/50 rounded-lg text-primary hover:bg-primary/30 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        {{ __('Verify Phone') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
@endif
