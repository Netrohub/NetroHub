@props([
    'type' => 'text',
    'variant' => 'default',
    'error' => false,
    'icon' => null,
    'iconPosition' => 'left'
])

@php
$baseClasses = 'w-full px-4 py-3 bg-dark-700/50 backdrop-blur-sm border rounded-xl text-white placeholder-muted-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-dark-900 transition-all duration-300';
$variantClasses = [
    'default' => 'border-gaming focus:border-primary-500 focus:ring-primary-500',
    'error' => 'border-red-500 focus:border-red-500 focus:ring-red-500',
    'success' => 'border-green-500 focus:border-green-500 focus:ring-green-500',
    'neon' => 'border-primary-500/50 focus:border-primary-500 focus:ring-primary-500 shadow-glow'
];
$iconClasses = $icon && $iconPosition === 'left' ? 'pl-12' : ($icon && $iconPosition === 'right' ? 'pr-12' : '');
@endphp

<div class="relative">
    @if($icon && $iconPosition === 'left')
        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
            <div class="w-5 h-5 text-muted-400">
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
        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
            <div class="w-5 h-5 text-muted-400">
                {!! $icon !!}
            </div>
        </div>
    @endif

    @if($error)
        <p class="mt-2 text-sm text-red-400 flex items-center">
            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
            {{ $error }}
        </p>
    @endif
</div>
