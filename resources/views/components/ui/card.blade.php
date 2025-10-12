@props([
    'variant' => 'default',
    'hover' => true,
    'glow' => false,
    'padding' => 'p-6'
])

@php
$baseClasses = 'bg-dark-800/50 backdrop-blur-xl border border-gaming rounded-2xl transition-all duration-300';
$variantClasses = [
    'default' => 'shadow-lg hover:shadow-xl',
    'elevated' => 'shadow-xl hover:shadow-2xl',
    'glass' => 'bg-white/5 backdrop-blur-md',
    'neon' => 'border-primary-500/30 shadow-glow'
];
$hoverClasses = $hover ? 'hover:scale-105 hover:border-gaming-hover' : '';
$glowClasses = $glow ? 'hover:shadow-gaming' : '';
@endphp

<div {{ $attributes->merge(['class' => $baseClasses . ' ' . $variantClasses[$variant] . ' ' . $hoverClasses . ' ' . $glowClasses . ' ' . $padding]) }}>
    {{ $slot }}
</div>
