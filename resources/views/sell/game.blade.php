<x-layouts.stellar>
    <x-slot name="title">{{ __('Sell a Game Account') }} - {{ config('app.name') }}</x-slot>

<section class="relative pt-32 pb-12">
<div class="relative overflow-hidden bg-gradient-to-br from-slate-950 via-slate-900 to-slate-900">
    <!-- Animated Background Elements -->
    <div class="absolute inset-0 opacity-20">
        <div class="absolute top-20 left-10 w-96 h-96 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl animate-blob"></div>
        <div class="absolute top-40 right-10 w-96 h-96 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl animate-blob animation-delay-2000"></div>
        <div class="absolute bottom-20 left-40 w-96 h-96 bg-cyan-500 rounded-full mix-blend-multiply filter blur-3xl animate-blob animation-delay-4000"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Enhanced Header -->
        <div class="mb-8 animate-fade-in-down">
            <a href="{{ route('sell.index') }}" class="group inline-flex items-center text-purple-400 hover:text-purple-300 mb-6 transition-all duration-300">
                <div class="w-8 h-8 rounded-lg bg-blue-500/20 flex items-center justify-center mr-2 group-hover:bg-blue-500/30 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </div>
                <span class="font-medium">Back to product types</span>
            </a>
            
            <div class="flex items-center space-x-4 mb-4">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center shadow-lg shadow-indigo-500/40">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-5xl font-black mb-2 bg-clip-text text-transparent bg-gradient-to-r from-slate-200/70 via-slate-200 to-slate-200/70">
                        Sell a Game Account
                    </h1>
                    <p class="text-slate-300 text-lg">List your gaming account and start earning</p>
                </div>
            </div>
        </div>

        <!-- Enhanced KYC Banner -->
        @if($seller->kyc_status === 'pending')
        <div class="mb-8 animate-fade-in" id="kyc-banner">
            <div class="bg-gradient-to-r from-amber-900/30 to-orange-900/30 backdrop-blur-xl border border-amber-500/30 rounded-2xl p-6 shadow-xl">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 rounded-xl bg-yellow-500/20 flex items-center justify-center">
                            <svg class="w-6 h-6 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4 flex-1">
                        <h3 class="text-lg font-bold text-yellow-100 mb-1">⚡ KYC Verification Pending</h3>
                        <p class="text-yellow-200/90 text-sm leading-relaxed">You can save drafts, but published listings may have limited visibility until verified. Payouts available after verification.</p>
                    </div>
                    <button onclick="document.getElementById('kyc-banner').remove()" class="flex-shrink-0 ml-4 text-yellow-400 hover:text-yellow-300 transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        @endif

        <form action="{{ route('sell.game.store') }}" method="POST" enctype="multipart/form-data" id="game-form" class="animate-fade-in animation-delay-200">
            @csrf
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Enhanced Form Column -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Basic Information Card -->
                    <div class="bg-slate-800/60 backdrop-blur-xl border border-slate-700/50 rounded-2xl p-8 shadow-2xl">
                        <div class="flex items-center mb-6">
                            <div class="w-10 h-10 rounded-xl bg-indigo-500/20 flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-slate-100">Basic Information</h2>
                        </div>
                        
                        <div class="space-y-6">
                            <!-- Enhanced Title Input -->
                            <div class="group">
                                <label for="title" class="block text-sm font-semibold text-gray-300 mb-3 flex items-center">
                                    <span>Listing Title</span>
                                    <span class="ml-2 text-red-400">*</span>
                                </label>
                                <input type="text" name="title" id="title" value="{{ old('title') }}" required maxlength="190"
                                    placeholder="e.g., Level 90 Account • Rare Skins • 500+ Hours"
                                    class="w-full px-5 py-4 bg-slate-900/60 border-2 border-slate-700/60 rounded-xl text-white placeholder-slate-400 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300 group-hover:border-slate-600 @error('title') border-red-500 @enderror">
                                @error('title')
                                    <p class="mt-2 text-sm text-red-400 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Enhanced Category Select -->
                                <div class="group">
                                    <label for="game_category" class="block text-sm font-semibold text-gray-300 mb-3">Category</label>
                                    <div class="relative">
                                        <select name="game_category" id="game_category"
                                            class="w-full px-5 py-4 bg-slate-900/60 border-2 border-slate-700/60 rounded-xl text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300 appearance-none group-hover:border-slate-600">
                                            <option value="fortnite" {{ old('game_category') == 'fortnite' ? 'selected' : '' }}>
                                                Fortnite
                                            </option>
                                            <option value="whiteout_survival" {{ old('game_category') == 'whiteout_survival' ? 'selected' : '' }}>Whiteout Survival</option>
                                            <option value="others" {{ old('game_category') == 'others' ? 'selected' : '' }}>Others</option>
                                        </select>
                                        <div class="absolute right-4 top-1/2 transform -translate-y-1/2 pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                <!-- Enhanced Platform Select -->
                                <div class="group">
                                    <label for="platform" class="block text-sm font-semibold text-gray-300 mb-3 flex items-center">
                                        <span>Platform</span>
                                        <span class="ml-2 text-red-400">*</span>
                                    </label>
                                    <div class="relative">
                                        <select name="platform" id="platform" required
                                            class="w-full px-5 py-4 bg-slate-900/60 border-2 border-slate-700/60 rounded-xl text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300 appearance-none group-hover:border-slate-600 @error('platform') border-red-500 @enderror">
                                            <option value="Mobile" {{ old('platform') == 'Mobile' ? 'selected' : '' }}>📱 Mobile</option>
                                            <option value="PC" {{ old('platform') == 'PC' ? 'selected' : '' }}>💻 PC</option>
                                            <option value="PlayStation" {{ old('platform') == 'PlayStation' ? 'selected' : '' }}>🎮 PlayStation</option>
                                            <option value="Xbox" {{ old('platform') == 'Xbox' ? 'selected' : '' }}>🎮 Xbox</option>
                                            <option value="Nintendo" {{ old('platform') == 'Nintendo' ? 'selected' : '' }}>🎮 Nintendo</option>
                                            <option value="Other" {{ old('platform') == 'Other' ? 'selected' : '' }}>🎯 Other</option>
                                        </select>
                                        <div class="absolute right-4 top-1/2 transform -translate-y-1/2 pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </div>
                                    </div>
                                    @error('platform')
                                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Enhanced Description -->
                            <div class="group">
                                <label for="description" class="block text-sm font-semibold text-gray-300 mb-3 flex items-center justify-between">
                                    <span class="flex items-center">
                                        <span>Account Description</span>
                                        <span class="ml-2 text-red-400">*</span>
                                    </span>
                                    <span class="text-xs text-gray-500">Min. 50 characters</span>
                                </label>
                                <textarea name="description" id="description" rows="8" required minlength="50"
                                    placeholder="Describe your account in detail... Include level, items, achievements, etc."
                                    class="w-full px-5 py-4 bg-slate-900/60 border-2 border-slate-700/60 rounded-xl text-white placeholder-slate-400 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300 resize-none group-hover:border-slate-600 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                                <div class="mt-3 flex items-start text-sm text-gray-400">
                                    <svg class="w-4 h-4 mr-2 mt-0.5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>Add accurate details. Avoid external contact info.</span>
                                </div>
                                @error('description')
                                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Enhanced Price Input -->
                            <div class="group">
                                <label for="price" class="block text-sm font-semibold text-gray-300 mb-3 flex items-center">
                                    <span>Price (USD)</span>
                                    <span class="ml-2 text-red-400">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute left-5 top-1/2 transform -translate-y-1/2 text-slate-400 text-xl font-bold">$</span>
                                    <input type="number" name="price" id="price" value="{{ old('price') }}" step="0.01" min="0.01" required
                                        placeholder="0.00"
                                        class="w-full pl-12 pr-5 py-4 bg-slate-900/60 border-2 border-slate-700/60 rounded-xl text-white text-xl font-semibold placeholder-slate-400 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300 group-hover:border-slate-600 @error('price') border-red-500 @enderror">
                                </div>
                                @error('price')
                                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Whiteout Survival Checklist -->
                    <div id="whiteout-survival-checklist" class="hidden bg-slate-800/60 backdrop-blur-xl border border-slate-700/50 rounded-2xl p-8 shadow-2xl">
                        <div class="flex items-center mb-6">
                            <div class="w-10 h-10 rounded-xl bg-blue-500/20 flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-slate-100">Whiteout Survival Checklist</h2>
                        </div>
                        <p class="text-slate-400 text-sm mb-6">Additional checklist items specific to Whiteout Survival game accounts</p>
                        
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-4 bg-slate-700/30 rounded-xl border border-slate-600/30">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-blue-500/20 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                        </svg>
                                    </div>
                                    <span class="text-slate-200 font-medium">مربوط بالفيس بوك؟</span>
                                </div>
                                <div class="flex gap-2">
                                    <label class="flex items-center">
                                        <input type="radio" name="whiteout_survival_checklist[linked_to_facebook]" value="yes" class="form-radio text-green-500">
                                        <span class="ml-2 text-green-400">نعم</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="radio" name="whiteout_survival_checklist[linked_to_facebook]" value="no" class="form-radio text-red-500">
                                        <span class="ml-2 text-red-400">لا</span>
                                    </label>
                                </div>
                            </div>

                            <div class="flex items-center justify-between p-4 bg-slate-700/30 rounded-xl border border-slate-600/30">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-blue-500/20 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9"/>
                                        </svg>
                                    </div>
                                    <span class="text-slate-200 font-medium">مربوط بقوقل؟</span>
                                </div>
                                <div class="flex gap-2">
                                    <label class="flex items-center">
                                        <input type="radio" name="whiteout_survival_checklist[linked_to_google]" value="yes" class="form-radio text-green-500">
                                        <span class="ml-2 text-green-400">نعم</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="radio" name="whiteout_survival_checklist[linked_to_google]" value="no" class="form-radio text-red-500">
                                        <span class="ml-2 text-red-400">لا</span>
                                    </label>
                                </div>
                            </div>

                            <div class="flex items-center justify-between p-4 bg-slate-700/30 rounded-xl border border-slate-600/30">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-blue-500/20 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <span class="text-slate-200 font-medium">مربوط بأبل؟</span>
                                </div>
                                <div class="flex gap-2">
                                    <label class="flex items-center">
                                        <input type="radio" name="whiteout_survival_checklist[linked_to_apple]" value="yes" class="form-radio text-green-500">
                                        <span class="ml-2 text-green-400">نعم</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="radio" name="whiteout_survival_checklist[linked_to_apple]" value="no" class="form-radio text-red-500">
                                        <span class="ml-2 text-red-400">لا</span>
                                    </label>
                                </div>
                            </div>

                            <div class="flex items-center justify-between p-4 bg-slate-700/30 rounded-xl border border-slate-600/30">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-blue-500/20 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                        </svg>
                                    </div>
                                    <span class="text-slate-200 font-medium">مربوط بقيم سنتر؟</span>
                                </div>
                                <div class="flex gap-2">
                                    <label class="flex items-center">
                                        <input type="radio" name="whiteout_survival_checklist[linked_to_game_center]" value="yes" class="form-radio text-green-500">
                                        <span class="ml-2 text-green-400">نعم</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="radio" name="whiteout_survival_checklist[linked_to_game_center]" value="no" class="form-radio text-red-500">
                                        <span class="ml-2 text-red-400">لا</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Enhanced Images Card -->
                    <div class="bg-slate-800/60 backdrop-blur-xl border border-slate-700/50 rounded-2xl p-8 shadow-2xl">
                        <div class="flex items-center mb-6">
                            <div class="w-10 h-10 rounded-xl bg-indigo-500/20 flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-slate-100">Account Screenshots</h2>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-gray-300 mb-4">Upload Images (Max 6, 5MB each)</label>
                            <div class="relative border-2 border-dashed border-slate-700/50 rounded-2xl p-12 text-center hover:border-indigo-500/50 transition-all duration-300 cursor-pointer group bg-slate-900/40" onclick="document.getElementById('images').click()">
                                <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/5 to-purple-500/5 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                <svg class="mx-auto h-16 w-16 text-gray-500 mb-4 group-hover:text-blue-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                                <p class="text-white text-lg font-medium mb-2">Click to upload or drag and drop</p>
                                <p class="text-gray-400">JPG, PNG or WebP • Maximum 5MB per file</p>
                            </div>
                            <input type="file" name="images[]" id="images" multiple accept="image/jpeg,image/png,image/webp" class="hidden" onchange="previewImages(event)">
                            
                            <!-- Image Previews -->
                            <div id="image-previews" class="grid grid-cols-3 gap-4 mt-6"></div>
                            
                            @error('images.*')
                                <p class="mt-3 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Enhanced Agreements Card -->
                    <div class="bg-slate-800/60 backdrop-blur-xl border border-slate-700/50 rounded-2xl p-8 shadow-2xl">
                        <div class="flex items-center mb-6">
                            <div class="w-10 h-10 rounded-xl bg-green-500/20 flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-slate-100">Terms & Agreements</h2>
                        </div>
                        
                        <div class="space-y-5">
                            <label class="flex items-start p-5 rounded-xl border-2 border-slate-700/50 hover:border-indigo-500/50 cursor-pointer group transition-all duration-300 bg-slate-900/40">
                                <input type="checkbox" name="agree_no_external_contact" value="1" required
                                    class="mt-1 w-5 h-5 bg-gray-800 border-2 border-gray-600 rounded text-blue-600 focus:ring-2 focus:ring-blue-500 transition-all">
                                <span class="ml-4 text-gray-300 group-hover:text-white transition-colors leading-relaxed">
                                    I will not include external contact information in this listing.
                                </span>
                            </label>
                            @error('agree_no_external_contact')
                                <p class="ml-9 text-sm text-red-400">{{ $message }}</p>
                            @enderror

                            <label class="flex items-start p-5 rounded-xl border-2 border-slate-700/50 hover:border-indigo-500/50 cursor-pointer group transition-all duration-300 bg-slate-900/40">
                                <input type="checkbox" name="agree_legal_responsibility" value="1" required
                                    class="mt-1 w-5 h-5 bg-gray-800 border-2 border-gray-600 rounded text-blue-600 focus:ring-2 focus:ring-blue-500 transition-all">
                                <span class="ml-4 text-gray-300 group-hover:text-white transition-colors leading-relaxed">
                                    I accept full legal responsibility for the account on sale and confirm that it complies with the platform rules.
                                </span>
                            </label>
                            @error('agree_legal_responsibility')
                                <p class="ml-9 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Enhanced Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4">
                        <button type="submit" id="btn-list-game" 
                            data-flow="game"
                            class="flex-1 group relative overflow-hidden bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-bold py-5 px-8 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg shadow-indigo-500/40">
                            <span class="relative z-10 flex items-center justify-center text-lg">
                                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                List Account
                            </span>
                            <div class="absolute inset-0 bg-gradient-to-r from-purple-600 to-pink-600 transform translate-y-full group-hover:translate-y-0 transition-transform duration-300"></div>
                        </button>
                        
                        <button type="submit" name="action" value="draft"
                            class="flex-1 bg-slate-900/40 backdrop-blur-sm hover:bg-slate-900/60 border-2 border-slate-700/50 hover:border-slate-600 text-white font-bold py-5 px-8 rounded-xl transition-all duration-300 text-lg">
                            <span class="flex items-center justify-center">
                                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                                </svg>
                                Save as Draft
                            </span>
                        </button>
                    </div>
                </div>

                <!-- Enhanced Preview Panel -->
                <div class="lg:col-span-1">
                    <div class="bg-slate-800/60 backdrop-blur-xl border border-slate-700/50 rounded-2xl p-6 shadow-2xl sticky top-8">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-bold text-white">Live Preview</h3>
                            <div class="flex items-center space-x-1">
                                <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                                <span class="text-xs text-gray-400">Real-time</span>
                            </div>
                        </div>
                        
                        <div class="space-y-6">
                            <!-- Platform Badge -->
                            <div class="relative">
                                <div class="absolute inset-0 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-2xl blur-xl opacity-50"></div>
                                <div class="relative w-20 h-20 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center overflow-hidden">
                                    <img id="preview-game-icon" src="https://cdn.simpleicons.org/fortnite/ffffff" alt="game" class="w-12 h-12">
                                </div>
                            </div>

                            <!-- Title -->
                            <div>
                                <h4 id="preview-title" class="text-2xl font-bold text-white leading-tight mb-2">Your listing title will appear here</h4>
                                <div class="flex items-center space-x-2">
                                    <span id="preview-platform" class="text-sm px-3 py-1 bg-blue-500/20 text-blue-300 rounded-full font-medium">Mobile</span>
                                </div>
                            </div>

                            <!-- Seller Info -->
                            <div class="flex items-center space-x-3 pt-4 border-t border-white/10">
                                <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center text-white font-bold text-lg shadow-lg">
                                    {{ substr($seller->display_name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400">Seller</p>
                                    <p class="text-white font-semibold">{{ $seller->display_name }}</p>
                                </div>
                            </div>

                            <!-- Price -->
                            <div class="pt-4 border-t border-white/10">
                                <p class="text-sm text-gray-400 mb-2">Listing Price</p>
                                <p id="preview-price" class="text-4xl font-black text-transparent bg-gradient-to-r from-indigo-300 to-purple-300 bg-clip-text">$0.00</p>
                            </div>

                            <!-- Live Indicator -->
                            <div class="pt-4 border-t border-white/10">
                                <div class="flex items-center text-xs text-gray-500">
                                    <div class="flex items-center mr-3">
                                        <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse mr-2"></div>
                                        <span>Updates as you type</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
// Live preview updates with smooth transitions
document.getElementById('title').addEventListener('input', function(e) {
    const previewElement = document.getElementById('preview-title');
    previewElement.style.opacity = '0.5';
    setTimeout(() => {
        previewElement.textContent = e.target.value || 'Your listing title will appear here';
        previewElement.style.opacity = '1';
    }, 100);
});

document.getElementById('platform').addEventListener('change', function(e) {
    const previewElement = document.getElementById('preview-platform');
    previewElement.style.opacity = '0.5';
    setTimeout(() => {
        previewElement.textContent = e.target.value;
        previewElement.style.opacity = '1';
    }, 100);
});

document.getElementById('price').addEventListener('input', function(e) {
    const previewElement = document.getElementById('preview-price');
    previewElement.style.opacity = '0.5';
    setTimeout(() => {
        const price = parseFloat(e.target.value) || 0;
        previewElement.textContent = '$' + price.toFixed(2);
        previewElement.style.opacity = '1';
    }, 100);
});

// Enhanced image preview
function previewImages(event) {
    const files = event.target.files;
    const previewContainer = document.getElementById('image-previews');
    previewContainer.innerHTML = '';
    
    if (files.length > 6) {
        alert('⚠️ Maximum 6 images allowed');
        event.target.value = '';
        return;
    }
    
    Array.from(files).forEach((file, index) => {
        if (file.size > 5242880) {
            alert(`⚠️ ${file.name} is too large. Maximum size is 5MB.`);
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            const div = document.createElement('div');
            div.className = 'relative group animate-fade-in';
            div.innerHTML = `
                <div class="relative overflow-hidden rounded-xl border-2 border-gray-700/50 group-hover:border-blue-500/50 transition-all duration-300">
                    <img src="${e.target.result}" class="w-full h-32 object-cover transform group-hover:scale-110 transition-transform duration-300">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    <div class="absolute bottom-2 left-2 px-3 py-1 ${index === 0 ? 'bg-blue-600' : 'bg-purple-600'} text-white text-xs font-bold rounded-full shadow-lg">
                        ${index === 0 ? '⭐ Thumbnail' : `Image ${index + 1}`}
                    </div>
                </div>
            `;
            previewContainer.appendChild(div);
        };
        reader.readAsDataURL(file);
    });
}

// Add transition styles
document.querySelectorAll('#preview-title, #preview-platform, #preview-price').forEach(el => {
    el.style.transition = 'opacity 0.3s ease';
});
</script>

@endpush

@push('styles')
<style>
@keyframes blob {
    0%, 100% { transform: translate(0, 0) scale(1); }
    25% { transform: translate(20px, -50px) scale(1.1); }
    50% { transform: translate(-20px, 20px) scale(0.9); }
    75% { transform: translate(50px, 50px) scale(1.05); }
}

@keyframes fade-in-down {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fade-in {
    from { opacity: 0; }
    to { opacity: 1; }
}

.animate-blob {
    animation: blob 7s infinite;
}

.animate-fade-in-down {
    animation: fade-in-down 0.6s ease-out;
}

.animate-fade-in {
    animation: fade-in 0.6s ease-out;
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

@include('sell.partials.listing-modals')

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const btn = document.getElementById('btn-list-game');
    if (btn) btn.addEventListener('click', function() {
        if (window.NetroSellFlow && typeof window.NetroSellFlow.open === 'function') {
            window.NetroSellFlow.open('game');
        } else {
            // Fallback: ensure component exists then retry shortly
            setTimeout(() => window.NetroSellFlow && window.NetroSellFlow.open('game'), 100);
        }
    });
    // Game category icon mapping
    const gameIconMap = {
        'fortnite': 'https://cdn.simpleicons.org/fortnite/ffffff',
        'whiteout_survival': 'https://cdn.simpleicons.org/discord/ffffff',
        'others': 'https://cdn.simpleicons.org/gamepad/ffffff'
    };
    const gameSelect = document.getElementById('game_category');
    const gameIcon = document.getElementById('preview-game-icon');
    function updateGameIcon() {
        const key = gameSelect ? gameSelect.value : 'others';
        if (gameIcon) gameIcon.src = gameIconMap[key] || gameIconMap['others'];
    }
    if (gameSelect) { updateGameIcon(); gameSelect.addEventListener('change', updateGameIcon); }
    
    // Whiteout Survival Checklist Toggle
    const whiteoutChecklist = document.getElementById('whiteout-survival-checklist');
    function toggleWhiteoutChecklist() {
        const selectedCategory = gameSelect ? gameSelect.value : '';
        if (selectedCategory === 'whiteout_survival') {
            whiteoutChecklist.classList.remove('hidden');
        } else {
            whiteoutChecklist.classList.add('hidden');
        }
    }
    
    if (gameSelect) {
        gameSelect.addEventListener('change', toggleWhiteoutChecklist);
        toggleWhiteoutChecklist(); // Check on page load
    }
});
</script>
@endpush

</x-layouts.stellar>
