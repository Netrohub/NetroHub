<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'stripe' => [
        'model' => env('STRIPE_MODEL'),
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
        'webhook' => [
            'secret' => env('STRIPE_WEBHOOK_SECRET'),
            'tolerance' => env('STRIPE_WEBHOOK_TOLERANCE', 300),
        ],
    ],

    'tap' => [
        'key' => env('TAP_KEY'),
        'secret' => env('TAP_SECRET'),
        'webhook_secret' => env('TAP_WEBHOOK_SECRET'),
        'base_url' => env('TAP_BASE_URL', 'https://api.tap.company'),
    ],

    'persona' => [
        'api_key' => env('PERSONA_API_KEY'),
        'webhook_secret' => env('PERSONA_WEBHOOK_SECRET'),
        'base_url' => env('PERSONA_BASE_URL', 'https://withpersona.com/api/v1'),
        'template_id' => env('PERSONA_TEMPLATE_ID'),
    ],

    'mada' => [
        'merchant_id' => env('MADA_MERCHANT_ID'),
        'api_key' => env('MADA_API_KEY'),
        'base_url' => env('MADA_BASE_URL', 'https://api.mada.com.sa'),
    ],

    'stc_pay' => [
        'merchant_id' => env('STC_PAY_MERCHANT_ID'),
        'api_key' => env('STC_PAY_API_KEY'),
        'base_url' => env('STC_PAY_BASE_URL', 'https://api.stcpay.com.sa'),
    ],

    'sentry' => [
        'dsn' => env('SENTRY_LARAVEL_DSN', env('SENTRY_DSN')),
        'environment' => env('SENTRY_ENVIRONMENT', env('APP_ENV', 'production')),
        'release' => env('SENTRY_RELEASE'),
        'sample_rate' => env('SENTRY_SAMPLE_RATE', 1.0),
        'traces_sample_rate' => env('SENTRY_TRACES_SAMPLE_RATE', 0.0),
        'profiles_sample_rate' => env('SENTRY_PROFILES_SAMPLE_RATE', 0.0),
    ],

    'turnstile' => [
        'site_key' => env('TURNSTILE_SITE_KEY'),
        'secret_key' => env('TURNSTILE_SECRET_KEY'),
        'enabled' => env('TURNSTILE_ENABLED', true),
        'theme' => env('TURNSTILE_THEME', 'auto'),
    ],

];