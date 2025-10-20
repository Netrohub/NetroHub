<x-layouts.app>
    <x-slot name="title">{{ __('Phone Verification') }} - {{ config('app.name') }}</x-slot>

<section class="relative pt-32 pb-12">
<div class="py-8">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-white mb-2">Phone Verification</h1>
            <p class="text-muted-400">Verify your phone number for enhanced account security</p>
        </div>

        <div class="bg-dark-800/50 backdrop-blur-xl border border-gaming rounded-2xl p-8">
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-white mb-2">Verify Your Phone Number</h2>
                <p class="text-muted-400">
                    Phone verification adds an extra layer of security to your account. This is optional but recommended.
                </p>
            </div>

            @if($user->isPhoneVerified())
                <!-- Already Verified -->
                <div class="bg-green-900/20 border border-green-500/30 rounded-xl p-6">
                    <div class="flex items-center mb-4">
                        <svg class="w-6 h-6 text-green-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <h3 class="text-xl font-bold text-green-400">Phone Number Verified</h3>
                    </div>
                    <p class="text-muted-400 mb-4">
                        Your phone number <strong class="text-white">{{ $user->phone_number }}</strong> has been verified.
                    </p>
                    <p class="text-sm text-muted-400">
                        Verified on {{ $user->phone_verified_at->format('F j, Y \a\t g:i A') }}
                    </p>
                </div>
            @else
                <!-- Verification Form -->
                <div x-data="phoneVerification()" class="space-y-6">
                    <!-- Step 1: Enter Phone Number -->
                    <div x-show="step === 1" class="space-y-4">
                        <div>
                            <label for="phone_number" class="block text-sm font-medium text-white mb-2">
                                Phone Number <span class="text-red-400">*</span>
                            </label>
                            <input type="tel" 
                                   id="phone_number" 
                                   x-model="phoneNumber"
                                   class="w-full px-4 py-3 bg-dark-700/50 border border-gaming rounded-xl text-white placeholder-muted-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                   placeholder="Enter your phone number with country code"
                                   required>
                            <p class="text-xs text-muted-400 mt-1">Include country code (e.g., +966501234567)</p>
                        </div>

                        <button type="button" 
                                @click="sendCode()"
                                :disabled="sending || !phoneNumber"
                                class="w-full bg-primary-500 hover:bg-primary-600 disabled:bg-gray-600 disabled:cursor-not-allowed text-white px-6 py-3 rounded-xl font-semibold transition-colors duration-200 flex items-center justify-center">
                            <svg x-show="sending" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span x-text="sending ? 'Sending...' : 'Send Verification Code'"></span>
                        </button>
                    </div>

                    <!-- Step 2: Enter OTP Code -->
                    <div x-show="step === 2" class="space-y-4">
                        <div class="text-center">
                            <h3 class="text-lg font-semibold text-white mb-2">Enter Verification Code</h3>
                            <p class="text-muted-400">
                                We sent a 6-digit code to <strong class="text-white" x-text="phoneNumber"></strong>
                            </p>
                        </div>

                        <div>
                            <label for="otp_code" class="block text-sm font-medium text-white mb-2">
                                Verification Code <span class="text-red-400">*</span>
                            </label>
                            <input type="text" 
                                   id="otp_code" 
                                   x-model="otpCode"
                                   maxlength="6"
                                   class="w-full px-4 py-3 bg-dark-700/50 border border-gaming rounded-xl text-white placeholder-muted-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent text-center text-2xl tracking-widest"
                                   placeholder="000000"
                                   required>
                        </div>

                        <div class="flex space-x-4">
                            <button type="button" 
                                    @click="verifyCode()"
                                    :disabled="verifying || !otpCode || otpCode.length !== 6"
                                    class="flex-1 bg-primary-500 hover:bg-primary-600 disabled:bg-gray-600 disabled:cursor-not-allowed text-white px-6 py-3 rounded-xl font-semibold transition-colors duration-200 flex items-center justify-center">
                                <svg x-show="verifying" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span x-text="verifying ? 'Verifying...' : 'Verify Code'"></span>
                            </button>

                            <button type="button" 
                                    @click="resendCode()"
                                    :disabled="resending"
                                    class="px-4 py-3 border border-gaming rounded-xl text-white hover:bg-dark-700/50 transition-colors duration-200">
                                <span x-text="resending ? 'Sending...' : 'Resend'"></span>
                            </button>
                        </div>
                    </div>

                    <!-- Messages -->
                    <div x-show="message" class="mt-4">
                        <div :class="messageType === 'success' ? 'bg-green-900/20 border-green-500/30 text-green-400' : 'bg-red-900/20 border-red-500/30 text-red-400'" 
                             class="border rounded-xl p-4">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path x-show="messageType === 'success'" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    <path x-show="messageType === 'error'" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span x-text="message"></span>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Information Section -->
            <div class="mt-8 bg-dark-700/30 rounded-xl p-4">
                <h3 class="text-sm font-medium text-white mb-2">About Phone Verification</h3>
                <ul class="text-xs text-muted-400 space-y-1">
                    <li>• Phone verification is optional and independent of identity verification</li>
                    <li>• Adds an extra layer of security to your account</li>
                    <li>• Required for certain sensitive operations</li>
                    <li>• We never share your phone number with third parties</li>
                </ul>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function phoneVerification() {
    return {
        step: 1,
        phoneNumber: '',
        otpCode: '',
        sending: false,
        verifying: false,
        resending: false,
        message: '',
        messageType: '',

        async sendCode() {
            if (!this.phoneNumber) return;

            this.sending = true;
            this.message = '';

            try {
                const response = await fetch('{{ route("account.phone.send-code") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        phone_number: this.phoneNumber
                    })
                });

                const data = await response.json();

                if (data.success) {
                    this.step = 2;
                    this.message = data.message;
                    this.messageType = 'success';
                    
                    // Show OTP in development (remove in production)
                    if (data.otp) {
                        this.message += ' (Development: Code is ' + data.otp + ')';
                    }
                } else {
                    this.message = data.message;
                    this.messageType = 'error';
                }
            } catch (error) {
                this.message = 'An error occurred. Please try again.';
                this.messageType = 'error';
            } finally {
                this.sending = false;
            }
        },

        async verifyCode() {
            if (!this.otpCode || this.otpCode.length !== 6) return;

            this.verifying = true;
            this.message = '';

            try {
                const response = await fetch('{{ route("account.phone.verify-code") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        phone_number: this.phoneNumber,
                        otp_code: this.otpCode
                    })
                });

                const data = await response.json();

                if (data.success) {
                    this.message = data.message;
                    this.messageType = 'success';
                    
                    // Reload page after 2 seconds to show verified state
                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                } else {
                    this.message = data.message;
                    this.messageType = 'error';
                }
            } catch (error) {
                this.message = 'An error occurred. Please try again.';
                this.messageType = 'error';
            } finally {
                this.verifying = false;
            }
        },

        async resendCode() {
            this.resending = true;
            this.message = '';

            try {
                const response = await fetch('{{ route("account.phone.resend-code") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        phone_number: this.phoneNumber
                    })
                });

                const data = await response.json();

                if (data.success) {
                    this.message = data.message;
                    this.messageType = 'success';
                } else {
                    this.message = data.message;
                    this.messageType = 'error';
                }
            } catch (error) {
                this.message = 'An error occurred. Please try again.';
                this.messageType = 'error';
            } finally {
                this.resending = false;
            }
        }
    }
}
</script>
@endpush

</section>

</x-layouts.app>
