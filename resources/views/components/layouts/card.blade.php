<!-- NXO Card Layout Template - Missing from Design System -->

<div class="glass-card {{ $class ?? '' }}">
    @if(isset($header))
        <div class="px-6 py-4 border-b border-border/50">
            {{ $header }}
        </div>
    @endif
    
    <div class="p-6">
        {{ $slot }}
    </div>
    
    @if(isset($footer))
        <div class="px-6 py-4 border-t border-border/50">
            {{ $footer }}
        </div>
    @endif
</div>
