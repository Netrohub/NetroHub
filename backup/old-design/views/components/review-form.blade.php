@props(['product', 'review' => null])

@php
    $isEdit = $review !== null;
    $action = $isEdit ? route('reviews.update', $review) : route('reviews.store', $product);
    $method = $isEdit ? 'PUT' : 'POST';
@endphp

<div class="bg-dark-800/50 border border-gaming rounded-2xl p-6" id="review-form">
    <h3 class="text-xl font-bold text-white mb-4">
        {{ $isEdit ? 'Edit Your Review' : 'Write a Review' }}
    </h3>
    
    <form action="{{ $action }}" method="POST" class="space-y-4">
        @csrf
        @if ($isEdit)
            @method('PUT')
        @endif
        
        {{-- Rating --}}
        <div>
            <label class="block text-sm font-semibold text-white mb-2">Rating *</label>
            <div class="flex gap-2" id="star-rating">
                @for ($i = 1; $i <= 5; $i++)
                    <label class="cursor-pointer star-label" data-rating="{{ $i }}">
                        <input type="radio" name="rating" value="{{ $i }}" 
                               {{ old('rating', $review?->rating) == $i ? 'checked' : '' }}
                               class="sr-only" required>
                        <svg class="w-8 h-8 star-icon text-gray-600 hover:text-yellow-300 transition-colors" 
                             viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                        </svg>
                    </label>
                @endfor
            </div>
            @error('rating')
                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>
        
        {{-- Title --}}
        <div>
            <label for="title" class="block text-sm font-semibold text-white mb-2">
                Review Title <span class="text-muted-400 font-normal">(optional)</span>
            </label>
            <input type="text" 
                   id="title" 
                   name="title" 
                   value="{{ old('title', $review?->title) }}"
                   class="w-full bg-dark-800 border border-gaming rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                   placeholder="Sum up your experience in one line">
            @error('title')
                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>
        
        {{-- Body --}}
        <div>
            <label for="body" class="block text-sm font-semibold text-white mb-2">Your Review *</label>
            <textarea id="body" 
                      name="body" 
                      rows="6"
                      required
                      class="w-full bg-dark-800 border border-gaming rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent resize-none"
                      placeholder="Share your experience with this product...">{{ old('body', $review?->body) }}</textarea>
            <div class="flex justify-between mt-1">
                <div>
                    @error('body')
                        <p class="text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
        
        {{-- Info Notice --}}
        <div class="bg-dark-900/50 border border-gaming rounded-lg p-4">
            <div class="flex gap-3">
                <svg class="w-5 h-5 text-primary-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
                <div class="text-sm text-muted-400">
                    <p>Your review will be publicly visible. Please avoid sharing personal contact information (emails, phone numbers, links).</p>
                </div>
            </div>
        </div>
        
        {{-- Submit Button --}}
        <div class="flex gap-3">
            <x-ui.button type="submit" variant="primary" size="lg" class="flex-1">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                {{ $isEdit ? 'Update Review' : 'Submit Review' }}
            </x-ui.button>
            @if ($isEdit)
                <x-ui.button type="button" variant="secondary" size="lg" onclick="cancelEdit()">
                    Cancel
                </x-ui.button>
            @endif
        </div>
    </form>
</div>

<script>
// Star rating functionality
document.addEventListener('DOMContentLoaded', function() {
    const starLabels = document.querySelectorAll('.star-label');
    const starIcons = document.querySelectorAll('.star-icon');
    
    // Function to update star colors based on rating
    function updateStars(rating) {
        starIcons.forEach((icon, index) => {
            if (index < rating) {
                icon.classList.remove('text-gray-600');
                icon.classList.add('text-yellow-400');
            } else {
                icon.classList.remove('text-yellow-400');
                icon.classList.add('text-gray-600');
            }
        });
    }
    
    // Handle star clicks
    starLabels.forEach((label, index) => {
        label.addEventListener('click', function() {
            const rating = parseInt(this.getAttribute('data-rating'));
            const radio = this.querySelector('input[type="radio"]');
            radio.checked = true;
            updateStars(rating);
        });
        
        // Handle hover effects
        label.addEventListener('mouseenter', function() {
            const rating = parseInt(this.getAttribute('data-rating'));
            updateStars(rating);
        });
    });
    
    // Reset stars on mouse leave (except when a rating is selected)
    document.getElementById('star-rating').addEventListener('mouseleave', function() {
        const checkedRadio = document.querySelector('input[name="rating"]:checked');
        if (checkedRadio) {
            updateStars(parseInt(checkedRadio.value));
        } else {
            updateStars(0);
        }
    });
    
        // Initialize stars if there's already a selected rating
        const checkedRadio = document.querySelector('input[name="rating"]:checked');
        if (checkedRadio) {
            updateStars(parseInt(checkedRadio.value));
        }
        
        // Handle form submission in modal
        const form = document.querySelector('#review-form form');
        if (form) {
            form.addEventListener('submit', function(e) {
                // Don't prevent default, let it submit normally
                // The form will redirect back to the orders page after submission
            });
        }
});

@if ($isEdit)
function cancelEdit() {
    window.location.reload();
}
@endif

function editReview(reviewId) {
    // Scroll to form
    document.getElementById('review-form').scrollIntoView({ behavior: 'smooth' });
}
</script>

