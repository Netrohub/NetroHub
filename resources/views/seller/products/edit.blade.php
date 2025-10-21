<x-layouts.app>
    <x-slot name="title">{{ __('Edit Product') }} - {{ config('app.name') }}</x-slot>

<section class="relative pt-32 pb-12">
<div class="py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold bg-gradient-primary bg-clip-text text-transparent">Edit Product</h1>
            <p class="mt-2 text-muted-foreground">Update your product information</p>
        </div>

        <form action="{{ route('seller.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Basic Information -->
            <div class="glass-card p-6">
                <h2 class="text-xl font-bold text-foreground mb-6">Basic Information</h2>
                
                <div class="space-y-6">
                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-foreground mb-2">Product Title *</label>
                        <input type="text" name="title" id="title" value="{{ old('title', $product->title) }}" required
                            class="form-input w-full @error('title') border-red-500 @enderror">
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-foreground mb-2">Description *</label>
                        <textarea name="description" id="description" rows="6" required
                            class="form-textarea w-full @error('description') border-red-500 @enderror">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Category, Price, and Status -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="category_id" class="block text-sm font-medium text-foreground mb-2">Category *</label>
                            <select name="category_id" id="category_id" required
                                class="form-select w-full @error('category_id') border-red-500 @enderror">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="price" class="block text-sm font-medium text-foreground mb-2">Price (USD) *</label>
                            <div class="relative">
                                <span class="absolute left-4 top-2 text-muted-foreground">$</span>
                                <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" step="0.01" min="0" required
                                    class="form-input w-full pl-8 @error('price') border-red-500 @enderror">
                            </div>
                            @error('price')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="status" class="block text-sm font-medium text-foreground mb-2">Status *</label>
                            <select name="status" id="status" required
                                class="form-select w-full @error('status') border-red-500 @enderror">
                                <option value="draft" {{ old('status', $product->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="active" {{ old('status', $product->status) == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="paused" {{ old('status', $product->status) == 'paused' ? 'selected' : '' }}>Paused</option>
                                <option value="archived" {{ old('status', $product->status) == 'archived' ? 'selected' : '' }}>Archived</option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Delivery Type (Read-only) -->
                    <div>
                        <label class="block text-sm font-medium text-foreground mb-2">Delivery Type</label>
                        <div class="px-4 py-3 glass-card rounded-lg">
                            <span class="font-medium text-foreground capitalize">{{ $product->delivery_type }}</span>
                            <span class="text-sm text-muted-foreground ml-2">(Cannot be changed after creation)</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Current Thumbnail -->
            @if($product->thumbnail_url)
            <div class="glass-card p-6">
                <h2 class="text-xl font-bold text-foreground mb-4">Current Thumbnail</h2>
                <img src="{{ $product->thumbnail_url }}" alt="{{ $product->title }}" class="w-full max-w-md rounded-lg">
            </div>
            @endif

            <!-- Product Stats -->
            <div class="glass-card p-6">
                <h2 class="text-xl font-bold text-foreground mb-6">Product Statistics</h2>
                
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="text-center p-4 bg-muted/30 rounded-lg border border-border/50">
                        <div class="text-2xl font-bold text-foreground">{{ $product->sales_count }}</div>
                        <div class="text-sm text-muted-foreground">Sales</div>
                    </div>
                    <div class="text-center p-4 bg-muted/30 rounded-lg border border-border/50">
                        <div class="text-2xl font-bold text-foreground">{{ $product->views_count }}</div>
                        <div class="text-sm text-muted-foreground">Views</div>
                    </div>
                    <div class="text-center p-4 bg-muted/30 rounded-lg border border-border/50">
                        <div class="text-2xl font-bold text-foreground">{{ $product->stock_count ?? '∞' }}</div>
                        <div class="text-sm text-muted-foreground">Stock</div>
                    </div>
                    <div class="text-center p-4 bg-muted/30 rounded-lg border border-border/50">
                        <div class="text-2xl font-bold text-foreground">{{ $product->rating ? number_format($product->rating, 1) : 'N/A' }}</div>
                        <div class="text-sm text-muted-foreground">Rating</div>
                    </div>
                </div>
            </div>

            <!-- Additional Details -->
            <div class="glass-card p-6">
                <h2 class="text-xl font-bold text-foreground mb-6">Additional Details</h2>
                
                <div class="space-y-6">
                    <!-- Features -->
                    <div>
                        <label class="block text-sm font-medium text-foreground mb-2">Features</label>
                        <div id="features-container" class="space-y-2">
                            @if(old('features', $product->features))
                                @foreach(old('features', $product->features) as $feature)
                                <div class="flex gap-2">
                                    <input type="text" name="features[]" value="{{ $feature }}"
                                        class="form-input flex-1">
                                    <button type="button" onclick="this.parentElement.remove()" class="px-4 py-2 bg-destructive text-destructive-foreground rounded-lg hover:bg-destructive/90">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                                @endforeach
                            @endif
                            <div class="flex gap-2">
                                <input type="text" name="features[]" placeholder="Add a new feature"
                                    class="form-input flex-1">
                                <button type="button" onclick="addFeature()" class="px-4 py-2 btn-glow group text-primary-foreground rounded-lg">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Tags -->
                    <div>
                        <label class="block text-sm font-medium text-foreground mb-2">Tags</label>
                        <div id="tags-container" class="space-y-2">
                            @if(old('tags', $product->tags))
                                @foreach(old('tags', $product->tags) as $tag)
                                <div class="flex gap-2">
                                    <input type="text" name="tags[]" value="{{ $tag }}"
                                        class="form-input flex-1">
                                    <button type="button" onclick="this.parentElement.remove()" class="px-4 py-2 bg-destructive text-destructive-foreground rounded-lg hover:bg-destructive/90">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                                @endforeach
                            @endif
                            <div class="flex gap-2">
                                <input type="text" name="tags[]" placeholder="Add a new tag"
                                    class="form-input flex-1">
                                <button type="button" onclick="addTag()" class="px-4 py-2 btn-glow group text-primary-foreground rounded-lg">
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
            <div class="flex items-center justify-between">
                <a href="{{ route('products.show', $product->slug) }}" target="_blank" class="text-primary hover:text-primary/80 font-medium">
                    View Live Product →
                </a>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('seller.products.index') }}" class="px-6 py-3 glass-card border-border/50 rounded-lg text-foreground font-medium hover:border-primary/50 transition-colors">
                        Cancel
                    </a>
                    <button type="submit" class="px-6 py-3 btn-glow group text-primary-foreground font-bold rounded-lg transition-colors">
                        Update Product
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
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
@endpush

</section>

</x-layouts.app>
