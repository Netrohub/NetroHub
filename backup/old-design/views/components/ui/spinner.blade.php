@props([
    'size' => 'md', // sm, md, lg
    'color' => 'white'
])

@php
$sizeClasses = [
    'sm' => 'w-4 h-4 border-2',
    'md' => 'w-6 h-6 border-2',
    'lg' => 'w-8 h-8 border-3',
    'xl' => 'w-12 h-12 border-4',
];
@endphp

<div {{ $attributes->merge(['class' => 'spinner ' . $sizeClasses[$size]]) }}></div>


