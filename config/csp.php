<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Content Security Policy Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains the CSP directives for the NXO application.
    | These directives help prevent XSS attacks and ensure secure resource loading.
    |
    */

    'enabled' => env('CSP_ENABLED', true),

    'directives' => [
        // Default source for all resource types
        'default-src' => ["'self'"],

        // Script sources - allows inline scripts and specific external domains
        'script-src' => [
            "'self'",
            // No 'unsafe-eval' required when using @alpinejs/csp
            'https://challenges.cloudflare.com',
            // Optional analytics (uncomment as needed)
            // 'https://static.cloudflareinsights.com',
            // 'https://www.googletagmanager.com',
            // 'https://www.google-analytics.com',
        ],

        // Script sources for script elements (more specific than script-src)
        'script-src-elem' => [
            "'self'",
            'https://challenges.cloudflare.com',
            // Optional analytics (uncomment as needed)
            // 'https://static.cloudflareinsights.com',
            // 'https://www.googletagmanager.com',
            // 'https://www.google-analytics.com',
        ],

        // Style sources
        'style-src' => [
            "'self'",
            "'unsafe-inline'",
            // If using Bunny fallback for fonts, uncomment:
            // 'https://fonts.bunny.net',
        ],

        // Image sources
        'img-src' => [
            "'self'",
            'data:',
            'https:',
            'https://*.cloudflare.com',
        ],

        // Font sources
        'font-src' => [
            "'self'",
            'data:',
            // If using Bunny fallback, uncomment:
            // 'https://fonts.bunny.net',
        ],

        // Connect sources for AJAX/fetch requests
        'connect-src' => [
            "'self'",
            'https://challenges.cloudflare.com',
            // Optional analytics (uncomment as needed)
            // 'https://www.google-analytics.com',
            // 'https://cloudflareinsights.com',
        ],

        // Frame sources for iframes
        'frame-src' => [
            'https://challenges.cloudflare.com',
        ],

        // Frame ancestors (who can embed this page)
        'frame-ancestors' => ["'self'"],

        // Object sources (blocked for security)
        'object-src' => ["'none'"],

        // Base URI (prevent base tag injection)
        'base-uri' => ["'self'"],

        // Form action (where forms can submit)
        'form-action' => ["'self'"],
    ],

    /*
    |--------------------------------------------------------------------------
    | Report-Only Mode
    |--------------------------------------------------------------------------
    |
    | When enabled, CSP violations will be reported but not blocked.
    | Useful for testing CSP policies.
    |
    */
    'report-only' => env('CSP_REPORT_ONLY', false),

    /*
    |--------------------------------------------------------------------------
    | Report URI
    |--------------------------------------------------------------------------
    |
    | Where to send CSP violation reports.
    | Leave null to disable reporting.
    |
    */
    'report-uri' => env('CSP_REPORT_URI', null),
];
