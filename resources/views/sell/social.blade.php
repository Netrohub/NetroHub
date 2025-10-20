<x-layouts.app>
    <x-slot name="title">{{ __('Sell a Social Account') }} - {{ config('app.name') }}</x-slot>

<section class="relative pt-32 pb-12">
<div class="min-h-screen relative overflow-hidden bg-gradient-to-br from-slate-950 via-slate-900 to-slate-900">
    <!-- Animated Background Elements -->
    <div class="absolute inset-0 opacity-20">
        <div class="absolute top-20 left-10 w-96 h-96 bg-pink-500 rounded-full mix-blend-multiply filter blur-3xl animate-blob"></div>
        <div class="absolute top-40 right-10 w-96 h-96 bg-red-500 rounded-full mix-blend-multiply filter blur-3xl animate-blob animation-delay-2000"></div>
        <div class="absolute bottom-20 left-40 w-96 h-96 bg-rose-500 rounded-full mix-blend-multiply filter blur-3xl animate-blob animation-delay-4000"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Enhanced Header -->
        <div class="mb-8 animate-fade-in-down">
            <a href="{{ route('sell.index') }}" class="group inline-flex items-center text-purple-400 hover:text-purple-300 mb-6 transition-all duration-300">
                <div class="w-8 h-8 rounded-lg bg-pink-500/20 flex items-center justify-center mr-2 group-hover:bg-pink-500/30 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </div>
                <span class="font-medium">Back to product types</span>
            </a>
            
            <div class="flex items-center space-x-4 mb-4">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-purple-500 to-indigo-600 flex items-center justify-center shadow-lg shadow-purple-500/40">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-5xl font-black mb-2 bg-clip-text text-transparent bg-gradient-to-r from-slate-200/70 via-slate-200 to-slate-200/70">
                        Sell a Social Account
                    </h1>
                    <p class="text-slate-300 text-lg">List your social media account and monetize your influence</p>
                </div>
            </div>
        </div>

        <!-- Enhanced Policy Block -->
        <div class="mb-8 animate-fade-in">
            <div class="relative overflow-hidden bg-gradient-to-r from-slate-800/70 to-slate-900/70 backdrop-blur-xl border border-purple-500/30 rounded-2xl p-8 shadow-2xl">
                <div class="absolute top-0 right-0 w-64 h-64 bg-red-500/10 rounded-full blur-3xl"></div>
                <div class="relative flex items-start">
                    <div class="flex-shrink-0">
                        <div class="w-14 h-14 rounded-2xl bg-purple-500/20 flex items-center justify-center shadow-lg">
                            <svg class="w-7 h-7 text-purple-300" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-6">
                        <h3 class="text-2xl font-black text-slate-100 mb-4 flex items-center">
                            <span>⚠️ Important Selling Rules & Policy</span>
                        </h3>
                        <ul class="space-y-3 text-slate-200">
                            <li class="flex items-start group">
                                <svg class="w-5 h-5 mr-3 mt-0.5 text-purple-300 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span class="group-hover:text-white transition-colors">You may <strong>NOT</strong> sell accounts with illegal content, stolen credentials, or that violate platform ToS.</span>
                            </li>
                            <li class="flex items-start group">
                                <svg class="w-5 h-5 mr-3 mt-0.5 text-purple-300 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span class="group-hover:text-white transition-colors">You may <strong>NOT</strong> impersonate others or misrepresent account ownership or authenticity.</span>
                            </li>
                            <li class="flex items-start group">
                                <svg class="w-5 h-5 mr-3 mt-0.5 text-purple-300 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span class="group-hover:text-white transition-colors">All accounts must comply with the original platform's policies and local laws.</span>
                            </li>
                            <li class="flex items-start group">
                                <svg class="w-5 h-5 mr-3 mt-0.5 text-purple-300 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span class="group-hover:text-white transition-colors">Provide accurate information about followers, engagement, monetization, and account access.</span>
                            </li>
                            <li class="flex items-start group">
                                <svg class="w-5 h-5 mr-3 mt-0.5 text-purple-300 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span class="group-hover:text-white transition-colors">You are solely responsible for any claims or disputes arising from the sale.</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <form action="{{ route('sell.social.store') }}" method="POST" enctype="multipart/form-data" id="social-form" class="animate-fade-in animation-delay-200">
            @csrf
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Enhanced Form Column -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Account Information Card -->
                    <div class="bg-slate-800/60 backdrop-blur-xl border border-slate-700/50 rounded-2xl p-8 shadow-2xl">
                        <div class="flex items-center mb-6">
                            <div class="w-10 h-10 rounded-xl bg-purple-500/20 flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-slate-100">Account Information</h2>
                        </div>
                        
                        <div class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Enhanced Platform Select -->
                                <div class="group">
                                    <label for="platform" class="block text-sm font-semibold text-slate-300 mb-3 flex items-center">
                                        <span>Platform</span>
                                        <span class="ml-2 text-red-400">*</span>
                                    </label>
                                    <div class="relative">
                                        <select name="platform" id="platform" required
                                            class="w-full px-5 py-4 bg-slate-900/60 border-2 border-slate-700/60 rounded-xl text-white focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-300 appearance-none group-hover:border-slate-600 @error('platform') border-red-500 @enderror">
                                            <option value="Instagram" {{ old('platform') == 'Instagram' ? 'selected' : 'selected' }}>📸 Instagram</option>
                                            <option value="TikTok" {{ old('platform') == 'TikTok' ? 'selected' : '' }}>🎵 TikTok</option>
                                            <option value="X (Twitter)" {{ old('platform') == 'X (Twitter)' ? 'selected' : '' }}>🐦 X (Twitter)</option>
                                            <option value="YouTube" {{ old('platform') == 'YouTube' ? 'selected' : '' }}>📺 YouTube</option>
                                            <option value="Discord" {{ old('platform') == 'Discord' ? 'selected' : '' }}>💬 Discord</option>
                                            <option value="Other" {{ old('platform') == 'Other' ? 'selected' : '' }}>🌐 Other</option>
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

                                <!-- Enhanced Handle Input -->
                                <div class="group">
                                    <label for="handle" class="block text-sm font-semibold text-slate-300 mb-3 flex items-center">
                                        <span>Username / Handle</span>
                                        <span class="ml-2 text-red-400">*</span>
                                    </label>
                                    <div class="relative">
                                        <span class="absolute left-5 top-1/2 transform -translate-y-1/2 text-pink-400 font-bold">@</span>
                                        <input type="text" name="handle" id="handle" value="{{ old('handle') }}" required
                                            placeholder="yourhandle"
                                            class="w-full pl-10 pr-5 py-4 bg-slate-900/60 border-2 border-slate-700/60 rounded-xl text-white placeholder-slate-400 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-300 group-hover:border-slate-600 @error('handle') border-red-500 @enderror">
                                    </div>
                                    @error('handle')
                                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>


                            <!-- Enhanced Title Input -->
                            <div class="group">
                                <label for="title" class="block text-sm font-semibold text-slate-300 mb-3 flex items-center">
                                    <span>Listing Title</span>
                                    <span class="ml-2 text-red-400">*</span>
                                </label>
                                <input type="text" name="title" id="title" value="{{ old('title') }}" required maxlength="190"
                                    placeholder="e.g., 50K Instagram Gaming Account • High Engagement"
                                    class="w-full px-5 py-4 bg-slate-900/60 border-2 border-slate-700/60 rounded-xl text-white placeholder-slate-400 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-300 group-hover:border-slate-600 @error('title') border-red-500 @enderror">
                                @error('title')
                                    <p class="mt-2 text-sm text-red-400 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Enhanced Description -->
                            <div class="group">
                                <label for="description" class="block text-sm font-semibold text-slate-300 mb-3 flex items-center justify-between">
                                    <span class="flex items-center">
                                        <span>Account Description</span>
                                        <span class="ml-2 text-red-400">*</span>
                                    </span>
                                    <span class="text-xs text-gray-500">Min. 50 characters</span>
                                </label>
                                <textarea name="description" id="description" rows="6" required minlength="50"
                                    placeholder="Describe the account, its content, engagement, and what makes it valuable..."
                                    class="w-full px-5 py-4 bg-slate-900/60 border-2 border-slate-700/60 rounded-xl text-white placeholder-slate-400 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-300 resize-none group-hover:border-slate-600 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                                <div class="mt-3 p-4 bg-yellow-900/20 border border-yellow-500/30 rounded-xl flex items-start text-sm">
                                    <svg class="w-5 h-5 text-yellow-400 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="text-yellow-200">Do not add external contact details in the description.</span>
                                </div>
                                @error('description')
                                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>


                            <!-- Enhanced Price Input -->
                            <div class="group">
                                <label for="price" class="block text-sm font-semibold text-slate-300 mb-3 flex items-center">
                                    <span>Price (USD)</span>
                                    <span class="ml-2 text-red-400">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute left-5 top-1/2 transform -translate-y-1/2 text-gray-400 text-xl font-bold">$</span>
                                    <input type="number" name="price" id="price" value="{{ old('price') }}" step="0.01" min="0.01" required
                                        placeholder="0.00"
                                        class="w-full pl-12 pr-5 py-4 bg-slate-900/60 border-2 border-slate-700/60 rounded-xl text-white text-xl font-semibold placeholder-slate-400 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-300 group-hover:border-slate-600 @error('price') border-red-500 @enderror">
                                </div>
                                @error('price')
                                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>


                    <!-- Social Media Account Legal Agreement -->
                    <div class="bg-slate-800/60 backdrop-blur-xl border border-slate-700/50 rounded-2xl p-8 shadow-2xl">
                        <div class="flex items-center mb-6">
                            <div class="w-10 h-10 rounded-xl bg-amber-500/20 flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-slate-100">Legal Agreement</h2>
                        </div>
                        
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
                                    I agree to the above terms and conditions
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
                            <label class="flex items-start p-5 rounded-xl border-2 border-slate-700/50 hover:border-purple-500/50 cursor-pointer group transition-all duration-300 bg-slate-900/40">
                                <input type="checkbox" name="agree_no_external_contact" value="1" required
                                    class="mt-1 w-5 h-5 bg-gray-800 border-2 border-gray-600 rounded text-pink-600 focus:ring-2 focus:ring-pink-500 transition-all">
                                <span class="ml-4 text-gray-300 group-hover:text-white transition-colors leading-relaxed">
                                    I will not include external contact information in the listing.
                                </span>
                            </label>
                            @error('agree_no_external_contact')
                                <p class="ml-9 text-sm text-red-400">{{ $message }}</p>
                            @enderror

                            <label class="flex items-start p-5 rounded-xl border-2 border-slate-700/50 hover:border-purple-500/50 cursor-pointer group transition-all duration-300 bg-slate-900/40">
                                <input type="checkbox" name="agree_legal_responsibility" value="1" required
                                    class="mt-1 w-5 h-5 bg-gray-800 border-2 border-gray-600 rounded text-pink-600 focus:ring-2 focus:ring-pink-500 transition-all">
                                <span class="ml-4 text-gray-300 group-hover:text-white transition-colors leading-relaxed">
                                    I accept full legal responsibility for the content and confirm compliance with platform rules and local laws.
                                </span>
                            </label>
                            @error('agree_legal_responsibility')
                                <p class="ml-9 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Enhanced Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4">
                        <button type="submit" id="btn-list-social" data-flow="social"
                            class="flex-1 group relative overflow-hidden bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-bold py-5 px-8 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg shadow-purple-500/40">
                            <span class="relative z-10 flex items-center justify-center text-lg">
                                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                List Account
                            </span>
                            <div class="absolute inset-0 bg-gradient-to-r from-red-600 to-rose-600 transform translate-y-full group-hover:translate-y-0 transition-transform duration-300"></div>
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
                                <div class="w-2 h-2 bg-pink-400 rounded-full animate-pulse"></div>
                                <span class="text-xs text-gray-400">Real-time</span>
                            </div>
                        </div>
                        
                        <div class="space-y-6">
                            <!-- Platform Badge -->
                            <div class="relative">
                                <div class="absolute inset-0 bg-gradient-to-r from-purple-500 to-indigo-600 rounded-2xl blur-xl opacity-50"></div>
                                <div class="relative w-20 h-20 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-2xl flex items-center justify-center overflow-hidden">
                                    <img id="preview-platform-icon" src="https://cdn.simpleicons.org/instagram/ffffff" alt="platform" class="w-12 h-12">
                                </div>
                            </div>

                            <!-- Handle & Platform -->
                            <div>
                                <div class="flex items-center space-x-2">
                                    <span id="preview-platform" class="text-sm px-3 py-1 bg-purple-500/20 text-purple-200 rounded-full font-medium">Instagram</span>
                                </div>
                            </div>

                            <!-- Title -->
                            <div class="pt-4 border-t border-white/10">
                                <h4 id="preview-title" class="text-lg font-semibold text-white leading-tight">Your listing title will appear here</h4>
                            </div>


                            <!-- Seller Info -->
                            <div class="flex items-center space-x-3 pt-4 border-t border-white/10">
                                <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-xl flex items-center justify-center text-white font-bold text-lg shadow-lg">
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
                                <p id="preview-price" class="text-4xl font-black text-transparent bg-gradient-to-r from-purple-300 to-indigo-300 bg-clip-text">$0.00</p>
                            </div>

                            <!-- Live Indicator -->
                            <div class="pt-4 border-t border-white/10">
                                <div class="flex items-center text-xs text-gray-500">
                                    <div class="flex items-center mr-3">
                                        <div class="w-2 h-2 bg-pink-400 rounded-full animate-pulse mr-2"></div>
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
    // Removed conflicting JavaScript - verification modal is handled below
    // Platform icon mapping
    const iconMap = {
        'Instagram': 'https://cdn.simpleicons.org/instagram/ffffff',
        'TikTok': 'https://cdn.simpleicons.org/tiktok/ffffff',
        'X (Twitter)': 'https://cdn.simpleicons.org/x/ffffff',
        'YouTube': 'https://cdn.simpleicons.org/youtube/ffffff',
        'Discord': 'https://cdn.simpleicons.org/discord/ffffff',
        'Other': 'https://cdn.simpleicons.org/globe/ffffff'
    };
    const select = document.getElementById('platform');
    const iconEl = document.getElementById('preview-platform-icon');
    const badge = document.getElementById('preview-platform');
    function updateIcon() {
        const label = select.value;
        iconEl.src = iconMap[label] || iconMap['Other'];
        if (badge) badge.textContent = label;
    }
    updateIcon();
    select.addEventListener('change', updateIcon);
    
    // Social Account Verification
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
        const platform = document.getElementById('platform').value;
        const handle = document.getElementById('handle').value;
        
        if (!platform || !handle) {
            showError('Please select a platform and enter a handle first.');
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
                username: handle
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
            startVerificationBtn.textContent = 'Start';
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
            verifyOwnershipBtn.textContent = 'Verify';
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
    
    // Form validation and modal handling
    const form = document.querySelector('form');
    const verificationModal = document.getElementById('verification-modal');
    const closeModalBtn = document.getElementById('close-verification-modal');
    const proceedToSubmitBtn = document.getElementById('proceed-to-submit');
    const listAccountBtn = document.getElementById('btn-list-social');
    
    
    if (form) {
        form.addEventListener('submit', function(e) {
            // Only prevent default if it's not the draft action
            if (e.submitter && e.submitter.value === 'draft') {
                return; // Allow draft submission
            }
            
            // For List Account button, show verification modal
            if (e.submitter && e.submitter.id === 'btn-list-social') {
                e.preventDefault();
                console.log('List Account button clicked, preventing default submission');
                
                const legalAgreementCheckbox = document.getElementById('legal_agreement');
                const legalAgreementError = document.getElementById('legal_agreement_error');
                
                // Check if legal agreement is required
                if (!legalAgreementCheckbox || !legalAgreementCheckbox.checked) {
                    console.log('Legal agreement not checked, showing error');
                    if (legalAgreementError) {
                        legalAgreementError.classList.remove('hidden');
                    }
                    if (legalAgreementCheckbox) {
                        legalAgreementCheckbox.focus();
                    }
                    return false;
                } else {
                    console.log('Legal agreement checked, hiding error');
                    if (legalAgreementError) {
                        legalAgreementError.classList.add('hidden');
                    }
                }
                
                // Show verification modal
                console.log('Showing verification modal');
                showVerificationModal();
                return false;
            }
            
            // If no specific handler, allow normal form submission
        });
    }
    
    // Modal controls
    if (closeModalBtn) {
        closeModalBtn.addEventListener('click', hideVerificationModal);
    }
    
    if (proceedToSubmitBtn) {
        proceedToSubmitBtn.addEventListener('click', function() {
            console.log('Proceed to submit button clicked');
            hideVerificationModal();
            // Submit the form
            console.log('Submitting form');
            if (form) {
                form.submit();
            } else {
                console.error('Form element not found');
            }
        });
    } else {
        console.error('Proceed to submit button not found');
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
        console.log('showVerificationModal called');
        if (verificationModal) {
            console.log('Showing verification modal');
            verificationModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        } else {
            console.error('Verification modal element not found');
        }
    }
    
    function hideVerificationModal() {
        console.log('hideVerificationModal called');
        if (verificationModal) {
            verificationModal.classList.add('hidden');
            document.body.style.overflow = 'auto';
            resetVerificationState();
        }
    }
    
    function resetVerificationState() {
        // Reset verification modal to step 1
        const verificationStep1 = document.getElementById('verification_step_1');
        const verificationStep2 = document.getElementById('verification_step_2');
        const verificationSuccess = document.getElementById('verification_success');
        const verificationError = document.getElementById('verification_error');
        
        if (verificationStep1) verificationStep1.classList.remove('hidden');
        if (verificationStep2) verificationStep2.classList.add('hidden');
        if (verificationSuccess) verificationSuccess.classList.add('hidden');
        if (verificationError) verificationError.classList.add('hidden');
    }
});
 </script>
@endpush

</x-layouts.app>
