@props([
    'vertical' => false,
    'text' => null
])

@if($vertical)
    <div class="divider-vertical"></div>
@elseif($text)
    <div class="relative my-6">
        <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t border-gaming"></div>
        </div>
        <div class="relative flex justify-center text-sm">
            <span class="px-4 bg-dark-900 text-muted-400">{{ $text }}</span>
        </div>
    </div>
@else
    <div class="divider"></div>
@endif

