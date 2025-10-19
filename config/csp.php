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
            "'unsafe-inline'", // Required for Alpine.js and inline scripts
            "'unsafe-eval'",   // Required for some JavaScript frameworks
            'https://fonts.bunny.net',
            'https://www.googletagmanager.com',
            'https://www.google-analytics.com',
            'https://challenges.cloudflare.com',
            'https://*.cloudflare.com',
        ],

        // Style sources
        'style-src' => [
            "'self'",
            "'unsafe-inline'", // Required for Tailwind CSS and inline styles
            'https://fonts.bunny.net',
            'https://*.cloudflare.com',
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
            'https://fonts.bunny.net',
        ],

        // Connect sources for AJAX/fetch requests
        'connect-src' => [
            "'self'",
            'https://www.google-analytics.com',
            'https://challenges.cloudflare.com',
            'https://*.cloudflare.com',
        ],

        // Frame sources for iframes
        'frame-src' => [
            "'self'",
            'https://challenges.cloudflare.com',
            'https://*.cloudflare.com',
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
