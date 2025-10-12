@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Seller Settings</h1>
            <p class="mt-2 text-gray-600">Manage your seller profile and preferences</p>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('seller.settings.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Seller Information -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Seller Information</h2>
                
                <div class="space-y-6">
                    <!-- Display Name -->
                    <div>
                        <label for="display_name" class="block text-sm font-medium text-gray-700 mb-2">Display Name *</label>
                        <input type="text" name="display_name" id="display_name" value="{{ old('display_name', $seller->display_name) }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('display_name') border-red-500 @enderror">
                        <p class="mt-1 text-sm text-gray-500">This name will be shown to customers</p>
                        @error('display_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Bio -->
                    <div>
                        <label for="bio" class="block text-sm font-medium text-gray-700 mb-2">Bio</label>
                        <textarea name="bio" id="bio" rows="4"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('bio') border-red-500 @enderror">{{ old('bio', $seller->bio) }}</textarea>
                        <p class="mt-1 text-sm text-gray-500">Tell customers about yourself and your products (max 1000 characters)</p>
                        @error('bio')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Account Email (Read-only) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Account Email</label>
                        <div class="px-4 py-3 bg-gray-100 border border-gray-300 rounded-lg">
                            <span class="text-gray-900">{{ $seller->user->email }}</span>
                            <span class="text-sm text-gray-500 ml-2">(Cannot be changed here)</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Seller Statistics -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Your Statistics</h2>
                
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="text-center p-4 bg-blue-50 rounded-lg">
                        <div class="text-2xl font-bold text-blue-900">{{ $seller->products()->count() }}</div>
                        <div class="text-sm text-blue-700">Products</div>
                    </div>
                    <div class="text-center p-4 bg-green-50 rounded-lg">
                        <div class="text-2xl font-bold text-green-900">{{ $seller->orderItems()->count() }}</div>
                        <div class="text-sm text-green-700">Total Sales</div>
                    </div>
                    <div class="text-center p-4 bg-purple-50 rounded-lg">
                        <div class="text-2xl font-bold text-purple-900">${{ number_format($seller->total_earnings, 2) }}</div>
                        <div class="text-sm text-purple-700">Total Earnings</div>
                    </div>
                    <div class="text-center p-4 bg-yellow-50 rounded-lg">
                        <div class="text-2xl font-bold text-yellow-900">{{ $seller->is_active ? 'Active' : 'Inactive' }}</div>
                        <div class="text-sm text-yellow-700">Status</div>
                    </div>
                </div>
            </div>

            <!-- Payout Information -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Payout Information</h2>
                
                <div class="space-y-6">
                    <!-- Payout Method -->
                    <div>
                        <label for="payout_method" class="block text-sm font-medium text-gray-700 mb-2">Preferred Payout Method</label>
                        <select name="payout_method" id="payout_method"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('payout_method') border-red-500 @enderror">
                            <option value="">Select a method</option>
                            <option value="bank_transfer" {{ old('payout_method', $seller->payout_method) == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                            <option value="paypal" {{ old('payout_method', $seller->payout_method) == 'paypal' ? 'selected' : '' }}>PayPal</option>
                            <option value="stripe" {{ old('payout_method', $seller->payout_method) == 'stripe' ? 'selected' : '' }}>Stripe</option>
                            <option value="wise" {{ old('payout_method', $seller->payout_method) == 'wise' ? 'selected' : '' }}>Wise (TransferWise)</option>
                        </select>
                        @error('payout_method')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Payout Details Info -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <div class="flex">
                            <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                            <div class="text-sm text-blue-800">
                                <p class="font-medium mb-1">Payout Details</p>
                                <p>For detailed payout configuration and bank account details, please contact support or visit the wallet section.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Wallet Balance Display -->
                    <div class="border border-gray-300 rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="text-sm text-gray-600">Current Wallet Balance</div>
                                <div class="text-3xl font-bold text-gray-900 mt-1">${{ number_format($seller->getWalletBalance(), 2) }}</div>
                            </div>
                            <a href="{{ route('seller.wallet.index') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                View Wallet
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Account Status -->
            @if(!$seller->is_active)
            <div class="bg-red-50 border border-red-200 rounded-lg p-6">
                <div class="flex">
                    <svg class="w-6 h-6 text-red-600 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <div>
                        <h3 class="text-lg font-bold text-red-900 mb-1">Account Inactive</h3>
                        <p class="text-sm text-red-800">Your seller account is currently inactive. You cannot create new products or receive new sales. Please contact support for assistance.</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Submit Button -->
            <div class="flex items-center justify-between">
                <a href="{{ route('seller.dashboard') }}" class="text-gray-600 hover:text-gray-700 font-medium">
                    ← Back to Dashboard
                </a>
                <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg transition-colors">
                    Save Settings
                </button>
            </div>
        </form>

        <!-- Danger Zone -->
        <div class="mt-8 bg-white border-2 border-red-200 rounded-lg p-6">
            <h2 class="text-xl font-bold text-red-900 mb-4">Danger Zone</h2>
            <p class="text-sm text-gray-600 mb-4">Once you delete your seller account, there is no going back. All your products will be removed and sales history will be archived.</p>
            <button type="button" onclick="alert('Please contact support to close your seller account.')" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors">
                Close Seller Account
            </button>
        </div>
    </div>
</div>
@endsection
