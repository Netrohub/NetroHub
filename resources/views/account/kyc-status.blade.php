<x-layouts.app>
    <x-slot name="title">{{ __('KYC Status (OLD)') }} - {{ config('app.name') }}</x-slot>

<section class="relative pt-32 pb-12">
<div class="py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-white mb-2">Identity Verification Status</h1>
            <p class="text-muted-400">Track your verification submissions and status</p>
        </div>

        @if(session('success'))
            <div class="bg-green-900/20 border border-green-500/30 rounded-xl p-4 mb-6">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-green-400">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <!-- Current Status -->
        <div class="bg-dark-800/50 backdrop-blur-xl border border-gaming rounded-2xl p-6 mb-8">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-white">Current Verification Status</h2>
                {!! $user->getVerificationStatusBadge() !!}
            </div>
            
            @if($user->isVerified())
                <div class="bg-green-900/20 border border-green-500/30 rounded-lg p-4">
                    <div class="flex items-center mb-2">
                        <svg class="w-5 h-5 text-green-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-green-400 font-semibold">Account Verified</span>
                    </div>
                    <p class="text-muted-400">
                        Your identity has been verified. You can now list products and start selling on NXO.
                    </p>
                </div>
            @else
                <div class="bg-yellow-900/20 border border-yellow-500/30 rounded-lg p-4">
                    <div class="flex items-center mb-2">
                        <svg class="w-5 h-5 text-yellow-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-yellow-400 font-semibold">Verification Required</span>
                    </div>
                    <p class="text-muted-400 mb-3">
                        You need to verify your identity before you can start selling on NXO.
                    </p>
                    <a href="{{ route('account.kyc.show') }}" 
                       class="inline-flex items-center px-4 py-2 bg-primary-500 hover:bg-primary-600 text-white rounded-lg font-semibold transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ __('Start Verification') }}
                    </a>
                </div>
            @endif
        </div>

        <!-- Submission History -->
        @if($submissions->count() > 0)
            <div class="bg-dark-800/50 backdrop-blur-xl border border-gaming rounded-2xl p-6">
                <h2 class="text-xl font-bold text-white mb-6">Verification History</h2>
                
                <div class="space-y-4">
                    @foreach($submissions as $submission)
                        <div class="bg-dark-700/30 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center space-x-3">
                                    <h3 class="font-semibold text-white">Submission #{{ $submission->id }}</h3>
                                    {!! $submission->getStatusBadge() !!}
                                </div>
                                <span class="text-sm text-muted-400">
                                    {{ $submission->created_at->format('M j, Y \a\t g:i A') }}
                                </span>
                            </div>
                            
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                <div>
                                    <span class="text-muted-400">Country:</span>
                                    <span class="text-white ml-1">{{ strtoupper($submission->country_code) }}</span>
                                </div>
                                <div>
                                    <span class="text-muted-400">ID Type:</span>
                                    <span class="text-white ml-1">{{ ucfirst(str_replace('_', ' ', $submission->id_type)) }}</span>
                                </div>
                                <div>
                                    <span class="text-muted-400">Name:</span>
                                    <span class="text-white ml-1">{{ $submission->full_name }}</span>
                                </div>
                                <div>
                                    <span class="text-muted-400">DOB:</span>
                                    <span class="text-white ml-1">{{ $submission->dob->format('M j, Y') }}</span>
                                </div>
                            </div>
                            
                            @if($submission->isRejected() && $submission->notes)
                                <div class="mt-3 p-3 bg-red-900/20 border border-red-500/30 rounded-lg">
                                    <h4 class="text-red-400 font-medium mb-1">Rejection Reason:</h4>
                                    <p class="text-muted-400 text-sm">{{ $submission->notes }}</p>
                                </div>
                            @endif
                            
                            @if($submission->reviewed_at)
                                <div class="mt-3 text-xs text-muted-400">
                                    Reviewed by {{ $submission->reviewer->name ?? 'Admin' }} on {{ $submission->reviewed_at->format('M j, Y \a\t g:i A') }}
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Help Section -->
        <div class="mt-8 bg-dark-800/30 rounded-xl p-6">
            <h3 class="text-lg font-semibold text-white mb-3">Need Help?</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-muted-400">
                <div>
                    <h4 class="font-medium text-white mb-1">{{ __('Document Requirements') }}</h4>
                    <p>{{ __('Ensure your ID document is clear, readable, and not expired. Accepted formats include national ID, passport, or driver\'s license.') }}</p>
                </div>
                <div>
                    <h4 class="font-medium text-white mb-1">{{ __('Processing Time') }}</h4>
                    <p>{{ __('Verification typically takes 24-48 hours. You\'ll receive an email notification once your verification is processed.') }}</p>
                </div>
                <div>
                    <h4 class="font-medium text-white mb-1">{{ __('Rejected Submissions') }}</h4>
                    <p>{{ __('If your submission is rejected, review the feedback and resubmit with corrected information.') }}</p>
                </div>
                <div>
                    <h4 class="font-medium text-white mb-1">{{ __('Contact Support') }}</h4>
                    <p>{{ __('If you have questions about the verification process, please contact our support team.') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
</section>

</x-layouts.app>
