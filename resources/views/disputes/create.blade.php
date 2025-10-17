<x-layouts.stellar>
    <x-slot name="title">{{ __('Create Dispute') }} - {{ config('app.name') }}</x-slot>

    <section class="relative pt-32 pb-12 md:pb-20">
        <div class="max-w-4xl mx-auto px-4 sm:px-6">
            
            <div class="mb-8">
                <a href="{{ route('disputes.index') }}" class="inline-flex items-center text-purple-400 hover:text-purple-300 mb-4">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    {{ __('Back to Disputes') }}
                </a>
                <h1 class="h2 bg-clip-text text-transparent bg-gradient-to-r from-slate-200/60 via-slate-200 to-slate-200/60">
                    {{ __('Create a Dispute') }}
                </h1>
                <p class="text-slate-400 mt-2">{{ __('Please provide details about your issue. Our team will review it and work to resolve it fairly.') }}</p>
            </div>

            <div class="bg-slate-800/50 rounded-2xl p-8 border border-slate-700/50" data-aos="fade-up">
                
                @if($order)
                    <!-- Order Info -->
                    <div class="bg-slate-900/50 rounded-xl p-6 mb-8 border border-slate-700/50">
                        <h3 class="text-lg font-bold text-slate-100 mb-4">{{ __('Order Information') }}</h3>
                        <div class="grid md:grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-slate-400">{{ __('Order Number:') }}</span>
                                <span class="text-slate-100 ml-2 font-medium">{{ $order->order_number }}</span>
                            </div>
                            <div>
                                <span class="text-slate-400">{{ __('Date:') }}</span>
                                <span class="text-slate-100 ml-2">{{ $order->created_at->format('M d, Y') }}</span>
                            </div>
                            <div>
                                <span class="text-slate-400">{{ __('Total:') }}</span>
                                <span class="text-slate-100 ml-2 font-bold">${{ number_format($order->total, 2) }}</span>
                            </div>
                            <div>
                                <span class="text-slate-400">{{ __('Status:') }}</span>
                                <span class="text-slate-100 ml-2">{{ ucfirst($order->status) }}</span>
                            </div>
                        </div>
                        
                        @if($orderItem)
                            <div class="mt-4 pt-4 border-t border-slate-700/50">
                                <span class="text-slate-400 text-sm">{{ __('Selected Product:') }}</span>
                                <div class="flex items-center gap-3 mt-2">
                                    <div class="w-10 h-10 bg-slate-700 rounded-lg flex items-center justify-center">
                                        <x-platform-icon :product="$orderItem->product" />
                                    </div>
                                    <div>
                                        <div class="text-slate-100 font-medium">{{ $orderItem->product_title }}</div>
                                        <div class="text-sm text-slate-400">${{ number_format($orderItem->price, 2) }}</div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif

                <!-- Dispute Form -->
                <form action="{{ route('disputes.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    @if($order)
                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                        @if($orderItem)
                            <input type="hidden" name="order_item_id" value="{{ $orderItem->id }}">
                        @endif
                    @else
                        <!-- Order Selection -->
                        <div>
                            <label for="order_id" class="block text-sm font-medium text-slate-200 mb-2">
                                {{ __('Select Order') }} <span class="text-red-400">*</span>
                            </label>
                            <select name="order_id" id="order_id" required class="form-select w-full bg-slate-700 border-slate-600 text-slate-100 rounded-lg focus:border-purple-500 focus:ring-purple-500">
                                <option value="">{{ __('Choose an order...') }}</option>
                                @foreach(auth()->user()->orders()->latest()->get() as $userOrder)
                                    <option value="{{ $userOrder->id }}">
                                        {{ __('Order #:number - :date - :total', [
                                            'number' => $userOrder->order_number,
                                            'date' => $userOrder->created_at->format('M d, Y'),
                                            'total' => '$' . number_format($userOrder->total, 2)
                                        ]) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('order_id')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    @endif

                    <!-- Reason -->
                    <div>
                        <label for="reason" class="block text-sm font-medium text-slate-200 mb-2">
                            {{ __('Reason for Dispute') }} <span class="text-red-400">*</span>
                        </label>
                        <select name="reason" id="reason" required class="form-select w-full bg-slate-700 border-slate-600 text-slate-100 rounded-lg focus:border-purple-500 focus:ring-purple-500">
                            <option value="">{{ __('Select a reason...') }}</option>
                            <option value="Product not as described">{{ __('Product not as described') }}</option>
                            <option value="Product not working">{{ __('Product not working') }}</option>
                            <option value="Wrong product delivered">{{ __('Wrong product delivered') }}</option>
                            <option value="Product never received">{{ __('Product never received') }}</option>
                            <option value="Defective or damaged">{{ __('Defective or damaged') }}</option>
                            <option value="Seller unresponsive">{{ __('Seller unresponsive') }}</option>
                            <option value="Other">{{ __('Other') }}</option>
                        </select>
                        @error('reason')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-slate-200 mb-2">
                            {{ __('Detailed Description') }} <span class="text-red-400">*</span>
                        </label>
                        <textarea name="description" id="description" rows="6" required minlength="20" 
                            class="form-textarea w-full bg-slate-700 border-slate-600 text-slate-100 rounded-lg focus:border-purple-500 focus:ring-purple-500"
                            placeholder="{{ __('Please provide a detailed explanation of the issue. Include any relevant information that can help us resolve this dispute fairly.') }}">{{ old('description') }}</textarea>
                        <p class="mt-1 text-xs text-slate-400">{{ __('Minimum 20 characters') }}</p>
                        @error('description')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Evidence Upload -->
                    <div>
                        <label for="evidence" class="block text-sm font-medium text-slate-200 mb-2">
                            {{ __('Evidence (Optional)') }}
                        </label>
                        <div class="relative">
                            <input type="file" name="evidence[]" id="evidence" multiple accept=".jpg,.jpeg,.png,.pdf" 
                                class="block w-full text-sm text-slate-300 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-purple-500 file:text-white hover:file:bg-purple-600 file:cursor-pointer border border-slate-600 rounded-lg bg-slate-700 cursor-pointer focus:outline-none focus:border-purple-500">
                        </div>
                        <p class="mt-1 text-xs text-slate-400">
                            {{ __('Upload screenshots, photos, or documents (JPG, PNG, PDF). Max 5MB per file.') }}
                        </p>
                        @error('evidence.*')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Important Notice -->
                    <div class="bg-blue-500/10 border border-blue-500/30 rounded-xl p-4">
                        <div class="flex gap-3">
                            <svg class="w-6 h-6 text-blue-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div class="text-sm text-blue-200">
                                <p class="font-semibold mb-1">{{ __('Important Information') }}</p>
                                <ul class="list-disc list-inside space-y-1 text-blue-300">
                                    <li>{{ __('All disputes are reviewed by our moderation team within 24-48 hours') }}</li>
                                    <li>{{ __('Both you and the seller will be able to communicate during the review process') }}</li>
                                    <li>{{ __('Please be honest and provide accurate information') }}</li>
                                    <li>{{ __('False disputes may result in account restrictions') }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex flex-wrap gap-4 pt-6 border-t border-slate-700/50">
                        <button type="submit" class="btn text-white bg-gradient-to-r from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 shadow-lg">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ __('Submit Dispute') }}
                        </button>
                        <a href="{{ route('disputes.index') }}" class="btn text-slate-300 bg-slate-700 hover:bg-slate-600">
                            {{ __('Cancel') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</x-layouts.stellar>


