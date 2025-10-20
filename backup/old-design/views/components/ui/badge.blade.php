@props([
    'variant' => 'default',
    'size' => 'md',
    'glow' => false
])

@php
$baseClasses = 'inline-flex items-center font-medium rounded-xl transition-all duration-300';
$sizeClasses = [
    'sm' => 'px-2 py-1 text-xs',
    'md' => 'px-3 py-1 text-sm',
    'lg' => 'px-4 py-2 text-base'
];
$variantClasses = [
    'default' => 'bg-dark-700 text-muted-300 border border-gaming',
    'primary' => 'bg-primary-500 text-white shadow-glow',
    'secondary' => 'bg-secondary-500 text-white shadow-glow-purple',
    'success' => 'bg-green-500 text-white',
    'warning' => 'bg-yellow-500 text-black',
    'error' => 'bg-red-500 text-white',
    'neon-blue' => 'bg-primary-500/20 text-primary-300 border border-primary-500/30',
    'neon-purple' => 'bg-secondary-500/20 text-secondary-300 border border-secondary-500/30',
    'glass' => 'bg-white/10 backdrop-blur-sm text-white border border-gaming'
];
$glowClasses = $glow ? 'animate-glow' : '';
@endphp

<span {{ $attributes->merge(['class' => $baseClasses . ' ' . $sizeClasses[$size] . ' ' . $variantClasses[$variant] . ' ' . $glowClasses]) }}>
    {{ $slot }}
</span>
