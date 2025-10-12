@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Create New Product</h1>
            <p class="mt-2 text-gray-600">Add a new digital product to your store</p>
        </div>

        <form action="{{ route('seller.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Basic Information -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Basic Information</h2>
                
                <div class="space-y-6">
                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Product Title *</label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('title') border-red-500 @enderror">
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description *</label>
                        <textarea name="description" id="description" rows="6" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Category and Price -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">Category *</label>
                            <select name="category_id" id="category_id" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('category_id') border-red-500 @enderror">
                                <option value="">Select a category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Price (USD) *</label>
                            <div class="relative">
                                <span class="absolute left-4 top-2 text-gray-500">$</span>
                                <input type="number" name="price" id="price" value="{{ old('price') }}" step="0.01" min="0" required
                                    class="w-full pl-8 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('price') border-red-500 @enderror">
                            </div>
                            @error('price')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Delivery Type -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Delivery Type *</label>
                        <div class="space-y-3">
                            <label class="flex items-start p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50">
                                <input type="radio" name="delivery_type" value="file" {{ old('delivery_type') == 'file' ? 'checked' : '' }} required class="mt-1">
                                <div class="ml-3">
                                    <div class="font-medium text-gray-900">File Download</div>
                                    <div class="text-sm text-gray-500">Digital files that customers can download (unlimited stock)</div>
                                </div>
                            </label>
                            <label class="flex items-start p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50">
                                <input type="radio" name="delivery_type" value="code" {{ old('delivery_type') == 'code' ? 'checked' : '' }} class="mt-1">
                                <div class="ml-3">
                                    <div class="font-medium text-gray-900">License Keys/Codes</div>
                                    <div class="text-sm text-gray-500">Product codes or license keys (limited stock)</div>
                                </div>
                            </label>
                            <label class="flex items-start p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50">
                                <input type="radio" name="delivery_type" value="hybrid" {{ old('delivery_type') == 'hybrid' ? 'checked' : '' }} class="mt-1">
                                <div class="ml-3">
                                    <div class="font-medium text-gray-900">Both (Hybrid)</div>
                                    <div class="text-sm text-gray-500">Files + license keys combination</div>
                                </div>
                            </label>
                        </div>
                        @error('delivery_type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Media -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Media</h2>
                
                <div class="space-y-6">
                    <!-- Thumbnail -->
                    <div>
                        <label for="thumbnail" class="block text-sm font-medium text-gray-700 mb-2">Product Thumbnail</label>
                        <input type="file" name="thumbnail" id="thumbnail" accept="image/*"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <p class="mt-1 text-sm text-gray-500">Recommended: 1280x720px (16:9 aspect ratio), max 2MB</p>
                        @error('thumbnail')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Product Files -->
                    <div id="files-section">
                        <label for="files" class="block text-sm font-medium text-gray-700 mb-2">Product Files</label>
                        <input type="file" name="files[]" id="files" multiple
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <p class="mt-1 text-sm text-gray-500">Upload files that customers will receive. Max 100MB per file</p>
                        @error('files.*')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Product Codes -->
            <div id="codes-section" class="bg-white rounded-lg shadow-sm p-6" style="display: none;">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Product Codes / License Keys</h2>
                
                <div>
                    <label for="codes" class="block text-sm font-medium text-gray-700 mb-2">Enter Codes (one per line)</label>
                    <textarea name="codes" id="codes" rows="10" placeholder="XXXX-XXXX-XXXX-XXXX&#10;YYYY-YYYY-YYYY-YYYY&#10;ZZZZ-ZZZZ-ZZZZ-ZZZZ"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent font-mono text-sm">{{ old('codes') }}</textarea>
                    <p class="mt-1 text-sm text-gray-500">Each line represents one license key or product code</p>
                    @error('codes')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Credentials (Secure Account Delivery) -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-start justify-between mb-6">
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">Secure Credentials (Optional)</h2>
                        <p class="text-sm text-gray-600 mt-1">For selling accounts with username/password - delivered securely via encrypted page</p>
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" name="has_credentials" id="has_credentials" value="1" {{ old('has_credentials') ? 'checked' : '' }}
                            class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <label for="has_credentials" class="ml-2 text-sm font-medium text-gray-700">Enable Credentials</label>
                    </div>
                </div>

                <div id="credentials-section" style="display: none;">
                    <!-- Security Notice -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-blue-600 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                            </svg>
                            <div class="flex-1 text-sm text-blue-800">
                                <strong>🔒 Secure Delivery:</strong> Credentials are encrypted at rest and never sent via email. Buyers access them through a secure page with view limits and audit logging.
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <!-- Username -->
                        <div>
                            <label for="credential_username" class="block text-sm font-medium text-gray-700 mb-2">Username / Email *</label>
                            <input type="text" name="credential_username" id="credential_username" value="{{ old('credential_username') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent font-mono @error('credential_username') border-red-500 @enderror">
                            @error('credential_username')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="credential_password" class="block text-sm font-medium text-gray-700 mb-2">Password *</label>
                            <input type="text" name="credential_password" id="credential_password" value="{{ old('credential_password') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent font-mono @error('credential_password') border-red-500 @enderror">
                            @error('credential_password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Extras (2FA codes, backup codes, etc.) -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Extra Information (2FA, backup codes, etc.)</label>
                            <div id="extras-container" class="space-y-3">
                                <div class="flex gap-2">
                                    <input type="text" name="credential_extras_keys[]" placeholder="e.g., 2FA Backup Codes"
                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <input type="text" name="credential_extras_values[]" placeholder="e.g., ABC123, DEF456"
                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent font-mono">
                                    <button type="button" onclick="addExtra()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <p class="mt-1 text-sm text-gray-500">Add any extra information like backup codes, security questions, etc.</p>
                        </div>

                        <!-- Instructions -->
                        <div>
                            <label for="credential_instructions" class="block text-sm font-medium text-gray-700 mb-2">Instructions for Buyer</label>
                            <textarea name="credential_instructions" id="credential_instructions" rows="4" placeholder="e.g., Please change the password immediately after login."
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('credential_instructions') }}</textarea>
                            <p class="mt-1 text-sm text-gray-500">Provide any special instructions or notes for the buyer</p>
                        </div>

                        <!-- Unique Credential -->
                        <div class="border-t border-gray-200 pt-6">
                            <label class="flex items-start">
                                <input type="checkbox" name="is_unique_credential" id="is_unique_credential" value="1" {{ old('is_unique_credential') ? 'checked' : '' }}
                                    class="mt-1 w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                <div class="ml-3">
                                    <div class="font-medium text-gray-900">This is a unique account (one-time sale)</div>
                                    <div class="text-sm text-gray-600">Enable this if you're selling a single account. The product will be automatically archived after the first sale.</div>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Details -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Additional Details</h2>
                
                <div class="space-y-6">
                    <!-- Features -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Features</label>
                        <div id="features-container" class="space-y-2">
                            <div class="flex gap-2">
                                <input type="text" name="features[]" placeholder="e.g., Lifetime updates"
                                    class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <button type="button" onclick="addFeature()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Tags -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tags</label>
                        <div id="tags-container" class="space-y-2">
                            <div class="flex gap-2">
                                <input type="text" name="tags[]" placeholder="e.g., premium, digital, software"
                                    class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <button type="button" onclick="addTag()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center justify-end space-x-4">
                <a href="{{ route('seller.products.index') }}" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg transition-colors">
                    Create Product
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Toggle codes section based on delivery type
document.querySelectorAll('input[name="delivery_type"]').forEach(radio => {
    radio.addEventListener('change', function() {
        const codesSection = document.getElementById('codes-section');
        const filesSection = document.getElementById('files-section');
        
        if (this.value === 'code' || this.value === 'hybrid') {
            codesSection.style.display = 'block';
        } else {
            codesSection.style.display = 'none';
        }
        
        if (this.value === 'file' || this.value === 'hybrid') {
            filesSection.style.display = 'block';
        } else {
            filesSection.style.display = 'none';
        }
    });
});

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    const selectedType = document.querySelector('input[name="delivery_type"]:checked');
    if (selectedType) {
        selectedType.dispatchEvent(new Event('change'));
    }
    
    // Initialize credentials section visibility
    const hasCredentialsCheckbox = document.getElementById('has_credentials');
    if (hasCredentialsCheckbox) {
        toggleCredentials();
    }
});

// Toggle credentials section
function toggleCredentials() {
    const checkbox = document.getElementById('has_credentials');
    const section = document.getElementById('credentials-section');
    section.style.display = checkbox.checked ? 'block' : 'none';
}

document.getElementById('has_credentials')?.addEventListener('change', toggleCredentials);

function addFeature() {
    const container = document.getElementById('features-container');
    const div = document.createElement('div');
    div.className = 'flex gap-2';
    div.innerHTML = `
        <input type="text" name="features[]" placeholder="e.g., 24/7 support"
            class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        <button type="button" onclick="this.parentElement.remove()" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
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
            class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        <input type="text" name="credential_extras_values[]" placeholder="Answer or value"
            class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent font-mono">
        <button type="button" onclick="this.parentElement.remove()" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
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
        <input type="text" name="tags[]" placeholder="e.g., design"
            class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        <button type="button" onclick="this.parentElement.remove()" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    `;
    container.appendChild(div);
}
</script>
@endsection
