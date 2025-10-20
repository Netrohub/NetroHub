<span {{ $attributes->merge(['class' => $sizeClass() . ' font-black text-gradient']) }} dir="ltr">
    @if($showCurrency)$@endif{{ number_format($amount, 2) }}
</span>

