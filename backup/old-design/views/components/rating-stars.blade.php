@props(['rating' => 0, 'size' => 'md', 'showNumber' => true])

@php
    $fullStars = floor($rating);
    $hasHalfStar = ($rating - $fullStars) >= 0.5;
    $emptyStars = 5 - $fullStars - ($hasHalfStar ? 1 : 0);
    
    $sizeClasses = [
        'sm' => 'w-3 h-3',
        'md' => 'w-4 h-4',
        'lg' => 'w-5 h-5',
        'xl' => 'w-6 h-6',
    ];
    
    $sizeClass = $sizeClasses[$size] ?? $sizeClasses['md'];
@endphp

<div {{ $attributes->merge(['class' => 'flex items-center gap-1']) }}>
    {{-- Full stars --}}
    @for ($i = 0; $i < $fullStars; $i++)
        <svg class="{{ $sizeClass }} text-yellow-400 fill-current" viewBox="0 0 20 20">
            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
        </svg>
    @endfor

    {{-- Half star --}}
    @if ($hasHalfStar)
        <svg class="{{ $sizeClass }} text-yellow-400" viewBox="0 0 20 20">
            <defs>
                <linearGradient id="half-fill-{{ uniqid() }}">
                    <stop offset="50%" stop-color="currentColor"/>
                    <stop offset="50%" stop-color="rgb(55, 65, 81)" stop-opacity="0.3"/>
                </linearGradient>
            </defs>
            <path fill="url(#half-fill-{{ uniqid() }})" d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
        </svg>
    @endif

    {{-- Empty stars --}}
    @for ($i = 0; $i < $emptyStars; $i++)
        <svg class="{{ $sizeClass }} text-gray-600" viewBox="0 0 20 20">
            <path fill="currentColor" d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
        </svg>
    @endfor

    {{-- Rating number --}}
    @if ($showNumber)
        <span class="text-sm text-muted-300 ml-1">{{ number_format($rating, 1) }}</span>
    @endif
</div>

