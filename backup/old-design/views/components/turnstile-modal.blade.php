{{-- 
    Programmatic Turnstile Widget for Modals
    Usage: <x-turnstile-modal container-id="ts-container" />
--}}

@props([
    'containerId' => 'ts-container',
    'siteKey' => config('services.turnstile.site_key'),
    'theme' => 'auto'
])

@if($siteKey)
<div id="{{ $containerId }}" class="turnstile-container"></div>

<script>
    // Safe (re)render function for modals
    function initTurnstile{{ Str::studly($containerId) }}() {
        if (!window.turnstile) {
            console.warn('Turnstile not loaded yet');
            return;
        }
        
        const el = document.getElementById('{{ $containerId }}');
        if (!el) {
            console.error('Turnstile container not found: {{ $containerId }}');
            return;
        }
        
        // Clear old instance if any
        el.innerHTML = '';
        
        try {
            window.turnstile.render('#{{ $containerId }}', {
                sitekey: '{{ $siteKey }}',
                theme: '{{ $theme }}',
                callback: (token) => { 
                    console.log('TS token for {{ $containerId }}:', token); 
                },
                'error-callback': (code) => {
                    console.warn('TS error for {{ $containerId }}:', code);
                    // Retry if hung (error 300030)
                    if (code === '300030') {
                        setTimeout(() => initTurnstile{{ Str::studly($containerId) }}(), 1200);
                    }
                },
                'expired-callback': () => {
                    console.log('TS expired for {{ $containerId }}');
                    initTurnstile{{ Str::studly($containerId) }}();
                }
            });
        } catch (error) {
            console.error('Failed to render Turnstile for {{ $containerId }}:', error);
        }
    }
    
    // Global function for manual initialization
    window.initTurnstile{{ Str::studly($containerId) }} = initTurnstile{{ Str::studly($containerId) }};
</script>
@else
<div class="text-center text-yellow-400 text-sm p-4">
    Turnstile not configured (TURNSTILE_SITE_KEY missing)
</div>
@endif
