<!-- NXO Brand Illustrations - Missing from Design System -->

<!-- Hero Illustration -->
<div class="hero-illustration">
    <svg class="w-full h-auto max-w-md mx-auto" viewBox="0 0 400 300" fill="none" xmlns="http://www.w3.org/2000/svg">
        <!-- Background gradient -->
        <defs>
            <linearGradient id="heroGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                <stop offset="0%" style="stop-color:#8B5CF6;stop-opacity:0.1" />
                <stop offset="50%" style="stop-color:#3B82F6;stop-opacity:0.05" />
                <stop offset="100%" style="stop-color:#06B6D4;stop-opacity:0.1" />
            </linearGradient>
        </defs>
        
        <!-- Floating elements -->
        <circle cx="80" cy="60" r="4" fill="#8B5CF6" opacity="0.6" class="twinkle-animation">
            <animate attributeName="opacity" values="0.6;1;0.6" dur="3s" repeatCount="indefinite"/>
        </circle>
        <circle cx="320" cy="40" r="3" fill="#3B82F6" opacity="0.8" class="twinkle-animation">
            <animate attributeName="opacity" values="0.8;0.4;0.8" dur="2.5s" repeatCount="indefinite"/>
        </circle>
        <circle cx="350" cy="120" r="2" fill="#06B6D4" opacity="0.7" class="twinkle-animation">
            <animate attributeName="opacity" values="0.7;1;0.7" dur="4s" repeatCount="indefinite"/>
        </circle>
        
        <!-- Main illustration elements -->
        <rect x="50" y="100" width="300" height="150" rx="20" fill="url(#heroGradient)" stroke="#8B5CF6" stroke-width="2" opacity="0.3"/>
        <rect x="80" y="130" width="240" height="90" rx="15" fill="#1E293B" stroke="#475569" stroke-width="1"/>
        
        <!-- Digital marketplace elements -->
        <rect x="100" y="150" width="40" height="30" rx="5" fill="#8B5CF6" opacity="0.8"/>
        <rect x="160" y="150" width="40" height="30" rx="5" fill="#3B82F6" opacity="0.8"/>
        <rect x="220" y="150" width="40" height="30" rx="5" fill="#06B6D4" opacity="0.8"/>
        
        <!-- Connection lines -->
        <path d="M140 165 L160 165" stroke="#8B5CF6" stroke-width="2" opacity="0.6"/>
        <path d="M200 165 L220 165" stroke="#3B82F6" stroke-width="2" opacity="0.6"/>
    </svg>
</div>

<!-- Empty State Illustration -->
<div class="empty-state-illustration">
    <svg class="w-full h-auto max-w-xs mx-auto" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
        <!-- Background circle -->
        <circle cx="100" cy="100" r="80" fill="#1E293B" stroke="#475569" stroke-width="2" opacity="0.5"/>
        
        <!-- Empty state icon -->
        <rect x="70" y="70" width="60" height="60" rx="10" fill="#334155" stroke="#475569" stroke-width="1"/>
        <path d="M85 95 L115 95 M100 80 L100 110" stroke="#94A3B8" stroke-width="2" stroke-linecap="round"/>
    </svg>
</div>

<!-- Success State Illustration -->
<div class="success-illustration">
    <svg class="w-full h-auto max-w-xs mx-auto" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
        <!-- Background circle -->
        <circle cx="100" cy="100" r="80" fill="#1E293B" stroke="#10B981" stroke-width="2" opacity="0.5"/>
        
        <!-- Success checkmark -->
        <circle cx="100" cy="100" r="40" fill="#10B981" opacity="0.2"/>
        <path d="M85 100 L95 110 L115 85" stroke="#10B981" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
</div>

<!-- Error State Illustration -->
<div class="error-illustration">
    <svg class="w-full h-auto max-w-xs mx-auto" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
        <!-- Background circle -->
        <circle cx="100" cy="100" r="80" fill="#1E293B" stroke="#EF4444" stroke-width="2" opacity="0.5"/>
        
        <!-- Error X -->
        <circle cx="100" cy="100" r="40" fill="#EF4444" opacity="0.2"/>
        <path d="M85 85 L115 115 M115 85 L85 115" stroke="#EF4444" stroke-width="3" stroke-linecap="round"/>
    </svg>
</div>

<!-- Loading State Illustration -->
<div class="loading-illustration">
    <svg class="w-full h-auto max-w-xs mx-auto" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
        <!-- Spinning circle -->
        <circle cx="100" cy="100" r="40" fill="none" stroke="#8B5CF6" stroke-width="4" stroke-linecap="round" stroke-dasharray="251.2" stroke-dashoffset="251.2">
            <animate attributeName="stroke-dashoffset" values="251.2;0;251.2" dur="2s" repeatCount="indefinite"/>
            <animateTransform attributeName="transform" type="rotate" values="0 100 100;360 100 100" dur="2s" repeatCount="indefinite"/>
        </circle>
    </svg>
</div>
