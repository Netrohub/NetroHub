@props([
    'type' => 'text',
    'variant' => 'default',
    'error' => false,
    'icon' => null,
    'iconPosition' => 'left'
])

@php
$baseClasses = 'w-full px-3 py-2 sm:px-4 sm:py-3 text-sm sm:text-base bg-dark-700/50 backdrop-blur-sm border rounded-lg sm:rounded-xl text-slate-200 placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-dark-900 transition-all duration-300 min-h-[44px]';
$variantClasses = [
    'default' => 'border-gaming focus:border-primary-500 focus:ring-primary-500',
    'error' => 'border-rose-500/50 focus:border-rose-500 focus:ring-rose-500 bg-rose-500/5',
    'success' => 'border-emerald-500 focus:border-emerald-500 focus:ring-emerald-500',
    'neon' => 'border-primary-500/50 focus:border-primary-500 focus:ring-primary-500 shadow-glow'
];
$iconClasses = $icon && $iconPosition === 'left' ? 'pl-10 sm:pl-12' : ($icon && $iconPosition === 'right' ? 'pr-10 sm:pr-12' : '');
@endphp

<div class="relative">
    @if($icon && $iconPosition === 'left')
        <div class="absolute inset-y-0 left-0 pl-3 sm:pl-4 flex items-center pointer-events-none">
            <div class="w-4 h-4 sm:w-5 sm:h-5 text-muted-400">
                {!! $icon !!}
            </div>
        </div>
    @endif

    <input 
        type="{{ $type }}" 
        {{ $attributes->merge([
            'class' => $baseClasses . ' ' . $variantClasses[$error ? 'error' : $variant] . ' ' . $iconClasses
        ]) }}
    >

    @if($icon && $iconPosition === 'right')
        <div class="absolute inset-y-0 right-0 pr-3 sm:pr-4 flex items-center pointer-events-none">
            <div class="w-4 h-4 sm:w-5 sm:h-5 text-muted-400">
                {!! $icon !!}
            </div>
        </div>
    @endif

    @if($error)
        <p class="mt-1.5 sm:mt-2 text-xs sm:text-sm text-rose-300 flex items-center gap-1">
            <svg class="w-3 h-3 sm:w-4 sm:h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
            {{ $error }}
        </p>
    @endif
</div>
