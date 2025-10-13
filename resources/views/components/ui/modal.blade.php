@props([
    'size' => 'md',
    'backdrop' => true
])

@php
$sizeClasses = [
    'sm' => 'max-w-sm sm:max-w-md',
    'md' => 'max-w-md sm:max-w-lg',
    'lg' => 'max-w-lg sm:max-w-xl md:max-w-2xl',
    'xl' => 'max-w-xl sm:max-w-2xl md:max-w-4xl',
    'full' => 'max-w-full mx-4'
];
@endphp

<div 
    x-data="{ open: @entangle($attributes->wire('model')) }"
    x-show="open"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-50 overflow-y-auto"
    style="display: none;"
>
    @if($backdrop)
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" @click="$wire.set('{{ $attributes->wire('model')->value() }}', false)"></div>
    @endif

    <div class="flex min-h-full items-center justify-center p-2 sm:p-4">
        <div 
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="relative w-full {{ $sizeClasses[$size] }} transform overflow-hidden rounded-xl sm:rounded-2xl bg-dark-800/90 backdrop-blur-xl border border-gaming shadow-2xl"
        >
            <!-- Header -->
            @if(isset($header))
                <div class="border-b border-gaming px-4 py-3 sm:px-6 sm:py-4">
                    <div class="flex items-center justify-between">
                        <div class="text-base sm:text-lg font-semibold text-white">
                            {{ $header }}
                        </div>
                        <button @click="$wire.set('{{ $attributes->wire('model')->value() }}', false)" class="text-muted-400 hover:text-white transition-colors min-h-[44px] min-w-[44px] flex items-center justify-center -mr-2">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>
            @endif

            <!-- Content -->
            <div class="p-4 sm:p-6">
                {{ $slot }}
            </div>

            <!-- Footer -->
            @if(isset($footer))
                <div class="border-t border-gaming px-4 py-3 sm:px-6 sm:py-4">
                    {{ $footer }}
                </div>
            @endif
        </div>
    </div>
</div>
