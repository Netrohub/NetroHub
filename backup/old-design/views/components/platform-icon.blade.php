@php
use App\Helpers\PlatformIcon;

// Get platform data
if (isset($product)) {
    $data = PlatformIcon::getFromProduct($product);
} elseif (isset($category)) {
    $data = PlatformIcon::getCategoryIcon($category);
} else {
    $data = PlatformIcon::get($platform ?? '', $type ?? 'social');
}

$iconUrl = $data['icon'];
$platformName = $data['name'] ?? ($platform ?? 'Platform');
$colorClass = $data['color'] ?? 'text-gray-400';
$bgClass = $data['bg'] ?? 'bg-gray-400/10';

// Size classes
$sizeClasses = [
    'xs' => 'w-4 h-4',
    'sm' => 'w-5 h-5',
    'md' => 'w-6 h-6',
    'lg' => 'w-8 h-8',
    'xl' => 'w-10 h-10',
    '2xl' => 'w-12 h-12',
];
$sizeClass = $sizeClasses[$size ?? 'md'] ?? $sizeClasses['md'];

// Show name option
$showName = $showName ?? false;
@endphp

@if($showName)
<div class="flex items-center gap-2 {{ $class ?? '' }}">
    <img 
        src="{{ $iconUrl }}" 
        alt="{{ $platformName }}" 
        class="{{ $sizeClass }} object-contain {{ $imgClass ?? '' }}"
        loading="lazy"
    >
    <span class="{{ $nameClass ?? 'text-white font-medium' }}">{{ $platformName }}</span>
</div>
@else
<img 
    src="{{ $iconUrl }}" 
    alt="{{ $platformName }}" 
    class="{{ $sizeClass }} object-contain {{ $class ?? '' }}"
    loading="lazy"
    title="{{ $platformName }}"
>
@endif

