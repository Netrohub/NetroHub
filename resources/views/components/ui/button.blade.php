@props([
    'variant' => 'primary',
    'size' => 'md',
    'glow' => false,
    'href' => null,
    'type' => 'button'
])

@php
$baseClasses = 'inline-flex items-center justify-center gap-2 font-semibold rounded-lg sm:rounded-xl md:rounded-2xl transition-all duration-300 transform md:hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-dark-900 min-h-[44px]';
$sizeClasses = [
    'sm' => 'px-3 py-2 text-xs sm:px-4 sm:py-2 sm:text-sm',
    'md' => 'px-4 py-2.5 text-sm sm:px-6 sm:py-3 sm:text-base',
    'lg' => 'px-5 py-3 text-base sm:px-8 sm:py-4 sm:text-lg',
    'xl' => 'px-6 py-3.5 text-lg sm:px-10 sm:py-5 sm:text-xl'
];
$variantClasses = [
    'primary' => 'bg-gaming-gradient hover:shadow-gaming text-white focus:ring-primary-500',
    'secondary' => 'bg-dark-800/50 backdrop-blur-sm border border-gaming hover:border-gaming-hover text-white hover:shadow-glow',
    'ghost' => 'bg-transparent border border-gaming hover:bg-dark-800/30 text-white hover:shadow-glow',
    'danger' => 'bg-red-600 hover:bg-red-700 text-white focus:ring-red-500 shadow-lg hover:shadow-red-500/50',
    'success' => 'bg-green-600 hover:bg-green-700 text-white focus:ring-green-500 shadow-lg hover:shadow-green-500/50',
    'neon-blue' => 'bg-primary-500 hover:bg-primary-600 text-white shadow-lg hover:shadow-gaming',
    'neon-purple' => 'bg-secondary-500 hover:bg-secondary-600 text-white shadow-lg hover:shadow-gaming-purple'
];
$glowClasses = $glow ? 'animate-glow' : '';
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $baseClasses . ' ' . $sizeClasses[$size] . ' ' . $variantClasses[$variant] . ' ' . $glowClasses]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $baseClasses . ' ' . $sizeClasses[$size] . ' ' . $variantClasses[$variant] . ' ' . $glowClasses]) }}>
        {{ $slot }}
    </button>
@endif
