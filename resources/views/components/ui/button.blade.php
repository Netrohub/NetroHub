@props([
    'variant' => 'primary',
    'size' => 'md',
    'glow' => false,
    'href' => null,
    'type' => 'button'
])

@php
$baseClasses = 'inline-flex items-center justify-center font-semibold rounded-2xl transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-dark-900';
$sizeClasses = [
    'sm' => 'px-4 py-2 text-sm',
    'md' => 'px-6 py-3 text-base',
    'lg' => 'px-8 py-4 text-lg',
    'xl' => 'px-10 py-5 text-xl'
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
