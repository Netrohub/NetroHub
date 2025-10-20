<x-layouts.stellar-auth>
    <x-slot name="title">{{ __('Verify Code') }} - {{ config('app.name') }}</x-slot>

<section class="relative">
<div class="min-h-screen relative overflow-hidden flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <!-- Gaming Background Effects -->
    <div class="absolute inset-0 bg-dark-900">
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-primary-500/20 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-1/4 right-1/4 w-80 h-80 bg-secondary-500/20 rounded-full blur-3xl animate-float animation-delay-2000"></div>
        <div class="absolute top-3/4 left-3/4 w-64 h-64 bg-neon-blue/10 rounded-full blur-3xl animate-float animation-delay-4000"></div>
    </div>

    <div class="relative max-w-md w-full space-y-8">
        <!-- Gaming Header -->
        <div class="text-center animate-fade-in">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gaming-gradient rounded-3xl mb-6 shadow-gaming-lg">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h2 class="text-4xl font-black text-white mb-2 bg-gaming-gradient bg-clip-text text-transparent">
                Verify Code
            </h2>
            <p class="text-muted-300">
                Enter the 6-digit code sent to your phone
            </p>
        </div>

        <!-- OTP Verification Form -->
        <x-ui.card variant="glass" class="animate-fade-in animation-delay-200">
            <form class="space-y-5" method="POST" action="{{ route('login.phone.verify.submit') }}">
                @csrf
                
                @if(session('success'))
                    <div class="p-4 bg-green-500/10 border border-green-500/20 rounded-lg">
                        <p class="text-sm text-green-400">{{ session('success') }}</p>
                    </div>
                @endif

                <!-- OTP Input -->
                <div>
                    <label for="otp" class="block text-sm font-semibold text-white mb-2">
                        Verification Code
                    </label>
                    <x-ui.input 
                        id="otp" 
                        name="otp" 
                        type="text" 
                        placeholder="000000" 
                        maxlength="6"
                        pattern="[0-9]{6}"
                        required
                        class="w-full text-center text-2xl tracking-widest font-mono"
                        autofocus
                    />
                    @error('otp')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Verify Button -->
                <div>
                    <x-ui.button 
                        type="submit" 
                        variant="primary" 
                        size="lg" 
                        glow="true"
                        class="w-full justify-center"
                    >
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Verify
                    </x-ui.button>
                </div>

                <!-- Resend Code -->
                <div class="text-center space-y-2">
                    <p class="text-sm text-muted-400">
                        Didn't receive the code?
                    </p>
                    <form method="POST" action="{{ route('login.phone.resend') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-sm text-primary-400 hover:text-primary-300 font-semibold transition-colors">
                            Resend Code
                        </button>
                    </form>
                </div>

                <!-- Back to Phone Input Link -->
                <div class="text-center pt-2 border-t border-gaming">
                    <a href="{{ route('login.phone') }}" class="text-sm text-muted-400 hover:text-white transition-colors">
                        ← Change phone number
                    </a>
                </div>
            </form>
        </x-ui.card>
    </div>
</div>

<script>
// Auto-format OTP input
document.getElementById('otp').addEventListener('input', function(e) {
    this.value = this.value.replace(/[^0-9]/g, '');
});
</script>

<style>
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

@keyframes fade-in {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.animate-float {
    animation: float 6s ease-in-out infinite;
}

.animate-fade-in {
    animation: fade-in 0.8s ease-out forwards;
}

.animation-delay-200 {
    animation-delay: 0.2s;
}

.animation-delay-2000 {
    animation-delay: 2s;
}

.animation-delay-4000 {
    animation-delay: 4s;
}
</style>
@endpush

</section>

</x-layouts.stellar-auth>


