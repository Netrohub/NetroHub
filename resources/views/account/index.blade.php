@extends('layouts.app')

@section('content')
<div class="min-h-screen relative overflow-hidden bg-dark-900 py-10">
    <!-- Gaming Background Effects -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-primary-500/5 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-1/4 right-1/4 w-80 h-80 bg-secondary-500/5 rounded-full blur-3xl animate-float animation-delay-2000"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-black text-white mb-2 bg-gaming-gradient bg-clip-text text-transparent">Account Settings</h1>
            <p class="text-muted-300">Manage your profile and preferences</p>
            </div>

        <!-- Success/Error Messages -->
                    @if(session('success'))
        <x-ui.card variant="glass" class="bg-green-500/10 border-green-500/30 mb-6" :hover="false">
                            <div class="flex items-center gap-3">
                                <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <p class="text-green-400 font-semibold">{{ session('success') }}</p>
                            </div>
                        </x-ui.card>
                    @endif

                    @if($errors->any())
        <x-ui.card variant="glass" class="bg-red-500/10 border-red-500/30 mb-6" :hover="false">
                            <div class="flex items-start gap-3">
                                <svg class="w-6 h-6 text-red-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <div class="flex-1">
                                    <p class="text-red-400 font-semibold mb-2">Please fix the following errors:</p>
                    <ul class="list-disc list-inside text-red-300 space-y-1 text-sm">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </x-ui.card>
                    @endif

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            
            <!-- Left Sidebar - Navigation -->
            <div class="lg:col-span-1">
                <x-ui.card variant="glass" class="sticky top-6" :hover="false">
                    <!-- Quick Stats -->
                    <div class="text-center mb-6 pb-6 border-b border-gaming/30">
                        <div class="relative inline-block mb-4">
                            <div class="w-20 h-20 rounded-2xl overflow-hidden bg-gaming-gradient shadow-gaming">
                                <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                            </div>
                            <div class="absolute bottom-0 right-0 w-5 h-5 bg-neon-green rounded-full border-2 border-dark-800"></div>
                        </div>
                        <h3 class="text-lg font-bold text-white">{{ $seller->display_name ?? $user->name }}</h3>
                        <p class="text-sm text-muted-400">{{ '@' . ($user->username ?? Str::slug($user->name)) }}</p>
                    </div>

                    <!-- Navigation Tabs -->
                    <nav class="space-y-1">
                        <a href="?tab=my-account" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ $tab === 'my-account' ? 'bg-gaming-gradient text-white shadow-gaming' : 'text-muted-300 hover:text-white hover:bg-dark-800/30' }} transition font-medium">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            My Account
                        </a>
                        <a href="?tab=sales" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ $tab === 'sales' ? 'bg-gaming-gradient text-white shadow-gaming' : 'text-muted-300 hover:text-white hover:bg-dark-800/30' }} transition font-medium">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            My Sales
                        </a>
                        <a href="?tab=reviews" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ $tab === 'reviews' ? 'bg-gaming-gradient text-white shadow-gaming' : 'text-muted-300 hover:text-white hover:bg-dark-800/30' }} transition font-medium">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                            </svg>
                            Reviews
                        </a>
                        <a href="?tab=social" class="flex items-center gap-3 px-4 py-3 rounded-xl {{ $tab === 'social' ? 'bg-gaming-gradient text-white shadow-gaming' : 'text-muted-300 hover:text-white hover:bg-dark-800/30' }} transition font-medium">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            Social Accounts
                        </a>
                    </nav>

                    <!-- Quick Stats -->
                    @if($seller)
                    <div class="mt-6 pt-6 border-t border-gaming/30 space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-muted-400">Total Sales</span>
                            <span class="text-sm font-bold text-white">{{ $seller->total_sales ?? 0 }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-muted-400">Wallet</span>
                            <span class="text-sm font-bold text-neon-green">${{ number_format($seller->getWalletBalance() ?? 0, 2) }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-muted-400">Rating</span>
                            <span class="text-sm font-bold text-yellow-400">⭐ {{ number_format($seller->rating ?? 0, 1) }}</span>
                        </div>
                    </div>
                    @endif
                </x-ui.card>
            </div>

            <!-- Main Content Area -->
            <div class="lg:col-span-3">
                
                <!-- My Account Tab -->
                @if($tab === 'my-account')
                    <form method="POST" action="{{ route('account.update') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                    <!-- Avatar Upload Section -->
                        <x-ui.card variant="glass" :hover="false">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="p-3 bg-primary-500/10 rounded-xl">
                                    <svg class="w-6 h-6 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-white">Profile Picture</h3>
                                <p class="text-sm text-muted-400">Upload your avatar</p>
                                </div>
                            </div>
                            
                        <div class="flex items-center gap-6">
                            <!-- Avatar Preview -->
                            <div class="relative">
                                <div class="w-24 h-24 rounded-2xl overflow-hidden bg-gaming-gradient shadow-gaming">
                                    <img src="{{ $user->avatar_url }}?v={{ $user->updated_at?->timestamp ?? time() }}" 
                                         alt="{{ $user->name }}" 
                                         id="avatar-preview" 
                                         class="w-full h-full object-cover" 
                                         onerror="this.onerror=null; this.src='{{ asset('img/default-avatar.svg') }}'; console.error('Avatar failed to load:', this.src);">
                                </div>
                                <div class="absolute -bottom-2 -right-2 w-8 h-8 bg-neon-green rounded-xl border-2 border-dark-800 flex items-center justify-center shadow-lg">
                                    <svg class="w-4 h-4 text-dark-900" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            </div>
                            
                            <!-- Debug Info (remove after testing) -->
                            @if(app()->environment('local'))
                            <div class="text-xs text-muted-500 mt-2">
                                <p>Avatar field: {{ $user->avatar ?? 'null' }}</p>
                                <p>Avatar URL: {{ $user->avatar_url }}</p>
                                <p>Disk: {{ config('filesystems.default') }}</p>
                            </div>
                            @endif

                            <!-- Upload Controls -->
                                    <div class="flex-1">
                                <div class="flex items-center gap-3 mb-2">
                                    <label for="avatar" class="inline-flex items-center px-5 py-2.5 bg-primary-500/20 border border-primary-500/40 rounded-xl text-primary-300 hover:bg-primary-500/30 transition-all cursor-pointer font-semibold text-sm">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                            </svg>
                                        Upload Photo
                                        </label>
                                    
                                    <button type="button" id="remove-avatar-btn" class="px-4 py-2.5 text-sm font-medium text-red-400 hover:text-red-300 transition">
                                        Remove
                                    </button>
                                </div>
                                <input type="file" id="avatar" name="avatar" accept="image/jpeg,image/png,image/jpg,image/gif,image/svg+xml" class="hidden">
                                <p class="text-xs text-muted-400">JPG, PNG, GIF, SVG • Max 2MB • Recommended: 400x400px</p>
                                <p id="file-name" class="mt-2 text-sm text-primary-400 hidden"></p>
                            </div>
                        </div>
                    </x-ui.card>

                    <!-- Personal Information -->
                    <x-ui.card variant="glass" :hover="false">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="p-3 bg-secondary-500/10 rounded-xl">
                                <svg class="w-6 h-6 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                    </div>
                            <div>
                                <h3 class="text-xl font-bold text-white">Personal Information</h3>
                                <p class="text-sm text-muted-400">Update your account details</p>
                                </div>
                            </div>
                            
                        <div class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Display Name -->
                                <div>
                                    <label for="display_name" class="block text-sm font-semibold text-white mb-2">
                                        Display Name *
                                    </label>
                                    <input type="text" 
                                           name="display_name" 
                                           id="display_name" 
                                           value="{{ old('display_name', $seller->display_name ?? $user->name) }}"
                                           required
                                           class="w-full px-4 py-3 bg-dark-900/70 border border-gaming rounded-xl text-white placeholder-muted-500 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-all"
                                           placeholder="Your display name">
                                    <p class="mt-1 text-xs text-muted-400">How others will see you</p>
                                </div>

                                <!-- Email -->
                                <div>
                                    <label for="email" class="block text-sm font-semibold text-white mb-2">
                                        Email Address *
                                    </label>
                                    <input type="email" 
                                           name="email" 
                                           id="email" 
                                           value="{{ old('email', $user->email) }}"
                                           required
                                           class="w-full px-4 py-3 bg-dark-900/70 border border-gaming rounded-xl text-white placeholder-muted-500 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-all"
                                           placeholder="your@email.com">
                                </div>

                                <!-- Phone -->
                                <div>
                                    <label for="phone" class="block text-sm font-semibold text-white mb-2">
                                        Phone Number
                                    </label>
                                    <input type="tel" 
                                           name="phone" 
                                           id="phone" 
                                           value="{{ old('phone', $user->phone) }}"
                                           class="w-full px-4 py-3 bg-dark-900/70 border border-gaming rounded-xl text-white placeholder-muted-500 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-all"
                                           placeholder="+1 (555) 000-0000">
                                </div>

                                <!-- Username -->
                                <div>
                                    <label for="username" class="block text-sm font-semibold text-white mb-2">
                                        Username
                                        <span class="text-red-400">*</span>
                                    </label>
                                    <input type="text" 
                                           name="username" 
                                           id="username" 
                                           value="{{ old('username', $user->username) }}"
                                           required
                                           minlength="3"
                                           maxlength="30"
                                           pattern="[a-zA-Z0-9_]+"
                                           class="w-full px-4 py-3 bg-dark-900/70 border border-gaming rounded-xl text-white placeholder-muted-500 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-all"
                                           placeholder="@username">
                                    <p class="mt-1 text-xs text-muted-400">
                                        Your unique identifier (3-30 characters, letters, numbers, and underscores only)
                                    </p>
                                    @error('username')
                                        <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Bio/Tagline -->
                            <div>
                                <label for="tagline" class="block text-sm font-semibold text-white mb-2">
                                    Bio / Tagline
                                </label>
                                <textarea name="tagline" 
                                          id="tagline" 
                                          rows="3"
                                          class="w-full px-4 py-3 bg-dark-900/70 border border-gaming rounded-xl text-white placeholder-muted-500 focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-all resize-none"
                                          placeholder="Tell others about yourself...">{{ old('tagline', $seller->bio ?? '') }}</textarea>
                                <p class="mt-1 text-xs text-muted-400">Brief description for your public profile</p>
                            </div>
                        </div>
                    </x-ui.card>

                    <!-- Privacy Settings -->
                        <x-ui.card variant="glass" :hover="false">
                            <div class="flex items-center gap-3 mb-6">
                            <div class="p-3 bg-neon-blue/10 rounded-xl">
                                <svg class="w-6 h-6 text-neon-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-white">Privacy & Preferences</h3>
                                <p class="text-sm text-muted-400">Control your profile visibility</p>
                            </div>
                        </div>
                        
                        <div class="space-y-4">
                            <!-- Public Visibility Toggle -->
                            <label class="flex items-center justify-between p-4 bg-dark-900/50 rounded-xl border border-gaming/30 hover:border-gaming/50 transition cursor-pointer">
                                <div class="flex-1">
                                    <p class="font-semibold text-white">Public Profile</p>
                                    <p class="text-sm text-muted-400">Make your profile visible to everyone</p>
                                </div>
                                <div class="relative ml-4">
                                    <input type="checkbox" name="public_visibility" value="1" {{ old('public_visibility', true) ? 'checked' : '' }} class="sr-only peer">
                                    <div class="w-11 h-6 bg-dark-700 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-500/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-500"></div>
                                        </div>
                            </label>

                            <!-- Preferences -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                <label class="flex items-center gap-3 p-3 bg-dark-900/30 rounded-xl border border-gaming/20 hover:border-gaming/40 transition cursor-pointer">
                                    <input type="checkbox" name="pref[show_stats]" value="1" class="w-4 h-4 text-primary-500 bg-dark-700 border-gaming rounded focus:ring-primary-500 focus:ring-2">
                                    <span class="text-sm text-muted-300">Show stats on profile</span>
                                </label>

                                <label class="flex items-center gap-3 p-3 bg-dark-900/30 rounded-xl border border-gaming/20 hover:border-gaming/40 transition cursor-pointer">
                                    <input type="checkbox" name="pref[show_listings]" value="1" class="w-4 h-4 text-primary-500 bg-dark-700 border-gaming rounded focus:ring-primary-500 focus:ring-2">
                                    <span class="text-sm text-muted-300">Show listings publicly</span>
                                </label>

                                <label class="flex items-center gap-3 p-3 bg-dark-900/30 rounded-xl border border-gaming/20 hover:border-gaming/40 transition cursor-pointer">
                                    <input type="checkbox" name="pref[instant_purchase]" value="1" class="w-4 h-4 text-primary-500 bg-dark-700 border-gaming rounded focus:ring-primary-500 focus:ring-2">
                                    <span class="text-sm text-muted-300">Enable instant purchase</span>
                                    </label>

                                <label class="flex items-center gap-3 p-3 bg-dark-900/30 rounded-xl border border-gaming/20 hover:border-gaming/40 transition cursor-pointer">
                                    <input type="checkbox" name="pref[quick_replies]" value="1" class="w-4 h-4 text-primary-500 bg-dark-700 border-gaming rounded focus:ring-primary-500 focus:ring-2">
                                    <span class="text-sm text-muted-300">Enable quick replies</span>
                                </label>
                        </div>
                            </div>
                        </x-ui.card>

                    <!-- Account Information -->
                        <x-ui.card variant="glass" :hover="false">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="p-3 bg-neon-green/10 rounded-xl">
                                <svg class="w-6 h-6 text-neon-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-white">Account Information</h3>
                                <p class="text-sm text-muted-400">Your account details</p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="p-4 bg-dark-900/50 rounded-xl border border-gaming/30">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm text-muted-400">Account ID</p>
                                        <p class="mt-1 text-lg font-bold text-white">#{{ str_pad($user->id, 6, '0', STR_PAD_LEFT) }}</p>
                                    </div>
                                    <div class="w-10 h-10 bg-primary-500/10 rounded-xl flex items-center justify-center">
                                        <svg class="w-6 h-6 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <div class="p-4 bg-dark-900/50 rounded-xl border border-gaming/30">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm text-muted-400">Member Since</p>
                                        <p class="mt-1 text-lg font-bold text-white">{{ $user->created_at->format('M Y') }}</p>
                                    </div>
                                    <div class="w-10 h-10 bg-secondary-500/10 rounded-xl flex items-center justify-center">
                                        <svg class="w-6 h-6 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                </div>
                                </div>
                            </div>

                            @if($seller)
                            <div class="p-4 bg-dark-900/50 rounded-xl border border-gaming/30">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm text-muted-400">Total Earnings</p>
                                        <p class="mt-1 text-lg font-bold text-neon-green">${{ number_format($seller->getWalletBalance(), 2) }}</p>
                                    </div>
                                    <div class="w-10 h-10 bg-neon-green/10 rounded-xl flex items-center justify-center">
                                        <svg class="w-6 h-6 text-neon-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    </div>
                                </div>
                            </div>

                            <div class="p-4 bg-dark-900/50 rounded-xl border border-gaming/30">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm text-muted-400">Seller Rating</p>
                                        <p class="mt-1 text-lg font-bold text-yellow-400">⭐ {{ number_format($seller->rating ?? 0, 1) }}</p>
                                    </div>
                                    <div class="w-10 h-10 bg-yellow-500/10 rounded-xl flex items-center justify-center">
                                        <svg class="w-6 h-6 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.519-4.674z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            @endif
                                </div>
                    </x-ui.card>

                    <!-- Subscription Info (if exists) -->
                    @if($user->activeSubscription)
                    <x-ui.card variant="glass" class="border-primary-500/30 bg-primary-500/5" :hover="false">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div class="p-3 bg-gaming-gradient rounded-xl shadow-gaming">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm text-primary-400 font-medium">Current Plan</p>
                                    <p class="text-2xl font-black text-white">{{ $user->activeSubscription->plan->name }}</p>
                                </div>
                            </div>
                            <a href="{{ route('account.billing') }}" class="px-5 py-2.5 bg-dark-800/50 border border-gaming rounded-xl text-white hover:bg-dark-800 transition font-semibold text-sm">
                                Manage Plan
                            </a>
                            </div>
                        </x-ui.card>
                    @endif

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-end gap-4">
                        <a href="{{ route('home') }}" class="px-6 py-3 border border-gaming rounded-xl text-muted-300 hover:text-white hover:bg-dark-800/30 font-semibold transition">
                            Cancel
                        </a>
                        <button type="submit" class="px-6 py-3 bg-gaming-gradient text-white rounded-xl font-bold hover:shadow-gaming transition-all">
                            Save Changes
                        </button>
                    </div>
                    </form>
                @endif

                <!-- Sales Tab -->
                @if($tab === 'sales')
                <x-ui.card variant="glass" :hover="false">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h2 class="text-2xl font-bold text-white">My Sales</h2>
                            <p class="mt-1 text-sm text-muted-400">Manage your product listings</p>
                        </div>
                        @if($seller)
                        <a href="{{ route('seller.products.create') }}" class="px-5 py-2.5 bg-gaming-gradient text-white rounded-xl font-bold hover:shadow-gaming transition-all text-sm">
                            + New Listing
                        </a>
                        @endif
                </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($products as $product)
                        <a href="{{ route('seller.products.edit', $product) }}" class="group">
                            <div class="bg-dark-800/50 rounded-2xl overflow-hidden border border-gaming hover:border-primary-500/50 transition-all">
                                        <div class="aspect-video bg-gaming-gradient">
                                    @if($product->thumbnail_url)
                                    <img src="{{ $product->thumbnail_url }}" alt="{{ $product->title }}" class="w-full h-full object-cover">
                                    @endif
                                        </div>
                                        <div class="p-4">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="px-2 py-1 text-xs font-medium rounded-lg {{ $product->status === 'active' ? 'bg-neon-green/20 text-neon-green' : 'bg-muted-700 text-muted-300' }}">
                                            {{ ucfirst($product->status) }}
                                        </span>
                                        <span class="text-lg font-bold text-white">${{ number_format($product->price, 2) }}</span>
                                    </div>
                                    <h3 class="text-white font-semibold line-clamp-2">{{ $product->title }}</h3>
                                    <p class="mt-2 text-sm text-muted-400">{{ $product->sales_count ?? 0 }} sales • {{ $product->views_count ?? 0 }} views</p>
                                </div>
                            </div>
                        </a>
                        @empty
                        <div class="col-span-full text-center py-16">
                            <div class="w-20 h-20 bg-dark-800/50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                <svg class="w-10 h-10 text-muted-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                </svg>
                            </div>
                            <p class="text-muted-300 mb-4">No products listed yet</p>
                            @if($seller)
                            <a href="{{ route('seller.products.create') }}" class="inline-flex items-center px-6 py-3 bg-gaming-gradient text-white rounded-xl font-bold hover:shadow-gaming transition-all">
                                Create Your First Listing
                            </a>
                            @endif
                        </div>
                        @endforelse
                    </div>

                        @if(method_exists($products, 'links'))
                    <div class="mt-6">
                        {{ $products->links() }}
                    </div>
                        @endif
                    </x-ui.card>
                @endif

                <!-- Reviews Tab -->
                @if($tab === 'reviews')
                <x-ui.card variant="glass" :hover="false">
                    <h2 class="text-2xl font-bold text-white mb-6">Reviews</h2>
                    
                    <!-- Review Stats -->
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div class="p-4 bg-neon-green/10 border border-neon-green/30 rounded-xl">
                            <p class="text-sm text-neon-green font-medium">Positive Reviews</p>
                            <p class="text-2xl font-bold text-white mt-1">{{ $reviews->where('rating', '>=', 4)->count() }}</p>
                            </div>
                        <div class="p-4 bg-red-500/10 border border-red-500/30 rounded-xl">
                            <p class="text-sm text-red-400 font-medium">Negative Reviews</p>
                            <p class="text-2xl font-bold text-white mt-1">{{ $reviews->where('rating', '<=', 2)->count() }}</p>
                        </div>
                    </div>

                    <!-- Reviews List -->
                        <div class="space-y-4">
                        @forelse($reviews as $review)
                        <div class="border border-gaming rounded-xl p-4 bg-dark-800/50 hover:border-gaming/50 transition">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-gaming-gradient flex items-center justify-center text-white font-bold">
                                        {{ substr($review->user->name ?? 'U', 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-semibold text-white">{{ $review->user->name ?? 'Anonymous' }}</p>
                                        <p class="text-xs text-muted-400">{{ $review->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-1">
                                    @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-muted-600' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.519-4.674z" />
                                    </svg>
                                    @endfor
                                </div>
                            </div>
                            <p class="text-muted-300">{{ $review->comment }}</p>
                        </div>
                        @empty
                        <div class="text-center py-16">
                            <div class="w-20 h-20 bg-dark-800/50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                <svg class="w-10 h-10 text-muted-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                </svg>
                            </div>
                            <p class="text-muted-300">No reviews yet</p>
                                </div>
                            @endforelse
                        </div>
                    </x-ui.card>
                @endif

                <!-- Social Tab -->
                @if($tab === 'social')
                    <x-ui.card variant="glass" :hover="false">
                    <h2 class="text-2xl font-bold text-white mb-6">Social Media Accounts</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($socialProducts as $product)
                        <a href="{{ route('seller.products.edit', $product) }}" class="group">
                            <div class="bg-dark-800/50 rounded-2xl overflow-hidden border border-gaming hover:border-secondary-500/50 transition-all">
                                <div class="aspect-video bg-gradient-to-br from-pink-500 to-purple-600">
                                    @if($product->thumbnail_url)
                                    <img src="{{ $product->thumbnail_url }}" alt="{{ $product->title }}" class="w-full h-full object-cover">
                                    @endif
                                        </div>
                                        <div class="p-4">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="px-2 py-1 text-xs font-medium bg-secondary-500/20 text-secondary-400 rounded-lg">
                                            {{ $product->metadata['platform'] ?? 'Social' }}
                                        </span>
                                        <span class="text-lg font-bold text-white">${{ number_format($product->price, 2) }}</span>
                                    </div>
                                    <h3 class="text-white font-semibold line-clamp-2">{{ $product->title }}</h3>
                                </div>
                            </div>
                        </a>
                        @empty
                        <div class="col-span-full text-center py-16">
                            <div class="w-20 h-20 bg-dark-800/50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                <svg class="w-10 h-10 text-muted-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <p class="text-muted-300">No social accounts listed</p>
                        </div>
                        @endforelse
                    </div>

                        @if(method_exists($socialProducts, 'links'))
                    <div class="mt-6">
                        {{ $socialProducts->links() }}
                    </div>
                        @endif
                    </x-ui.card>
                @endif

            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Avatar Preview
const avatarInput = document.getElementById('avatar');
const avatarPreview = document.getElementById('avatar-preview');
const fileNameDisplay = document.getElementById('file-name');
const removeAvatarBtn = document.getElementById('remove-avatar-btn');

if (avatarInput) {
    avatarInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            // Validate file size (2MB max)
            if (file.size > 2 * 1024 * 1024) {
                alert('⚠️ File size must be less than 2MB');
                e.target.value = '';
                return;
            }

            // Validate file type
            if (!file.type.startsWith('image/')) {
                alert('⚠️ Please select an image file');
                e.target.value = '';
                return;
            }

            // Preview the image
        const reader = new FileReader();
            reader.onload = function(event) {
                if (avatarPreview) {
                    avatarPreview.src = event.target.result;
                }
            }
            reader.readAsDataURL(file);

            // Show file name
            if (fileNameDisplay) {
                fileNameDisplay.textContent = '✓ Selected: ' + file.name;
                fileNameDisplay.classList.remove('hidden');
            }
        }
    });
}

if (removeAvatarBtn) {
    removeAvatarBtn.addEventListener('click', function() {
        if (confirm('Remove your profile picture?')) {
            if (avatarInput) avatarInput.value = '';
            if (avatarPreview) avatarPreview.src = '{{ asset("img/default-avatar.svg") }}';
            if (fileNameDisplay) fileNameDisplay.classList.add('hidden');
        }
    });
}

// Auto-dismiss success message after 5 seconds
setTimeout(function() {
    const successMessage = document.querySelector('.bg-green-500\\/10');
    if (successMessage) {
        successMessage.style.transition = 'opacity 0.5s';
        successMessage.style.opacity = '0';
        setTimeout(() => successMessage.remove(), 500);
    }
}, 5000);

// Force reload avatar on page load to show updated image
document.addEventListener('DOMContentLoaded', function() {
    const img = document.getElementById('avatar-preview');
    if (img && img.src) {
        // Add timestamp to force reload and bypass cache
        const currentSrc = img.src.split('?')[0];
        img.src = currentSrc + '?v=' + new Date().getTime();
    }
    
    // Also update all avatar images on the page
    document.querySelectorAll('img[alt*="{{ auth()->user()->name }}"]').forEach(function(avatarImg) {
        if (avatarImg.src) {
            const src = avatarImg.src.split('?')[0];
            avatarImg.src = src + '?v=' + new Date().getTime();
        }
    });
});
</script>
@endpush
@endsection
