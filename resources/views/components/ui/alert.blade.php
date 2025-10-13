@props([
    'type' => 'info', // info, success, warning, error
])

@php
    $classes = match($type) {
        'success' => 'bg-green-500/10 border-green-500/30 text-green-300',
        'warning' => 'bg-yellow-500/10 border-yellow-500/30 text-yellow-300',
        'error' => 'bg-red-500/10 border-red-500/30 text-red-300',
        default => 'bg-blue-500/10 border-blue-500/30 text-blue-300',
    };
@endphp

<div {{ $attributes->merge(['class' => "rounded-xl border p-4 {$classes}"]) }}>
    {{ $slot }}
</div>
