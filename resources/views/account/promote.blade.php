@extends('layouts.app')

@section('content')
<div class="min-h-screen relative overflow-hidden bg-dark-900 py-10">
    <!-- Gaming Background Effects -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-primary-500/5 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-1/4 right-1/4 w-80 h-80 bg-secondary-500/5 rounded-full blur-3xl animate-float animation-delay-2000"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center gap-3 mb-2">
                <a href="{{ route('account.index') }}" class="text-muted-400 hover:text-white transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <h1 class="text-4xl font-black text-white bg-gaming-gradient bg-clip-text text-transparent">Promote Product</h1>
            </div>
            <p class="text-muted-300">Boost visibility and reach more customers</p>
        </div>

        <!-- Promotion Options -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <x-ui.card variant="glass" :hover="false" class="border-2 border-primary-500/30">
                <div class="text-center mb-4">
                    <div class="w-16 h-16 bg-primary-500/20 rounded-xl mx-auto flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Featured Product</h3>
                    <p class="text-3xl font-black text-white mb-1">$5<span class="text-lg text-muted-400">/day</span></p>
                    <p class="text-sm text-muted-400">Appear in featured section on homepage</p>
                </div>
                <ul class="space-y-2 mb-6">
                    <li class="flex items-center gap-2 text-sm text-muted-300">
                        <svg class="w-4 h-4 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Homepage visibility
                    </li>
                    <li class="flex items-center gap-2 text-sm text-muted-300">
                        <svg class="w-4 h-4 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Priority in search results
                    </li>
                    <li class="flex items-center gap-2 text-sm text-muted-300">
                        <svg class="w-4 h-4 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        "Featured" badge
                    </li>
                </ul>
            </x-ui.card>

            <x-ui.card variant="glass" :hover="false" class="border-2 border-secondary-500/30">
                <div class="text-center mb-4">
                    <div class="w-16 h-16 bg-secondary-500/20 rounded-xl mx-auto flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Sponsored Slot</h3>
                    <p class="text-3xl font-black text-white mb-1">$10<span class="text-lg text-muted-400">/day</span></p>
                    <p class="text-sm text-muted-400">Top of category page</p>
                </div>
                <ul class="space-y-2 mb-6">
                    <li class="flex items-center gap-2 text-sm text-muted-300">
                        <svg class="w-4 h-4 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Category page top position
                    </li>
                    <li class="flex items-center gap-2 text-sm text-muted-300">
                        <svg class="w-4 h-4 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        All featured benefits
                    </li>
                    <li class="flex items-center gap-2 text-sm text-muted-300">
                        <svg class="w-4 h-4 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        "Sponsored" badge
                    </li>
                </ul>
            </x-ui.card>

            <x-ui.card variant="glass" :hover="false" class="border-2 border-yellow-500/30">
                <div class="text-center mb-4">
                    <div class="w-16 h-16 bg-yellow-500/20 rounded-xl mx-auto flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Premium Boost</h3>
                    <p class="text-3xl font-black text-white mb-1">$15<span class="text-lg text-muted-400">/day</span></p>
                    <p class="text-sm text-muted-400">Maximum visibility everywhere</p>
                </div>
                <ul class="space-y-2 mb-6">
                    <li class="flex items-center gap-2 text-sm text-muted-300">
                        <svg class="w-4 h-4 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Homepage + Category top
                    </li>
                    <li class="flex items-center gap-2 text-sm text-muted-300">
                        <svg class="w-4 h-4 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Search results priority
                    </li>
                    <li class="flex items-center gap-2 text-sm text-muted-300">
                        <svg class="w-4 h-4 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Special golden badge
                    </li>
                </ul>
            </x-ui.card>
        </div>

        <!-- Promote Form -->
        <x-ui.card variant="glass">
            <h2 class="text-2xl font-bold text-white mb-6">Boost Your Product</h2>

            <form action="{{ route('account.promote') }}" method="POST" class="max-w-3xl">
                @csrf
                
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-muted-300 mb-2">Select Product</label>
                        <select name="product_id" class="w-full px-4 py-3 bg-dark-700/50 border border-gaming rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-primary-500" required>
                            <option value="">Choose a product</option>
                            @if(auth()->user()->seller)
                                @foreach(auth()->user()->seller->products()->where('status', 'active')->get() as $product)
                                    <option value="{{ $product->id }}">{{ $product->title }} - ${{ number_format($product->price, 2) }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-muted-300 mb-2">Promotion Type</label>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <label class="relative cursor-pointer">
                                <input type="radio" name="promotion_type" value="featured" class="peer sr-only" required>
                                <div class="p-4 border-2 border-gaming rounded-xl peer-checked:border-primary-500 peer-checked:bg-primary-500/10 transition-all">
                                    <p class="font-bold text-white mb-1">Featured</p>
                                    <p class="text-2xl font-black text-white">$5<span class="text-sm text-muted-400">/day</span></p>
                                </div>
                            </label>

                            <label class="relative cursor-pointer">
                                <input type="radio" name="promotion_type" value="sponsored" class="peer sr-only">
                                <div class="p-4 border-2 border-gaming rounded-xl peer-checked:border-secondary-500 peer-checked:bg-secondary-500/10 transition-all">
                                    <p class="font-bold text-white mb-1">Sponsored</p>
                                    <p class="text-2xl font-black text-white">$10<span class="text-sm text-muted-400">/day</span></p>
                                </div>
                            </label>

                            <label class="relative cursor-pointer">
                                <input type="radio" name="promotion_type" value="premium" class="peer sr-only">
                                <div class="p-4 border-2 border-gaming rounded-xl peer-checked:border-yellow-500 peer-checked:bg-yellow-500/10 transition-all">
                                    <p class="font-bold text-white mb-1">Premium</p>
                                    <p class="text-2xl font-black text-white">$15<span class="text-sm text-muted-400">/day</span></p>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-muted-300 mb-2">Duration (Days)</label>
                        <input type="number" name="duration" min="1" max="30" value="7" class="w-full px-4 py-3 bg-dark-700/50 border border-gaming rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-primary-500" required>
                        <p class="text-xs text-muted-400 mt-1">Minimum 1 day, maximum 30 days</p>
                    </div>

                    <div class="bg-dark-700/30 rounded-xl p-4 border border-gaming">
                        <div class="flex items-center justify-between">
                            <span class="text-muted-300">Total Cost:</span>
                            <span class="text-2xl font-black text-white" id="totalCost">$0.00</span>
                        </div>
                    </div>

                    <button type="submit" class="w-full md:w-auto px-8 py-3 bg-gaming-gradient text-white rounded-xl font-bold hover:shadow-gaming-lg transition-all">
                        Start Promotion
                    </button>
                </div>
            </form>
        </x-ui.card>

        <!-- Active Promotions -->
        <x-ui.card variant="glass" class="mt-8">
            <h2 class="text-2xl font-bold text-white mb-6">Active Promotions</h2>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="text-left text-muted-400 border-b border-gaming">
                        <tr>
                            <th class="px-4 py-3">Product</th>
                            <th class="px-4 py-3">Type</th>
                            <th class="px-4 py-3">Started</th>
                            <th class="px-4 py-3">Ends</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gaming">
                        <tr>
                            <td colspan="6" class="px-4 py-10 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <svg class="w-12 h-12 text-muted-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                    <p class="text-muted-400">No active promotions</p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </x-ui.card>
    </div>
</div>

<script>
// Calculate total cost dynamically
document.addEventListener('DOMContentLoaded', function() {
    const durationInput = document.querySelector('input[name="duration"]');
    const typeInputs = document.querySelectorAll('input[name="promotion_type"]');
    const totalCostElement = document.getElementById('totalCost');

    function calculateTotal() {
        const duration = parseInt(durationInput.value) || 0;
        const selectedType = document.querySelector('input[name="promotion_type"]:checked');
        
        let pricePerDay = 0;
        if (selectedType) {
            if (selectedType.value === 'featured') pricePerDay = 5;
            if (selectedType.value === 'sponsored') pricePerDay = 10;
            if (selectedType.value === 'premium') pricePerDay = 15;
        }

        const total = duration * pricePerDay;
        totalCostElement.textContent = '$' + total.toFixed(2);
    }

    durationInput.addEventListener('input', calculateTotal);
    typeInputs.forEach(input => input.addEventListener('change', calculateTotal));
});
</script>
@endsection

