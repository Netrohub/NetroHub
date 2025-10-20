<!-- NXO Section Layout Template - Missing from Design System -->

<section class="section-padding {{ $class ?? '' }}">
    <div class="responsive-container">
        @if(isset($title))
            <div class="text-center mb-8">
                <h2 class="text-3xl md:text-4xl font-bold text-foreground mb-4">{{ $title }}</h2>
                @if(isset($subtitle))
                    <p class="text-body-large text-muted-foreground max-w-2xl mx-auto">{{ $subtitle }}</p>
                @endif
            </div>
        @endif
        
        {{ $slot }}
    </div>
</section>
