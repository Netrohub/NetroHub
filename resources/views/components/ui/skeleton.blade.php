@props([
    'type' => 'text', // text, avatar, card, button
    'width' => 'w-full',
    'height' => 'h-4'
])

@php
$typeClasses = [
    'text' => 'h-4 rounded',
    'title' => 'h-6 rounded',
    'avatar' => 'w-12 h-12 rounded-full',
    'card' => 'w-full h-48 rounded-2xl',
    'button' => 'h-12 rounded-xl',
    'input' => 'h-12 rounded-xl',
];
@endphp

<div {{ $attributes->merge(['class' => 'skeleton ' . $width . ' ' . ($type === 'custom' ? $height : $typeClasses[$type])]) }}></div>


