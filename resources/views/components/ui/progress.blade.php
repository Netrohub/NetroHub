@props([
    'value' => 0,
    'max' => 100,
    'color' => 'primary',
    'showLabel' => false
])

@php
$percentage = $max > 0 ? ($value / $max) * 100 : 0;
@endphp

<div {{ $attributes->class(['w-full']) }}>
    @if($showLabel)
        <div class="flex justify-between text-sm text-muted-400 mb-2">
            <span>{{ $value }} / {{ $max }}</span>
            <span>{{ number_format($percentage, 0) }}%</span>
        </div>
    @endif
    
    <div class="progress">
        <div class="progress-bar" style="width: {{ $percentage }}%"></div>
    </div>
</div>

