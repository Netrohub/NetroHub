@extends('layouts.app')

@section('content')
<div class="min-h-screen relative overflow-hidden bg-dark-900 py-10">
    <!-- Gaming Background Effects -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-primary-500/5 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-1/4 right-1/4 w-80 h-80 bg-secondary-500/5 rounded-full blur-3xl animate-float animation-delay-2000"></div>
    </div>

    <div class="relative max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center gap-3 mb-2">
                <a href="{{ route('seller.products.index') }}" class="text-muted-400 hover:text-white transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <h1 class="text-4xl font-black text-white bg-gaming-gradient bg-clip-text text-transparent">Create New Product</h1>
            </div>
            <p class="text-muted-300">Add a new digital product to your store</p>
        </div>

        <form action="{{ route('seller.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6" x-data="productForm()">
            @csrf
            
            <!-- Hidden delivery type - accounts are delivered via credentials -->
            <input type="hidden" name="delivery_type" value="hybrid">

            <!-- Product Type Selection -->
            <x-ui.card variant="glass">
                <h2 class="text-2xl font-bold text-white mb-6">Product Type</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <label class="relative cursor-pointer">
                        <input type="radio" name="type" value="social_account" x-model="productType" required class="peer sr-only">
                        <div class="p-6 border-2 border-gaming rounded-xl peer-checked:border-secondary-500 peer-checked:bg-secondary-500/10 transition-all">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="w-10 h-10 bg-secondary-500/20 rounded-xl flex items-center justify-center">
                                    <svg class="w-5 h-5 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-bold text-white">Social Account</p>
                                    <p class="text-sm text-muted-400">Instagram, TikTok, Twitter, etc.</p>
                                </div>
                            </div>
                        </div>
                    </label>

                    <label class="relative cursor-pointer">
                        <input type="radio" name="type" value="game_account" x-model="productType" required class="peer sr-only">
                        <div class="p-6 border-2 border-gaming rounded-xl peer-checked:border-primary-500 peer-checked:bg-primary-500/10 transition-all">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="w-10 h-10 bg-primary-500/20 rounded-xl flex items-center justify-center">
                                    <svg class="w-5 h-5 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-bold text-white">Game Account</p>
                                    <p class="text-sm text-muted-400">Gaming accounts & profiles</p>
                                </div>
                            </div>
                        </div>
                    </label>
                </div>

                @error('type')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </x-ui.card>

            <!-- Game Title Selection (for game accounts) -->
            <x-ui.card variant="glass" x-show="productType === 'game_account'" x-cloak>
                <h2 class="text-2xl font-bold text-white mb-6">Select Game</h2>
                
                <div>
                    <label class="block text-sm font-medium text-muted-300 mb-2">Game Title *</label>
                    <select name="game_title" x-model="gameTitle" class="w-full px-4 py-3 bg-dark-700/50 border border-gaming rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-primary-500">
                        <option value="">Choose a game</option>
                        <option value="Whiteout Survival">Whiteout Survival</option>
                        <option value="Call of Duty Mobile">Call of Duty Mobile</option>
                        <option value="PUBG Mobile">PUBG Mobile</option>
                        <option value="Free Fire">Free Fire</option>
                        <option value="Genshin Impact">Genshin Impact</option>
                        <option value="Clash of Clans">Clash of Clans</option>
                        <option value="Clash Royale">Clash Royale</option>
                        <option value="Other">Other</option>
                    </select>
                </div>

                @error('game_title')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </x-ui.card>

            <!-- Platform Selection (for social accounts) -->
            <x-ui.card variant="glass" x-show="productType === 'social_account'" x-cloak>
                <h2 class="text-2xl font-bold text-white mb-6">Select Platform</h2>
                
                <div>
                    <label class="block text-sm font-medium text-muted-300 mb-2">Social Platform *</label>
                    <select name="platform" class="w-full px-4 py-3 bg-dark-700/50 border border-gaming rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-secondary-500">
                        <option value="">Choose a platform</option>
                        <option value="Instagram">Instagram</option>
                        <option value="TikTok">TikTok</option>
                        <option value="Twitter">Twitter (X)</option>
                        <option value="Facebook">Facebook</option>
                        <option value="YouTube">YouTube</option>
                        <option value="Snapchat">Snapchat</option>
                        <option value="LinkedIn">LinkedIn</option>
                        <option value="Pinterest">Pinterest</option>
                        <option value="Twitch">Twitch</option>
                        <option value="Discord">Discord</option>
                        <option value="Other">Other</option>
                    </select>
                </div>

                @error('platform')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </x-ui.card>

            <!-- Basic Information -->
            <x-ui.card variant="glass">
                <h2 class="text-2xl font-bold text-white mb-6">Basic Information</h2>
                
                <div class="space-y-6">
                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-muted-300 mb-2">Product Title *</label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" required
                            class="w-full px-4 py-3 bg-dark-700/50 border border-gaming rounded-xl text-white placeholder-muted-500 focus:outline-none focus:ring-2 focus:ring-primary-500 @error('title') border-red-500 @enderror">
                        @error('title')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-muted-300 mb-2">Description *</label>
                        <textarea name="description" id="description" rows="6" required
                            class="w-full px-4 py-3 bg-dark-700/50 border border-gaming rounded-xl text-white placeholder-muted-500 focus:outline-none focus:ring-2 focus:ring-primary-500 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Category and Price -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="category_id" class="block text-sm font-medium text-muted-300 mb-2">Category *</label>
                            <select name="category_id" id="category_id" required
                                class="w-full px-4 py-3 bg-dark-700/50 border border-gaming rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-primary-500 @error('category_id') border-red-500 @enderror">
                                <option value="">Select a category</option>
                                @foreach($categories as $category)
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
                            <label for="price" class="block text-sm font-medium text-muted-300 mb-2">Price (USD) *</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-white font-bold">$</span>
                                <input type="number" name="price" id="price" value="{{ old('price') }}" step="0.01" min="0" required
                                    class="w-full pl-10 pr-4 py-3 bg-dark-700/50 border border-gaming rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-primary-500 @error('price') border-red-500 @enderror">
                            </div>
                            @error('price')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </x-ui.card>

            <!-- Social Account Metadata -->
            <x-ui.card variant="glass" x-show="productType === 'social_account'" x-cloak>
                <h2 class="text-2xl font-bold text-white mb-4">Account Details</h2>
                <p class="text-sm text-muted-400 mb-6">Provide accurate information about this social account</p>
                
                <div class="space-y-4">
                    <!-- Automatic Delivery (Always Yes) -->
                    <div class="flex items-center justify-between p-4 bg-green-500/10 border border-green-500/30 rounded-xl">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <div>
                                <p class="text-white font-semibold">Automatic Delivery</p>
                                <p class="text-xs text-muted-400">Instant credential delivery upon purchase</p>
                            </div>
                        </div>
                        <span class="px-3 py-1 bg-green-500/20 text-green-400 rounded-lg text-sm font-semibold">YES</span>
                    </div>

                    <!-- KYC Verified (Always Yes) -->
                    <div class="flex items-center justify-between p-4 bg-green-500/10 border border-green-500/30 rounded-xl">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <div>
                                <p class="text-white font-semibold">Product Owner Verified with ID</p>
                                <p class="text-xs text-muted-400">Your identity has been verified</p>
                            </div>
                        </div>
                        <span class="px-3 py-1 bg-green-500/20 text-green-400 rounded-lg text-sm font-semibold">YES</span>
                    </div>

                    <!-- With Primary Email -->
                    <div class="flex items-center justify-between p-4 bg-dark-700/30 border border-gaming rounded-xl">
                        <div>
                            <p class="text-white font-semibold">With Primary Email?</p>
                            <p class="text-xs text-muted-400">Account has access to the original email address</p>
                        </div>
                        <div class="flex items-center gap-4">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="with_primary_email" value="1" class="w-4 h-4 text-primary-500 border-gaming focus:ring-primary-500">
                                <span class="text-white text-sm">Yes</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="with_primary_email" value="0" class="w-4 h-4 text-primary-500 border-gaming focus:ring-primary-500" checked>
                                <span class="text-white text-sm">No</span>
                            </label>
                        </div>
                    </div>

                    <!-- With Current Email -->
                    <div class="flex items-center justify-between p-4 bg-dark-700/30 border border-gaming rounded-xl">
                        <div>
                            <p class="text-white font-semibold">With Current Email?</p>
                            <p class="text-xs text-muted-400">Account uses a current accessible email</p>
                        </div>
                        <div class="flex items-center gap-4">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="with_current_email" value="1" class="w-4 h-4 text-primary-500 border-gaming focus:ring-primary-500">
                                <span class="text-white text-sm">Yes</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="with_current_email" value="0" class="w-4 h-4 text-primary-500 border-gaming focus:ring-primary-500" checked>
                                <span class="text-white text-sm">No</span>
                            </label>
                        </div>
                    </div>

                    <!-- Linked to a Number -->
                    <div class="flex items-center justify-between p-4 bg-dark-700/30 border border-gaming rounded-xl">
                        <div>
                            <p class="text-white font-semibold">Linked to a Number?</p>
                            <p class="text-xs text-muted-400">Account has phone number authentication</p>
                        </div>
                        <div class="flex items-center gap-4">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="linked_to_number" value="1" class="w-4 h-4 text-primary-500 border-gaming focus:ring-primary-500">
                                <span class="text-white text-sm">Yes</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="linked_to_number" value="0" class="w-4 h-4 text-primary-500 border-gaming focus:ring-primary-500" checked>
                                <span class="text-white text-sm">No</span>
                            </label>
                        </div>
                    </div>
                </div>
            </x-ui.card>

            <!-- Game Account Metadata (Whiteout Survival) -->
            <x-ui.card variant="glass" x-show="productType === 'game_account' && gameTitle === 'Whiteout Survival'" x-cloak>
                <h2 class="text-2xl font-bold text-white mb-4">Whiteout Survival Account Details</h2>
                <p class="text-sm text-muted-400 mb-6">Provide accurate information about this game account</p>
                
                <div class="space-y-4">
                    <!-- Automatic Delivery (Always Yes) -->
                    <div class="flex items-center justify-between p-4 bg-green-500/10 border border-green-500/30 rounded-xl">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <div>
                                <p class="text-white font-semibold">Automatic Delivery</p>
                                <p class="text-xs text-muted-400">Instant credential delivery upon purchase</p>
                            </div>
                        </div>
                        <span class="px-3 py-1 bg-green-500/20 text-green-400 rounded-lg text-sm font-semibold">YES</span>
                    </div>

                    <!-- KYC Verified (Always Yes) -->
                    <div class="flex items-center justify-between p-4 bg-green-500/10 border border-green-500/30 rounded-xl">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <div>
                                <p class="text-white font-semibold">Product Owner Verified with ID</p>
                                <p class="text-xs text-muted-400">Your identity has been verified</p>
                            </div>
                        </div>
                        <span class="px-3 py-1 bg-green-500/20 text-green-400 rounded-lg text-sm font-semibold">YES</span>
                    </div>

                    <!-- With Primary Email -->
                    <div class="flex items-center justify-between p-4 bg-dark-700/30 border border-gaming rounded-xl">
                        <div>
                            <p class="text-white font-semibold">With Primary Email?</p>
                            <p class="text-xs text-muted-400">Account has access to the original email</p>
                        </div>
                        <div class="flex items-center gap-4">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="with_primary_email_game" value="1" class="w-4 h-4 text-primary-500 border-gaming focus:ring-primary-500">
                                <span class="text-white text-sm">Yes</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="with_primary_email_game" value="0" class="w-4 h-4 text-primary-500 border-gaming focus:ring-primary-500" checked>
                                <span class="text-white text-sm">No</span>
                            </label>
                        </div>
                    </div>

                    <!-- Linked to Facebook -->
                    <div class="flex items-center justify-between p-4 bg-dark-700/30 border border-gaming rounded-xl">
                    <div>
                            <p class="text-white font-semibold">Linked to Facebook?</p>
                            <p class="text-xs text-muted-400">Account connected to Facebook</p>
                                </div>
                        <div class="flex items-center gap-4">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="linked_to_facebook" value="1" class="w-4 h-4 text-primary-500 border-gaming focus:ring-primary-500">
                                <span class="text-white text-sm">Yes</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="linked_to_facebook" value="0" class="w-4 h-4 text-primary-500 border-gaming focus:ring-primary-500" checked>
                                <span class="text-white text-sm">No</span>
                            </label>
                        </div>
                    </div>

                    <!-- Linked to Google -->
                    <div class="flex items-center justify-between p-4 bg-dark-700/30 border border-gaming rounded-xl">
                        <div>
                            <p class="text-white font-semibold">Linked to Google Account?</p>
                            <p class="text-xs text-muted-400">Account connected to Google</p>
                                </div>
                        <div class="flex items-center gap-4">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="linked_to_google" value="1" class="w-4 h-4 text-primary-500 border-gaming focus:ring-primary-500">
                                <span class="text-white text-sm">Yes</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="linked_to_google" value="0" class="w-4 h-4 text-primary-500 border-gaming focus:ring-primary-500" checked>
                                <span class="text-white text-sm">No</span>
                            </label>
                        </div>
                    </div>

                    <!-- Linked to Apple ID -->
                    <div class="flex items-center justify-between p-4 bg-dark-700/30 border border-gaming rounded-xl">
                        <div>
                            <p class="text-white font-semibold">Linked to Apple ID?</p>
                            <p class="text-xs text-muted-400">Account connected to Apple ID</p>
                                </div>
                        <div class="flex items-center gap-4">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="linked_to_apple" value="1" class="w-4 h-4 text-primary-500 border-gaming focus:ring-primary-500">
                                <span class="text-white text-sm">Yes</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="linked_to_apple" value="0" class="w-4 h-4 text-primary-500 border-gaming focus:ring-primary-500" checked>
                                <span class="text-white text-sm">No</span>
                            </label>
                        </div>
                    </div>

                    <!-- Linked to Game Center -->
                    <div class="flex items-center justify-between p-4 bg-dark-700/30 border border-gaming rounded-xl">
                        <div>
                            <p class="text-white font-semibold">Linked to Game Center?</p>
                            <p class="text-xs text-muted-400">Account connected to Game Center</p>
                        </div>
                        <div class="flex items-center gap-4">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="linked_to_game_center" value="1" class="w-4 h-4 text-primary-500 border-gaming focus:ring-primary-500">
                                <span class="text-white text-sm">Yes</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="linked_to_game_center" value="0" class="w-4 h-4 text-primary-500 border-gaming focus:ring-primary-500" checked>
                                <span class="text-white text-sm">No</span>
                            </label>
                    </div>
                </div>
            </div>
            </x-ui.card>

            <!-- Gallery Images (for Whiteout Survival) -->
            <x-ui.card variant="glass" x-show="productType === 'game_account' && gameTitle === 'Whiteout Survival'" x-cloak>
                <h2 class="text-2xl font-bold text-white mb-4">Account Screenshots *</h2>
                <p class="text-sm text-muted-400 mb-2">Upload screenshots of your game account to showcase its features</p>
                
                <!-- Warning Alert -->
                <x-ui.alert type="warning" class="mb-6">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-yellow-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <p class="font-semibold text-yellow-400">Important Security Notice</p>
                            <p class="text-sm text-muted-300 mt-1">⚠️ <strong>Do not share Game ID</strong> in your screenshots. Blur or crop out any Game ID to protect your account.</p>
                        </div>
                    </div>
                </x-ui.alert>

                <div>
                    <input type="file" name="gallery_images[]" id="gallery_images" multiple accept="image/*" required
                        class="w-full px-4 py-3 bg-dark-700/50 border border-gaming rounded-xl text-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-primary-500 file:text-white hover:file:bg-primary-600 focus:outline-none focus:ring-2 focus:ring-primary-500">
                    <p class="mt-2 text-xs text-muted-400">
                        • Upload at least 3-5 screenshots showing account features<br>
                        • Accepted formats: JPG, PNG<br>
                        • Max 5MB per image<br>
                        • Images will be checked for inappropriate content
                    </p>
                </div>

                @error('gallery_images')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror

                <!-- Preview Container -->
                <div id="galleryPreview" class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-6"></div>
            </x-ui.card>

            <!-- Media -->
            <x-ui.card variant="glass">
                <h2 class="text-2xl font-bold text-white mb-6">Media</h2>
                
                <div class="space-y-6">
                    <!-- Thumbnail -->
                    <div>
                        <label for="thumbnail" class="block text-sm font-medium text-muted-300 mb-2">Product Thumbnail</label>
                        <input type="file" name="thumbnail" id="thumbnail" accept="image/*"
                            class="w-full px-4 py-3 bg-dark-700/50 border border-gaming rounded-xl text-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-primary-500 file:text-white hover:file:bg-primary-600 focus:outline-none focus:ring-2 focus:ring-primary-500">
                        <p class="mt-1 text-sm text-muted-400">Recommended: 1280x720px (16:9 aspect ratio), max 2MB</p>
                        @error('thumbnail')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </x-ui.card>

            <!-- Credentials (MANDATORY) -->
            <x-ui.card variant="glass">
                <div class="mb-6">
                    <div class="flex items-center gap-3 mb-2">
                        <h2 class="text-2xl font-bold text-white">Account Credentials</h2>
                        <span class="px-3 py-1 bg-red-500/20 text-red-400 rounded-lg text-xs font-semibold">REQUIRED</span>
                </div>
                    <p class="text-sm text-muted-400">Credentials are mandatory for automatic delivery - encrypted and delivered securely</p>
            </div>

                <input type="hidden" name="has_credentials" value="1">

                    <!-- Security Notice -->
                <div class="bg-blue-500/10 border border-blue-500/30 rounded-xl p-4 mb-6">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-blue-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                            </svg>
                        <div class="text-sm text-blue-300">
                            <strong>🔒 Secure Delivery:</strong> Credentials are encrypted and only revealed to buyers through a secure page with audit logging.
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <!-- Username -->
                        <div>
                        <label for="credential_username" class="block text-sm font-medium text-muted-300 mb-2">Username / Email *</label>
                        <input type="text" name="credential_username" id="credential_username" value="{{ old('credential_username') }}" required
                            class="w-full px-4 py-3 bg-dark-700/50 border border-gaming rounded-xl text-white font-mono placeholder-muted-500 focus:outline-none focus:ring-2 focus:ring-primary-500 @error('credential_username') border-red-500 @enderror">
                            @error('credential_username')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div>
                        <label for="credential_password" class="block text-sm font-medium text-muted-300 mb-2">Password *</label>
                        <input type="text" name="credential_password" id="credential_password" value="{{ old('credential_password') }}" required
                            class="w-full px-4 py-3 bg-dark-700/50 border border-gaming rounded-xl text-white font-mono placeholder-muted-500 focus:outline-none focus:ring-2 focus:ring-primary-500 @error('credential_password') border-red-500 @enderror">
                            @error('credential_password')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Extras (2FA codes, backup codes, etc.) -->
                        <div>
                        <label class="block text-sm font-medium text-muted-300 mb-2">Extra Information (2FA, backup codes, etc.)</label>
                            <div id="extras-container" class="space-y-3">
                                <div class="flex gap-2">
                                    <input type="text" name="credential_extras_keys[]" placeholder="e.g., 2FA Backup Codes"
                                    class="flex-1 px-4 py-3 bg-dark-700/50 border border-gaming rounded-xl text-white placeholder-muted-500 focus:outline-none focus:ring-2 focus:ring-primary-500">
                                    <input type="text" name="credential_extras_values[]" placeholder="e.g., ABC123, DEF456"
                                    class="flex-1 px-4 py-3 bg-dark-700/50 border border-gaming rounded-xl text-white font-mono placeholder-muted-500 focus:outline-none focus:ring-2 focus:ring-primary-500">
                                <button type="button" onclick="addExtra()" class="px-4 py-3 bg-primary-500 text-white rounded-xl hover:bg-primary-600 transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        <p class="mt-2 text-xs text-muted-400">Add any extra information like backup codes, security questions, etc.</p>
                        </div>

                        <!-- Instructions -->
                        <div>
                        <label for="credential_instructions" class="block text-sm font-medium text-muted-300 mb-2">Instructions for Buyer</label>
                            <textarea name="credential_instructions" id="credential_instructions" rows="4" placeholder="e.g., Please change the password immediately after login."
                            class="w-full px-4 py-3 bg-dark-700/50 border border-gaming rounded-xl text-white placeholder-muted-500 focus:outline-none focus:ring-2 focus:ring-primary-500">{{ old('credential_instructions') }}</textarea>
                        <p class="mt-1 text-sm text-muted-400">Provide any special instructions or notes for the buyer</p>
                        </div>

                        <!-- Unique Credential -->
                    <div class="p-4 bg-dark-700/30 border border-gaming rounded-xl">
                        <label class="flex items-start cursor-pointer">
                                <input type="checkbox" name="is_unique_credential" id="is_unique_credential" value="1" {{ old('is_unique_credential') ? 'checked' : '' }}
                                class="mt-1 w-5 h-5 text-primary-500 border-gaming rounded focus:ring-primary-500">
                                <div class="ml-3">
                                <div class="font-semibold text-white">This is a unique account (one-time sale)</div>
                                <div class="text-sm text-muted-400">Enable this if you're selling a single account. The product will be automatically archived after the first sale.</div>
                                </div>
                            </label>
                        </div>
                    </div>
            </x-ui.card>

            <!-- Additional Details -->
            <x-ui.card variant="glass">
                <h2 class="text-2xl font-bold text-white mb-6">Additional Details</h2>
                
                <div class="space-y-6">
                    <!-- Features -->
                    <div>
                        <label class="block text-sm font-medium text-muted-300 mb-2">Features</label>
                        <div id="features-container" class="space-y-2">
                            <div class="flex gap-2">
                                <input type="text" name="features[]" placeholder="e.g., High followers count, Verified badge"
                                    class="flex-1 px-4 py-3 bg-dark-700/50 border border-gaming rounded-xl text-white placeholder-muted-500 focus:outline-none focus:ring-2 focus:ring-primary-500">
                                <button type="button" onclick="addFeature()" class="px-4 py-3 bg-primary-500 text-white rounded-xl hover:bg-primary-600 transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Tags -->
                    <div>
                        <label class="block text-sm font-medium text-muted-300 mb-2">Tags</label>
                        <div id="tags-container" class="space-y-2">
                            <div class="flex gap-2">
                                <input type="text" name="tags[]" placeholder="e.g., premium, verified, high-level"
                                    class="flex-1 px-4 py-3 bg-dark-700/50 border border-gaming rounded-xl text-white placeholder-muted-500 focus:outline-none focus:ring-2 focus:ring-primary-500">
                                <button type="button" onclick="addTag()" class="px-4 py-3 bg-primary-500 text-white rounded-xl hover:bg-primary-600 transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </x-ui.card>

            <!-- Submit Buttons -->
            <div class="flex items-center justify-end gap-4">
                <a href="{{ route('seller.products.index') }}" class="px-6 py-3 border border-gaming rounded-xl text-muted-300 hover:text-white hover:bg-dark-700/50 font-semibold transition">
                    Cancel
                </a>
                <button type="submit" class="px-8 py-3 bg-gaming-gradient text-white font-bold rounded-xl hover:shadow-gaming-lg transition-all">
                    Create Product
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function productForm() {
    return {
        productType: '{{ old('type', '') }}',
        gameTitle: '{{ old('game_title', '') }}'
    }
}

// Gallery preview
document.getElementById('gallery_images')?.addEventListener('change', function(e) {
    const preview = document.getElementById('galleryPreview');
    preview.innerHTML = '';
    
    Array.from(e.target.files).forEach(file => {
        const reader = new FileReader();
        reader.onload = function(e) {
            const div = document.createElement('div');
            div.className = 'relative aspect-video rounded-xl overflow-hidden border border-gaming';
            div.innerHTML = `
                <img src="${e.target.result}" class="w-full h-full object-cover">
                <div class="absolute top-2 right-2 bg-green-500 text-white text-xs px-2 py-1 rounded">✓</div>
            `;
            preview.appendChild(div);
        };
        reader.readAsDataURL(file);
    });
});

function addFeature() {
    const container = document.getElementById('features-container');
    const div = document.createElement('div');
    div.className = 'flex gap-2';
    div.innerHTML = `
        <input type="text" name="features[]" placeholder="e.g., 24/7 support"
            class="flex-1 px-4 py-3 bg-dark-700/50 border border-gaming rounded-xl text-white placeholder-muted-500 focus:outline-none focus:ring-2 focus:ring-primary-500">
        <button type="button" onclick="this.parentElement.remove()" class="px-4 py-3 bg-red-500 text-white rounded-xl hover:bg-red-600 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    `;
    container.appendChild(div);
}

function addExtra() {
    const container = document.getElementById('extras-container');
    const div = document.createElement('div');
    div.className = 'flex gap-2';
    div.innerHTML = `
        <input type="text" name="credential_extras_keys[]" placeholder="e.g., Security Question"
            class="flex-1 px-4 py-3 bg-dark-700/50 border border-gaming rounded-xl text-white placeholder-muted-500 focus:outline-none focus:ring-2 focus:ring-primary-500">
        <input type="text" name="credential_extras_values[]" placeholder="Answer or value"
            class="flex-1 px-4 py-3 bg-dark-700/50 border border-gaming rounded-xl text-white font-mono placeholder-muted-500 focus:outline-none focus:ring-2 focus:ring-primary-500">
        <button type="button" onclick="this.parentElement.remove()" class="px-4 py-3 bg-red-500 text-white rounded-xl hover:bg-red-600 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    `;
    container.appendChild(div);
}

function addTag() {
    const container = document.getElementById('tags-container');
    const div = document.createElement('div');
    div.className = 'flex gap-2';
    div.innerHTML = `
        <input type="text" name="tags[]" placeholder="e.g., gaming"
            class="flex-1 px-4 py-3 bg-dark-700/50 border border-gaming rounded-xl text-white placeholder-muted-500 focus:outline-none focus:ring-2 focus:ring-primary-500">
        <button type="button" onclick="this.parentElement.remove()" class="px-4 py-3 bg-red-500 text-white rounded-xl hover:bg-red-600 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    `;
    container.appendChild(div);
}
</script>
@endsection
