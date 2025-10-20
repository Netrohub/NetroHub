<x-layouts.app>
    <x-slot name="title">{{ __('Identity Verification (OLD)') }} - {{ config('app.name') }}</x-slot>

<section class="relative pt-32 pb-12">
<div class="min-h-screen bg-dark-900 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-white mb-2">Identity Verification</h1>
            <p class="text-muted-400">Verify your identity to unlock selling features on NXO</p>
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

        @if(session('error'))
            <div class="bg-red-900/20 border border-red-500/30 rounded-xl p-4 mb-6">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-red-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-red-400">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        @if($latestSubmission && $latestSubmission->isPending())
            <!-- Pending Status -->
            <div class="bg-yellow-900/20 border border-yellow-500/30 rounded-xl p-6 mb-6">
                <div class="flex items-center mb-4">
                    <svg class="w-6 h-6 text-yellow-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <h2 class="text-xl font-bold text-yellow-400">Verification Under Review</h2>
                </div>
                <p class="text-muted-400 mb-4">
                    {{ __('Your identity verification is currently under review. We\'ll notify you once it\'s processed, usually within 24-48 hours.') }}
                </p>
                <div class="bg-dark-800/50 rounded-lg p-4">
                    <h3 class="font-semibold text-white mb-2">{{ __('Submission Details:') }}</h3>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="text-muted-400">Country:</span>
                            <span class="text-white ml-2">{{ strtoupper($latestSubmission->country_code) }}</span>
                        </div>
                        <div>
                            <span class="text-muted-400">ID Type:</span>
                            <span class="text-white ml-2">{{ $latestSubmission->id_type }}</span>
                        </div>
                        <div>
                            <span class="text-muted-400">Submitted:</span>
                            <span class="text-white ml-2">{{ $latestSubmission->created_at->format('M j, Y') }}</span>
                        </div>
                        <div>
                            <span class="text-muted-400">Status:</span>
                            <span class="text-white ml-2">{!! $latestSubmission->getStatusBadge() !!}</span>
                        </div>
                    </div>
                </div>
            </div>
        @elseif($latestSubmission && $latestSubmission->isRejected())
            <!-- Rejected Status -->
            <div class="bg-red-900/20 border border-red-500/30 rounded-xl p-6 mb-6">
                <div class="flex items-center mb-4">
                    <svg class="w-6 h-6 text-red-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <h2 class="text-xl font-bold text-red-400">Verification Rejected</h2>
                </div>
                <p class="text-muted-400 mb-4">
                    {{ __('Your identity verification was rejected. Please review the feedback and resubmit with corrected information.') }}
                </p>
                @if($latestSubmission->notes)
                    <div class="bg-dark-800/50 rounded-lg p-4 mb-4">
                        <h3 class="font-semibold text-white mb-2">Feedback:</h3>
                        <p class="text-muted-400">{{ $latestSubmission->notes }}</p>
                    </div>
                @endif
                <a href="{{ route('account.kyc.show') }}" 
                   class="inline-flex items-center px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg font-semibold transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    {{ __('Resubmit Verification') }}
                </a>
            </div>
        @else
            <!-- Verification Form -->
            <div class="bg-dark-800/50 backdrop-blur-xl border border-gaming rounded-2xl p-8">
                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-white mb-2">Identity Verification</h2>
                    <p class="text-muted-400">Please provide the following information to verify your identity.</p>
                </div>

                <!-- Compliance Notice -->
                <div class="bg-blue-900/20 border border-blue-500/30 rounded-xl p-4 mb-6">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-blue-400 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <h4 class="text-blue-400 font-medium mb-1">Data Protection Notice</h4>
                            <p class="text-sm text-muted-400">
                                {{ __('We collect this information for identity verification and fraud prevention in accordance with Saudi PDPL and international data protection standards.') }} 
                                {{ __('Your documents are encrypted and stored securely.') }}
                            </p>
                        </div>
                    </div>
                </div>

                <form action="{{ route('account.kyc.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Country -->
                        <div>
                            <label for="country_code" class="block text-sm font-medium text-white mb-2">
                                Country <span class="text-red-400">*</span>
                            </label>
                            <select id="country_code" 
                                    name="country_code" 
                                    class="w-full px-4 py-3 bg-dark-700/50 border border-gaming rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                    required>
                                <option value="">{{ __('Select your country') }}</option>
                                <option value="SA" {{ old('country_code') == 'SA' ? 'selected' : '' }}>{{ __('Saudi Arabia') }}</option>
                                <option value="AE" {{ old('country_code') == 'AE' ? 'selected' : '' }}>{{ __('United Arab Emirates') }}</option>
                                <option value="KW" {{ old('country_code') == 'KW' ? 'selected' : '' }}>{{ __('Kuwait') }}</option>
                                <option value="QA" {{ old('country_code') == 'QA' ? 'selected' : '' }}>{{ __('Qatar') }}</option>
                                <option value="BH" {{ old('country_code') == 'BH' ? 'selected' : '' }}>{{ __('Bahrain') }}</option>
                                <option value="OM" {{ old('country_code') == 'OM' ? 'selected' : '' }}>{{ __('Oman') }}</option>
                                <option value="US" {{ old('country_code') == 'US' ? 'selected' : '' }}>{{ __('United States') }}</option>
                                <option value="GB" {{ old('country_code') == 'GB' ? 'selected' : '' }}>{{ __('United Kingdom') }}</option>
                                <option value="CA" {{ old('country_code') == 'CA' ? 'selected' : '' }}>{{ __('Canada') }}</option>
                                <option value="AU" {{ old('country_code') == 'AU' ? 'selected' : '' }}>{{ __('Australia') }}</option>
                                <option value="DE" {{ old('country_code') == 'DE' ? 'selected' : '' }}>{{ __('Germany') }}</option>
                                <option value="FR" {{ old('country_code') == 'FR' ? 'selected' : '' }}>{{ __('France') }}</option>
                                <option value="IT" {{ old('country_code') == 'IT' ? 'selected' : '' }}>{{ __('Italy') }}</option>
                                <option value="ES" {{ old('country_code') == 'ES' ? 'selected' : '' }}>{{ __('Spain') }}</option>
                                <option value="NL" {{ old('country_code') == 'NL' ? 'selected' : '' }}>{{ __('Netherlands') }}</option>
                                <option value="SE" {{ old('country_code') == 'SE' ? 'selected' : '' }}>{{ __('Sweden') }}</option>
                                <option value="NO" {{ old('country_code') == 'NO' ? 'selected' : '' }}>{{ __('Norway') }}</option>
                                <option value="DK" {{ old('country_code') == 'DK' ? 'selected' : '' }}>{{ __('Denmark') }}</option>
                                <option value="FI" {{ old('country_code') == 'FI' ? 'selected' : '' }}>{{ __('Finland') }}</option>
                                <option value="JP" {{ old('country_code') == 'JP' ? 'selected' : '' }}>{{ __('Japan') }}</option>
                                <option value="KR" {{ old('country_code') == 'KR' ? 'selected' : '' }}>{{ __('South Korea') }}</option>
                                <option value="CN" {{ old('country_code') == 'CN' ? 'selected' : '' }}>{{ __('China') }}</option>
                                <option value="IN" {{ old('country_code') == 'IN' ? 'selected' : '' }}>{{ __('India') }}</option>
                                <option value="BR" {{ old('country_code') == 'BR' ? 'selected' : '' }}>{{ __('Brazil') }}</option>
                                <option value="MX" {{ old('country_code') == 'MX' ? 'selected' : '' }}>{{ __('Mexico') }}</option>
                                <option value="AR" {{ old('country_code') == 'AR' ? 'selected' : '' }}>{{ __('Argentina') }}</option>
                                <option value="ZA" {{ old('country_code') == 'ZA' ? 'selected' : '' }}>{{ __('South Africa') }}</option>
                                <option value="EG" {{ old('country_code') == 'EG' ? 'selected' : '' }}>{{ __('Egypt') }}</option>
                                <option value="MA" {{ old('country_code') == 'MA' ? 'selected' : '' }}>{{ __('Morocco') }}</option>
                                <option value="TR" {{ old('country_code') == 'TR' ? 'selected' : '' }}>{{ __('Turkey') }}</option>
                                <option value="RU" {{ old('country_code') == 'RU' ? 'selected' : '' }}>{{ __('Russia') }}</option>
                                <option value="OTHER" {{ old('country_code') == 'OTHER' ? 'selected' : '' }}>{{ __('Other') }}</option>
                            </select>
                            @error('country_code')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- ID Type -->
                        <div>
                            <label for="id_type" class="block text-sm font-medium text-white mb-2">
                                ID Type <span class="text-red-400">*</span>
                            </label>
                            <select id="id_type" 
                                    name="id_type" 
                                    class="w-full px-4 py-3 bg-dark-700/50 border border-gaming rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                    required>
                                <option value="">Select ID type</option>
                                <option value="national_id" {{ old('id_type') == 'national_id' ? 'selected' : '' }}>National ID</option>
                                <option value="passport" {{ old('id_type') == 'passport' ? 'selected' : '' }}>Passport</option>
                                <option value="driver_license" {{ old('id_type') == 'driver_license' ? 'selected' : '' }}>Driver's License</option>
                            </select>
                            @error('id_type')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Full Name -->
                        <div class="md:col-span-2">
                            <label for="full_name" class="block text-sm font-medium text-white mb-2">
                                Full Name <span class="text-red-400">*</span>
                            </label>
                            <input type="text" 
                                   id="full_name" 
                                   name="full_name" 
                                   value="{{ old('full_name', $user->name) }}"
                                   class="w-full px-4 py-3 bg-dark-700/50 border border-gaming rounded-xl text-white placeholder-muted-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                   placeholder="Enter your full legal name"
                                   required>
                            @error('full_name')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Document Upload -->
                    <div class="mt-6">
                        <label for="id_image" class="block text-sm font-medium text-white mb-2">
                            Upload ID Document <span class="text-red-400">*</span>
                        </label>
                        <div class="relative">
                            <input type="file" 
                                   id="id_image" 
                                   name="id_image" 
                                   accept="image/*,.pdf"
                                   class="w-full px-4 py-3 bg-dark-700/50 border border-gaming rounded-xl text-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-primary-500 file:text-white hover:file:bg-primary-600 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                   required>
                        </div>
                        <p class="text-xs text-muted-400 mt-1">Accepted formats: JPG, PNG, PDF (Max 5MB)</p>
                        @error('id_image')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Consent Notice -->
                    <div class="mt-6 bg-gray-900/20 border border-gray-500/30 rounded-xl p-4">
                        <p class="text-sm text-muted-400">
                            <strong class="text-white">Consent Notice:</strong> By uploading your ID, you agree to our data processing terms and identity verification policy. 
                            Your information will be encrypted and stored securely in accordance with our Privacy Policy.
                        </p>
                    </div>

                    <!-- Submit Button -->
                    <div class="mt-8 flex justify-end">
                        <button type="submit" 
                                class="bg-primary-500 hover:bg-primary-600 text-white px-8 py-3 rounded-xl font-semibold transition-colors duration-200 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Submit Verification
                        </button>
                    </div>
                </form>
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
            </div>
        </div>
    </div>
</div>
</section>

</x-layouts.app>
