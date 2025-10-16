<x-layouts.stellar>
    <x-slot name="title">{{ __('Seller Settings') }} - {{ config('app.name') }}</x-slot>

    <section class="relative pt-32 pb-12 md:pb-20">
        <div class="max-w-4xl mx-auto px-4 sm:px-6">
            
            <div class="mb-8">
                <a href="{{ route('seller.dashboard') }}" class="inline-flex items-center text-purple-400 hover:text-purple-300 text-sm mb-4">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    {{ __('Back to Dashboard') }}
                </a>
                <h1 class="h2 bg-clip-text text-transparent bg-gradient-to-r from-slate-200/60 via-slate-200 to-slate-200/60">
                    {{ __('Seller Settings') }}
                </h1>
            </div>

            <form action="{{ route('seller.settings.update') }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Business Information -->
                <div class="bg-slate-800/50 rounded-2xl p-6 lg:p-8 border border-slate-700/50" data-aos="fade-up">
                    <h2 class="text-lg font-bold text-slate-100 mb-6">{{ __('Business Information') }}</h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm text-slate-300 font-medium mb-2">{{ __('Business Name') }}</label>
                            <input type="text" name="business_name" value="{{ old('business_name', $seller->business_name ?? '') }}" class="form-input w-full">
                        </div>

                        <div>
                            <label class="block text-sm text-slate-300 font-medium mb-2">{{ __('Business Description') }}</label>
                            <textarea name="business_description" rows="4" class="form-textarea w-full">{{ old('business_description', $seller->business_description ?? '') }}</textarea>
                        </div>

                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm text-slate-300 font-medium mb-2">{{ __('Business Email') }}</label>
                                <input type="email" name="business_email" value="{{ old('business_email', $seller->business_email ?? '') }}" class="form-input w-full">
                            </div>
                            <div>
                                <label class="block text-sm text-slate-300 font-medium mb-2">{{ __('Business Phone') }}</label>
                                <input type="tel" name="business_phone" value="{{ old('business_phone', $seller->business_phone ?? '') }}" class="form-input w-full">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payout Settings -->
                <div class="bg-slate-800/50 rounded-2xl p-6 lg:p-8 border border-slate-700/50" data-aos="fade-up" data-aos-delay="100">
                    <h2 class="text-lg font-bold text-slate-100 mb-6">{{ __('Payout Settings') }}</h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm text-slate-300 font-medium mb-2">{{ __('Preferred Payout Method') }}</label>
                            <select name="payout_method" class="form-select w-full">
                                <option value="bank_transfer" {{ ($seller->payout_method ?? '') === 'bank_transfer' ? 'selected' : '' }}>{{ __('Bank Transfer') }}</option>
                                <option value="paypal" {{ ($seller->payout_method ?? '') === 'paypal' ? 'selected' : '' }}>{{ __('PayPal') }}</option>
                                <option value="wise" {{ ($seller->payout_method ?? '') === 'wise' ? 'selected' : '' }}>{{ __('Wise') }}</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm text-slate-300 font-medium mb-2">{{ __('Payout Details') }}</label>
                            <textarea name="payout_details" rows="3" class="form-textarea w-full" placeholder="{{ __('Bank account number, PayPal email, etc.') }}">{{ old('payout_details', $seller->payout_details ?? '') }}</textarea>
                            <p class="text-xs text-slate-500 mt-1">{{ __('This information is kept private and secure') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Notification Preferences -->
                <div class="bg-slate-800/50 rounded-2xl p-6 lg:p-8 border border-slate-700/50" data-aos="fade-up" data-aos-delay="200">
                    <h2 class="text-lg font-bold text-slate-100 mb-6">{{ __('Notification Preferences') }}</h2>
                    
                    <div class="space-y-3">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" name="notify_new_sale" class="form-checkbox text-purple-500" {{ ($seller->notify_new_sale ?? true) ? 'checked' : '' }}>
                            <span class="ml-3 text-slate-300">{{ __('Notify me of new sales') }}</span>
                        </label>
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" name="notify_new_review" class="form-checkbox text-purple-500" {{ ($seller->notify_new_review ?? true) ? 'checked' : '' }}>
                            <span class="ml-3 text-slate-300">{{ __('Notify me of new reviews') }}</span>
                        </label>
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" name="notify_payout_processed" class="form-checkbox text-purple-500" {{ ($seller->notify_payout_processed ?? true) ? 'checked' : '' }}>
                            <span class="ml-3 text-slate-300">{{ __('Notify me when payouts are processed') }}</span>
                        </label>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex gap-4" data-aos="fade-up" data-aos-delay="300">
                    <button type="submit" class="btn text-white bg-purple-500 hover:bg-purple-600">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        {{ __('Save Settings') }}
                    </button>
                    <a href="{{ route('seller.dashboard') }}" class="btn text-slate-300 hover:text-white bg-slate-700 hover:bg-slate-600">
                        {{ __('Cancel') }}
                    </a>
                </div>
            </form>
        </div>
    </section>
</x-layouts.stellar>
