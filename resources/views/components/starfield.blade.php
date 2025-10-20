<!-- Starfield Background Component -->
<div class="fixed inset-0 -z-10 overflow-hidden pointer-events-none">
    <!-- Animated Background Stars -->
    <div class="absolute inset-0">
        <!-- Large floating orbs -->
        <div class="absolute top-1/4 left-1/4 w-64 h-64 sm:w-96 sm:h-96 bg-primary/10 rounded-full blur-3xl float-animation"></div>
        <div class="absolute bottom-1/4 right-1/4 w-64 h-64 sm:w-96 sm:h-96 bg-accent/10 rounded-full blur-3xl float-animation" style="animation-delay: 2s;"></div>
        <div class="absolute top-3/4 left-1/2 w-48 h-48 sm:w-72 sm:h-72 bg-primary/5 rounded-full blur-3xl float-animation" style="animation-delay: 4s;"></div>
    </div>
    
    <!-- Twinkling Stars -->
    <div class="absolute inset-0">
        @for($i = 0; $i < 50; $i++)
            <div class="absolute w-1 h-1 bg-white rounded-full twinkle-animation" 
                 style="
                     left: {{ rand(0, 100) }}%; 
                     top: {{ rand(0, 100) }}%; 
                     animation-delay: {{ rand(0, 3000) }}ms;
                     animation-duration: {{ rand(2000, 4000) }}ms;
                 "></div>
        @endfor
    </div>
    
    <!-- Drifting Particles -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute -top-10 left-0 w-full h-20 bg-gradient-to-b from-primary/5 to-transparent animate-drift"></div>
        <div class="absolute -top-10 left-0 w-full h-20 bg-gradient-to-b from-accent/5 to-transparent animate-drift" style="animation-delay: 10s;"></div>
    </div>
</div>
