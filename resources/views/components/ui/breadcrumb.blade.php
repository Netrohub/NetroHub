@props([
    'items' => []
])

<nav class="breadcrumb" aria-label="Breadcrumb">
    @foreach($items as $index => $item)
        <div class="breadcrumb-item">
            @if($loop->last)
                <span class="text-white">{{ $item['label'] }}</span>
            @else
                <a href="{{ $item['url'] }}" class="hover:text-white transition-colors">
                    {{ $item['label'] }}
                </a>
                <span class="breadcrumb-separator mx-2">/</span>
            @endif
        </div>
    @endforeach
</nav>

