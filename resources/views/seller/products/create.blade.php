<x-layouts.app>
    <x-slot name="title">{{ __('Add Product') }} - {{ config('app.name') }}</x-slot>

    <section class="relative pt-32 pb-12 md:pb-20">
        <div class="max-w-4xl mx-auto px-4 sm:px-6">
            
            <div class="mb-8">
                <a href="{{ route('seller.products.index') }}" class="inline-flex items-center text-primary hover:text-primary/80 text-sm mb-4">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    {{ __('Back to Products') }}
                </a>
                <h1 class="h2 bg-gradient-primary bg-clip-text text-transparent">
                    {{ __('Add New Product') }}
                </h1>
            </div>

            <form action="{{ route('seller.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Basic Information -->
                <div class="glass-card p-6 lg:p-8" data-aos="fade-up">
                    <h2 class="text-lg font-bold text-foreground mb-6">{{ __('Basic Information') }}</h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm text-foreground font-medium mb-2">{{ __('Product Title') }} <span class="text-destructive">*</span></label>
                            <input type="text" name="title" value="{{ old('title') }}" class="form-input w-full" required>
                            @error('title')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm text-foreground font-medium mb-2">{{ __('Description') }} <span class="text-destructive">*</span></label>
                            <textarea name="description" rows="4" class="form-textarea w-full" required>{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm text-foreground font-medium mb-2">{{ __('Category') }} <span class="text-destructive">*</span></label>
                                <select name="category_id" class="form-select w-full" required>
                                    <option value="">{{ __('Select category') }}</option>
                                    @foreach($categories ?? [] as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm text-foreground font-medium mb-2">{{ __('Price') }} <span class="text-destructive">*</span></label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-muted-foreground">$</span>
                                    <input type="number" name="price" step="0.01" min="0" value="{{ old('price') }}" class="form-input w-full pl-8" required>
                                </div>
                                @error('price')
                                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product Details -->
                <div class="glass-card p-6 lg:p-8" data-aos="fade-up" data-aos-delay="100">
                    <h2 class="text-lg font-bold text-foreground mb-6">{{ __('Product Details') }}</h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm text-foreground font-medium mb-2">{{ __('Product Type') }} <span class="text-destructive">*</span></label>
                            <select name="type" id="product_type" class="form-select w-full" required>
                                <option value="digital">{{ __('Digital Product') }}</option>
                                <option value="social_account">{{ __('Social Media Account') }}</option>
                                <option value="game_account">{{ __('Game Account') }}</option>
                                <option value="service">{{ __('Service') }}</option>
                                <option value="credential">{{ __('Credentials') }}</option>
                            </select>
                        </div>

                        <div id="platform_field" class="hidden">
                            <label class="block text-sm text-foreground font-medium mb-2">{{ __('Platform') }} <span class="text-destructive">*</span></label>
                            <select name="platform" class="form-select w-full">
                                <option value="">{{ __('Select platform') }}</option>
                                <option value="Instagram">{{ __('Instagram') }}</option>
                                <option value="TikTok">{{ __('TikTok') }}</option>
                                <option value="X (Twitter)">{{ __('X (Twitter)') }}</option>
                                <option value="YouTube">{{ __('YouTube') }}</option>
                                <option value="Discord">{{ __('Discord') }}</option>
                                <option value="Facebook">{{ __('Facebook') }}</option>
                                <option value="Snapchat">{{ __('Snapchat') }}</option>
                                <option value="Twitch">{{ __('Twitch') }}</option>
                                <option value="LinkedIn">{{ __('LinkedIn') }}</option>
                                <option value="Reddit">{{ __('Reddit') }}</option>
                            </select>
                        </div>

                        <div id="social_username_field" class="hidden">
                            <label class="block text-sm text-foreground font-medium mb-2">{{ __('Social Media Username') }} <span class="text-destructive">*</span></label>
                            <div class="relative">
                                <span id="username_prefix" class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm">@</span>
                                <input type="text" name="social_username" id="social_username" class="form-input w-full pl-8" placeholder="username">
                            </div>
                            <p class="text-xs text-slate-500 mt-1">{{ __('Enter the username without @ symbol (e.g., "username" not "@username")') }}</p>
                        </div>

                        <!-- Social Account Verification Section -->
                        <div id="verification_section" class="hidden">
                            <div class="glass-card p-6">
                                <h3 class="text-lg font-bold text-primary mb-4 flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                    </svg>
                                    {{ __('Account Ownership Verification') }}
                                </h3>
                                <p class="text-muted-foreground text-sm mb-4">{{ __('To ensure account security, we need to verify that you own this social media account.') }}</p>
                                
                                <div id="verification_step_1" class="space-y-4">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                        <div class="w-8 h-8 bg-primary/20 rounded-lg flex items-center justify-center mr-3">
                                                <span class="text-primary font-bold text-sm">1</span>
                                            </div>
                                            <span class="text-slate-200 font-medium">{{ __('Start Verification') }}</span>
                                        </div>
                                        <button type="button" id="start_verification_btn" class="px-4 py-2 btn-glow text-primary-foreground rounded-lg text-sm font-medium transition-colors">
                                            {{ __('Start') }}
                                        </button>
                                    </div>
                                </div>

                                <div id="verification_step_2" class="hidden space-y-4">
                                    <div class="bg-slate-800/50 rounded-lg p-4 border border-slate-700/50">
                                        <div class="flex items-center mb-3">
                                            <div class="w-8 h-8 bg-blue-500/20 rounded-lg flex items-center justify-center mr-3">
                                                <span class="text-blue-400 font-bold text-sm">2</span>
                                            </div>
                                            <span class="text-slate-200 font-medium">{{ __('Add Token to Bio') }}</span>
                                        </div>
                                        
                                    <div class="glass-card p-4 mb-4">
                                            <div class="flex items-center justify-between mb-2">
                                                <span class="text-muted-foreground text-sm">{{ __('Your verification token:') }}</span>
                                                <div class="flex items-center gap-2">
                                                    <span id="verification_token" class="bg-blue-500/20 text-blue-400 px-3 py-1 rounded-lg font-mono text-lg font-bold"></span>
                                                    <button type="button" id="copy_token_btn" class="p-1 text-muted-foreground hover:text-primary transition-colors">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                            <p class="text-muted-foreground text-xs mb-3">{{ __('Copy this token and add it to your account bio/description. You can remove it after verification.') }}</p>
                                            
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center text-sm text-muted-foreground">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                    <span>{{ __('Time remaining:') }}</span>
                                                    <span id="countdown_timer" class="ml-1 font-mono text-blue-400"></span>
                                                </div>
                                                <a id="account_link" href="#" target="_blank" class="text-primary hover:text-primary/80 text-sm flex items-center">
                                                    {{ __('Open Account') }}
                                                    <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                        
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center">
                                        <div class="w-8 h-8 bg-primary/20 rounded-lg flex items-center justify-center mr-3">
                                                <span class="text-primary font-bold text-sm">3</span>
                                                </div>
                                                <span class="text-slate-200 font-medium">{{ __('Verify Ownership') }}</span>
                                            </div>
                                            <button type="button" id="verify_ownership_btn" class="px-4 py-2 gradient-primary text-white rounded-lg text-sm font-medium transition-colors">
                                                {{ __('Verify') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div id="verification_success" class="hidden">
                                    <div class="glass-card p-4">
                                        <div class="flex items-center">
                                            <svg class="w-5 h-5 text-green-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <span class="text-green-400 font-medium">{{ __('Account verified successfully!') }}</span>
                                        </div>
                                        <p class="text-muted-foreground text-sm mt-1">{{ __('You can now proceed with creating your product listing.') }}</p>
                                    </div>
                                </div>

                                <div id="verification_error" class="hidden">
                                    <div class="glass-card p-4">
                                        <div class="flex items-center">
                                            <svg class="w-5 h-5 text-red-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <span class="text-red-400 font-medium">{{ __('Verification failed') }}</span>
                                        </div>
                                        <p id="verification_error_message" class="text-red-300 text-sm mt-1"></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Social Media Account Legal Agreement -->
                        <div id="legal_agreement_section" class="hidden">
                            <div class="bg-amber-500/10 border border-amber-500/20 rounded-xl p-6">
                                <h3 class="text-lg font-bold text-amber-400 mb-4 flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                    </svg>
                                    {{ __('Legal Agreement') }}
                                </h3>
                                
                                <div class="bg-slate-900/50 rounded-lg p-4 mb-4">
                                    <p class="text-slate-300 text-sm leading-relaxed mb-4">
                                        أتعهد بأن وصف المنتج خالٍ تمامًا من أي وسيلة تواصل خارج المنصة بأي شكلٍ كان، سواء بشكل مباشر أو غير مباشر.
                                        وأقرّ بتحملي كامل المسؤولية القانونية عن أي نشاط أو محتوى أو تصرف صدر من الحساب المعروض منذ تاريخ إنشائه أو شرائه وحتى تاريخ بيعه عبر منصة نيترو، وأتعهد بخلوه من أي مخالفات أو جرائم إلكترونية.
                                    </p>
                                    
                                    <div class="flex items-start">
                                        <div class="flex items-center h-5">
                                            <input type="checkbox" 
                                                   id="legal_agreement" 
                                                   name="legal_agreement" 
                                                   class="w-4 h-4 text-amber-500 bg-slate-800 border-slate-600 rounded focus:ring-amber-500 focus:ring-2">
                                        </div>
                                        <label for="legal_agreement" class="mr-3 text-sm text-slate-300 leading-relaxed cursor-pointer">
                                            {{ __('I agree to the above terms and conditions') }}
                                        </label>
                                    </div>
                                    
                                    <div id="legal_agreement_error" class="hidden mt-2">
                                        <p class="text-red-400 text-sm flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            يجب الموافقة على التعهد قبل عرض الحساب.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm text-slate-300 font-medium mb-2">{{ __('Stock Quantity') }}</label>
                            <input type="number" name="stock" min="0" value="{{ old('stock', 1) }}" class="form-input w-full">
                            <p class="text-xs text-slate-500 mt-1">{{ __('Leave blank for unlimited') }}</p>
                        </div>

                        <div>
                            <label class="block text-sm text-slate-300 font-medium mb-2">{{ __('Product Files/Content') }}</label>
                            <input type="file" name="files[]" multiple class="form-input w-full">
                            <p class="text-xs text-slate-500 mt-1">{{ __('Upload product files, images, or credentials') }}</p>
                        </div>
                    </div>
                </div>

                <!-- General Checklist -->
                <div class="glass-card p-6 lg:p-8" data-aos="fade-up" data-aos-delay="150">
                    <h2 class="text-lg font-bold text-foreground mb-6">{{ __('Product Checklist') }}</h2>
                    <p class="text-muted-foreground text-sm mb-6">{{ __('Please fill out the following checklist to provide important information about your product') }}</p>
                    
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-4 bg-muted/30 rounded-xl border border-border/50">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-blue-500/20 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <span class="text-foreground font-medium">{{ __('تسليم تلقائي؟') }}</span>
                            </div>
                            <div class="flex gap-2">
                                <label class="flex items-center">
                                    <input type="radio" name="general_checklist[auto_delivery]" value="yes" class="form-radio text-green-500">
                                    <span class="ml-2 text-green-400">{{ __('نعم') }}</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="general_checklist[auto_delivery]" value="no" class="form-radio text-red-500">
                                    <span class="ml-2 text-red-400">{{ __('لا') }}</span>
                                </label>
                            </div>
                        </div>

                        <div class="flex items-center justify-between p-4 bg-muted/30 rounded-xl border border-border/50">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-blue-500/20 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <span class="text-foreground font-medium">{{ __('مع الأيميل الأساسي؟') }}</span>
                            </div>
                            <div class="flex gap-2">
                                <label class="flex items-center">
                                    <input type="radio" name="general_checklist[with_original_email]" value="yes" class="form-radio text-green-500">
                                    <span class="ml-2 text-green-400">{{ __('نعم') }}</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="general_checklist[with_original_email]" value="no" class="form-radio text-red-500">
                                    <span class="ml-2 text-red-400">{{ __('لا') }}</span>
                                </label>
                            </div>
                        </div>

                        <div class="flex items-center justify-between p-4 bg-muted/30 rounded-xl border border-border/50">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-blue-500/20 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <span class="text-foreground font-medium">{{ __('مع الأيميل الحالي؟') }}</span>
                            </div>
                            <div class="flex gap-2">
                                <label class="flex items-center">
                                    <input type="radio" name="general_checklist[with_current_email]" value="yes" class="form-radio text-green-500">
                                    <span class="ml-2 text-green-400">{{ __('نعم') }}</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="general_checklist[with_current_email]" value="no" class="form-radio text-red-500">
                                    <span class="ml-2 text-red-400">{{ __('لا') }}</span>
                                </label>
                            </div>
                        </div>

                        <div class="flex items-center justify-between p-4 bg-muted/30 rounded-xl border border-border/50">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-blue-500/20 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                                    </svg>
                                </div>
                                <span class="text-foreground font-medium">{{ __('مربوط برقم؟') }}</span>
                            </div>
                            <div class="flex gap-2">
                                <label class="flex items-center">
                                    <input type="radio" name="general_checklist[linked_to_number]" value="yes" class="form-radio text-green-500">
                                    <span class="ml-2 text-green-400">{{ __('نعم') }}</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="general_checklist[linked_to_number]" value="no" class="form-radio text-red-500">
                                    <span class="ml-2 text-red-400">{{ __('لا') }}</span>
                                </label>
                            </div>
                        </div>

                        <div class="flex items-center justify-between p-4 bg-muted/30 rounded-xl border border-border/50">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-blue-500/20 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                    </svg>
                                </div>
                                <span class="text-foreground font-medium">{{ __('صاحب المنتج موثق بهوية؟') }}</span>
                            </div>
                            <div class="flex gap-2">
                                <label class="flex items-center">
                                    <input type="radio" name="general_checklist[owner_verified]" value="yes" class="form-radio text-green-500">
                                    <span class="ml-2 text-green-400">{{ __('نعم') }}</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="general_checklist[owner_verified]" value="no" class="form-radio text-red-500">
                                    <span class="ml-2 text-red-400">{{ __('لا') }}</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Whiteout Survival Specific Checklist -->
                <div id="whiteout-survival-checklist" class="glass-card p-6 lg:p-8 hidden" data-aos="fade-up" data-aos-delay="175">
                    <h2 class="text-lg font-bold text-foreground mb-6">{{ __('Whiteout Survival Checklist') }}</h2>
                    <p class="text-muted-foreground text-sm mb-6">{{ __('Additional checklist items specific to Whiteout Survival game accounts') }}</p>
                    
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-4 bg-muted/30 rounded-xl border border-border/50">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-blue-500/20 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                    </svg>
                                </div>
                                <span class="text-foreground font-medium">{{ __('مربوط بالفيس بوك؟') }}</span>
                            </div>
                            <div class="flex gap-2">
                                <label class="flex items-center">
                                    <input type="radio" name="whiteout_survival_checklist[linked_to_facebook]" value="yes" class="form-radio text-green-500">
                                    <span class="ml-2 text-green-400">{{ __('نعم') }}</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="whiteout_survival_checklist[linked_to_facebook]" value="no" class="form-radio text-red-500">
                                    <span class="ml-2 text-red-400">{{ __('لا') }}</span>
                                </label>
                            </div>
                        </div>

                        <div class="flex items-center justify-between p-4 bg-muted/30 rounded-xl border border-border/50">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-blue-500/20 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9"/>
                                    </svg>
                                </div>
                                <span class="text-foreground font-medium">{{ __('مربوط بقوقل؟') }}</span>
                            </div>
                            <div class="flex gap-2">
                                <label class="flex items-center">
                                    <input type="radio" name="whiteout_survival_checklist[linked_to_google]" value="yes" class="form-radio text-green-500">
                                    <span class="ml-2 text-green-400">{{ __('نعم') }}</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="whiteout_survival_checklist[linked_to_google]" value="no" class="form-radio text-red-500">
                                    <span class="ml-2 text-red-400">{{ __('لا') }}</span>
                                </label>
                            </div>
                        </div>

                        <div class="flex items-center justify-between p-4 bg-muted/30 rounded-xl border border-border/50">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-blue-500/20 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <span class="text-foreground font-medium">{{ __('مربوط بأبل؟') }}</span>
                            </div>
                            <div class="flex gap-2">
                                <label class="flex items-center">
                                    <input type="radio" name="whiteout_survival_checklist[linked_to_apple]" value="yes" class="form-radio text-green-500">
                                    <span class="ml-2 text-green-400">{{ __('نعم') }}</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="whiteout_survival_checklist[linked_to_apple]" value="no" class="form-radio text-red-500">
                                    <span class="ml-2 text-red-400">{{ __('لا') }}</span>
                                </label>
                            </div>
                        </div>

                        <div class="flex items-center justify-between p-4 bg-muted/30 rounded-xl border border-border/50">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-blue-500/20 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                    </svg>
                                </div>
                                <span class="text-foreground font-medium">{{ __('مربوط بقيم سنتر؟') }}</span>
                            </div>
                            <div class="flex gap-2">
                                <label class="flex items-center">
                                    <input type="radio" name="whiteout_survival_checklist[linked_to_game_center]" value="yes" class="form-radio text-green-500">
                                    <span class="ml-2 text-green-400">{{ __('نعم') }}</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="whiteout_survival_checklist[linked_to_game_center]" value="no" class="form-radio text-red-500">
                                    <span class="ml-2 text-red-400">{{ __('لا') }}</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex gap-4" data-aos="fade-up" data-aos-delay="200">
                    <button type="submit" class="btn-glow text-primary-foreground">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        {{ __('Publish Product') }}
                    </button>
                    <a href="{{ route('seller.products.index') }}" class="glass-card border-border/50 px-4 py-2 rounded-lg">
                        {{ __('Cancel') }}
                    </a>
                </div>
            </form>
        </div>
    </section>

    <!-- Account Verification Modal -->
    <div id="verification-modal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-slate-800/95 backdrop-blur-xl border border-slate-700/50 rounded-2xl p-8 shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-xl bg-blue-500/20 flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-slate-100">Account Ownership Verification</h2>
                    </div>
                    <button type="button" id="close-verification-modal" class="text-slate-400 hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                
                <p class="text-slate-400 text-sm mb-6">To ensure account security, we need to verify that you own this social media account before listing it.</p>
                
                <div id="verification_step_1" class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-blue-500/20 rounded-lg flex items-center justify-center mr-3">
                                <span class="text-blue-400 font-bold text-sm">1</span>
                            </div>
                            <span class="text-slate-200 font-medium">Start Verification</span>
                        </div>
                        <button type="button" id="start_verification_btn" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg text-sm font-medium transition-colors">
                            Start
                        </button>
                    </div>
                </div>

                <div id="verification_step_2" class="hidden space-y-4">
                    <div class="bg-slate-900/50 rounded-lg p-4 border border-slate-700/50">
                        <div class="flex items-center mb-3">
                            <div class="w-8 h-8 bg-blue-500/20 rounded-lg flex items-center justify-center mr-3">
                                <span class="text-blue-400 font-bold text-sm">2</span>
                            </div>
                            <span class="text-slate-200 font-medium">Add Token to Bio</span>
                        </div>
                        
                        <div class="bg-slate-800/50 rounded-lg p-4 mb-4">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-slate-300 text-sm">Your verification token:</span>
                                <div class="flex items-center gap-2">
                                    <span id="verification_token" class="bg-blue-500/20 text-blue-400 px-3 py-1 rounded-lg font-mono text-lg font-bold"></span>
                                    <button type="button" id="copy_token_btn" class="p-1 text-slate-400 hover:text-blue-400 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <p class="text-slate-400 text-xs mb-3">Copy this token and add it to your account bio/description. You can remove it after verification.</p>
                            
                            <div class="flex items-center justify-between">
                                <div class="flex items-center text-sm text-slate-400">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span>Time remaining:</span>
                                    <span id="countdown_timer" class="ml-1 font-mono text-blue-400"></span>
                                </div>
                                <a id="account_link" href="#" target="_blank" class="text-blue-400 hover:text-blue-300 text-sm flex items-center">
                                    Open Account
                                    <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-blue-500/20 rounded-lg flex items-center justify-center mr-3">
                                    <span class="text-blue-400 font-bold text-sm">3</span>
                                </div>
                                <span class="text-slate-200 font-medium">Verify Ownership</span>
                            </div>
                            <button type="button" id="verify_ownership_btn" class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg text-sm font-medium transition-colors">
                                Verify
                            </button>
                        </div>
                    </div>
                </div>

                <div id="verification_success" class="hidden">
                    <div class="bg-green-500/10 border border-green-500/20 rounded-lg p-4">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-green-400 font-medium">Account verified successfully!</span>
                        </div>
                        <p class="text-green-300 text-sm mt-1">You can now proceed with creating your product listing.</p>
                    </div>
                    <div class="mt-4 flex justify-end">
                        <button type="button" id="proceed-to-submit" class="px-6 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg font-medium transition-colors">
                            Continue to Submit
                        </button>
                    </div>
                </div>

                <div id="verification_error" class="hidden">
                    <div class="bg-red-500/10 border border-red-500/20 rounded-lg p-4">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-red-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-red-400 font-medium">Verification failed</span>
                        </div>
                        <p id="verification_error_message" class="text-red-300 text-sm mt-1"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const categorySelect = document.querySelector('select[name="category_id"]');
            const productTypeSelect = document.getElementById('product_type');
            const platformField = document.getElementById('platform_field');
            const socialUsernameField = document.getElementById('social_username_field');
            const verificationSection = document.getElementById('verification_section');
            const legalAgreementSection = document.getElementById('legal_agreement_section');
            const usernamePrefix = document.getElementById('username_prefix');
            const whiteoutChecklist = document.getElementById('whiteout-survival-checklist');
            
            // Verification elements
            const startVerificationBtn = document.getElementById('start_verification_btn');
            const verifyOwnershipBtn = document.getElementById('verify_ownership_btn');
            const copyTokenBtn = document.getElementById('copy_token_btn');
            const verificationToken = document.getElementById('verification_token');
            const countdownTimer = document.getElementById('countdown_timer');
            const accountLink = document.getElementById('account_link');
            const verificationStep1 = document.getElementById('verification_step_1');
            const verificationStep2 = document.getElementById('verification_step_2');
            const verificationSuccess = document.getElementById('verification_success');
            const verificationError = document.getElementById('verification_error');
            const verificationErrorMessage = document.getElementById('verification_error_message');
            
            let currentVerification = null;
            let countdownInterval = null;
            
            function toggleWhiteoutChecklist() {
                const selectedOption = categorySelect.options[categorySelect.selectedIndex];
                const categoryName = selectedOption.text.toLowerCase();
                
                if (categoryName.includes('whiteout') || categoryName.includes('survival')) {
                    whiteoutChecklist.classList.remove('hidden');
                } else {
                    whiteoutChecklist.classList.add('hidden');
                }
            }
            
            function toggleSocialFields() {
                const productType = productTypeSelect.value;
                
                if (productType === 'social_account') {
                    platformField.classList.remove('hidden');
                    socialUsernameField.classList.remove('hidden');
                    verificationSection.classList.remove('hidden');
                    legalAgreementSection.classList.remove('hidden');
                } else {
                    platformField.classList.add('hidden');
                    socialUsernameField.classList.add('hidden');
                    verificationSection.classList.add('hidden');
                    legalAgreementSection.classList.add('hidden');
                    resetVerificationState();
                }
            }
            
            function updateUsernamePrefix() {
                const platform = document.querySelector('select[name="platform"]').value;
                const prefixes = {
                    'Instagram': '@',
                    'TikTok': '@',
                    'X (Twitter)': '@',
                    'YouTube': '@',
                    'Discord': '@',
                    'Facebook': '@',
                    'Snapchat': '@',
                    'Twitch': '@',
                    'LinkedIn': '@',
                    'Reddit': 'u/'
                };
                
                usernamePrefix.textContent = prefixes[platform] || '@';
            }
            
            if (categorySelect) {
                categorySelect.addEventListener('change', toggleWhiteoutChecklist);
                toggleWhiteoutChecklist();
            }
            
            if (productTypeSelect) {
                productTypeSelect.addEventListener('change', toggleSocialFields);
                toggleSocialFields();
            }
            
            const platformSelect = document.querySelector('select[name="platform"]');
            if (platformSelect) {
                platformSelect.addEventListener('change', updateUsernamePrefix);
            }
            
            // Verification event listeners
            if (startVerificationBtn) {
                startVerificationBtn.addEventListener('click', startVerification);
            }
            
            if (verifyOwnershipBtn) {
                verifyOwnershipBtn.addEventListener('click', verifyOwnership);
            }
            
            if (copyTokenBtn) {
                copyTokenBtn.addEventListener('click', copyToken);
            }
            
            // Verification functions
            function startVerification() {
                const platform = document.querySelector('select[name="platform"]').value;
                const username = document.getElementById('social_username').value;
                
                if (!platform || !username) {
                    showError('Please select a platform and enter a username first.');
                    return;
                }
                
                startVerificationBtn.disabled = true;
                startVerificationBtn.textContent = 'Starting...';
                
                fetch('{{ route("seller.social-verification.start") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        platform: platform,
                        username: username
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        if (data.already_verified) {
                            showSuccess('This account is already verified!');
                            return;
                        }
                        
                        currentVerification = data.verification;
                        showVerificationStep2();
                        startCountdown();
                    } else {
                        showError(data.message || 'Failed to start verification.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showError('An error occurred. Please try again.');
                })
                .finally(() => {
                    startVerificationBtn.disabled = false;
                    startVerificationBtn.textContent = '{{ __("Start") }}';
                });
            }
            
            function verifyOwnership() {
                if (!currentVerification) {
                    showError('No active verification found.');
                    return;
                }
                
                verifyOwnershipBtn.disabled = true;
                verifyOwnershipBtn.textContent = 'Verifying...';
                
                fetch('{{ route("seller.social-verification.verify") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        verification_id: currentVerification.id
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showSuccess('Account verified successfully!');
                        clearCountdown();
                    } else {
                        showError(data.message || 'Verification failed. Please make sure the token is in your bio and try again.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showError('An error occurred. Please try again.');
                })
                .finally(() => {
                    verifyOwnershipBtn.disabled = false;
                    verifyOwnershipBtn.textContent = '{{ __("Verify") }}';
                });
            }
            
            function copyToken() {
                if (currentVerification && currentVerification.token) {
                    navigator.clipboard.writeText(currentVerification.token).then(() => {
                        copyTokenBtn.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>';
                        setTimeout(() => {
                            copyTokenBtn.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>';
                        }, 2000);
                    });
                }
            }
            
            function showVerificationStep2() {
                if (!currentVerification) return;
                
                verificationStep1.classList.add('hidden');
                verificationStep2.classList.remove('hidden');
                verificationToken.textContent = currentVerification.token;
                accountLink.href = currentVerification.account_url;
                
                hideError();
                hideSuccess();
            }
            
            function showSuccess(message) {
                verificationStep1.classList.add('hidden');
                verificationStep2.classList.add('hidden');
                verificationSuccess.classList.remove('hidden');
                hideError();
            }
            
            function showError(message) {
                verificationErrorMessage.textContent = message;
                verificationError.classList.remove('hidden');
                hideSuccess();
            }
            
            function hideError() {
                verificationError.classList.add('hidden');
            }
            
            function hideSuccess() {
                verificationSuccess.classList.add('hidden');
            }
            
            function startCountdown() {
                if (!currentVerification) return;
                
                const expiresAt = new Date(currentVerification.expires_at);
                
                function updateCountdown() {
                    const now = new Date();
                    const timeLeft = expiresAt - now;
                    
                    if (timeLeft <= 0) {
                        clearCountdown();
                        showError('Verification token has expired. Please start a new verification.');
                        return;
                    }
                    
                    const minutes = Math.floor(timeLeft / 60000);
                    const seconds = Math.floor((timeLeft % 60000) / 1000);
                    
                    countdownTimer.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                }
                
                updateCountdown();
                countdownInterval = setInterval(updateCountdown, 1000);
            }
            
            function clearCountdown() {
                if (countdownInterval) {
                    clearInterval(countdownInterval);
                    countdownInterval = null;
                }
            }
            
            function resetVerificationState() {
                currentVerification = null;
                clearCountdown();
                verificationStep1.classList.remove('hidden');
                verificationStep2.classList.add('hidden');
                verificationSuccess.classList.add('hidden');
                verificationError.classList.add('hidden');
            }
            
            // Form validation
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    const productType = productTypeSelect.value;
                    const legalAgreementCheckbox = document.getElementById('legal_agreement');
                    const legalAgreementError = document.getElementById('legal_agreement_error');
                    
                    // Check if it's a social media account and legal agreement is required
                    if (productType === 'social_account') {
                        if (!legalAgreementCheckbox.checked) {
                            e.preventDefault();
                            legalAgreementError.classList.remove('hidden');
                            legalAgreementCheckbox.focus();
                            return false;
                        } else {
                            legalAgreementError.classList.add('hidden');
                        }
                        
                        // Show verification modal instead of submitting for social accounts
                        e.preventDefault();
                        showVerificationModal();
                        return false;
                    }
                    // For non-social accounts (like gaming), allow normal submission
                });
            }
            
            // Modal controls for main form
            const verificationModal = document.getElementById('verification-modal');
            const closeModalBtn = document.getElementById('close-verification-modal');
            const proceedToSubmitBtn = document.getElementById('proceed-to-submit');
            
            if (closeModalBtn) {
                closeModalBtn.addEventListener('click', hideVerificationModal);
            }
            
            if (proceedToSubmitBtn) {
                proceedToSubmitBtn.addEventListener('click', function() {
                    hideVerificationModal();
                    // Submit the form
                    form.submit();
                });
            }
            
            // Close modal when clicking outside
            if (verificationModal) {
                verificationModal.addEventListener('click', function(e) {
                    if (e.target === verificationModal) {
                        hideVerificationModal();
                    }
                });
            }
            
            function showVerificationModal() {
                verificationModal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }
            
            function hideVerificationModal() {
                verificationModal.classList.add('hidden');
                document.body.style.overflow = 'auto';
                resetVerificationState();
            }
        });
    </script>
</x-layouts.app>
