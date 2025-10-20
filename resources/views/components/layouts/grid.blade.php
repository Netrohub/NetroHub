<!-- NXO Grid Layout Template - Missing from Design System -->

<!-- Desktop Grid (12 columns, 24px gutters, 1200px max-width) -->
<div class="grid-desktop">
    {{ $slot }}
</div>

<!-- Tablet Grid (8 columns, 20px gutters, 768px max-width) -->
<div class="grid-tablet">
    {{ $slot }}
</div>

<!-- Mobile Grid (4 columns, 16px gutters, 375px max-width) -->
<div class="grid-mobile">
    {{ $slot }}
</div>

<!-- Responsive Grid (Auto-adjusts based on screen size) -->
<div class="responsive-grid">
    {{ $slot }}
</div>

<!-- Product Grid (Auto-adjusts columns based on screen size) -->
<div class="product-grid">
    {{ $slot }}
</div>
