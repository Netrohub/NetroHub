<?php

return [
    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'paddle' => [
        'vendor_id' => env('PADDLE_VENDOR_ID'),
        'api_key' => env('PADDLE_API_KEY'),
        'product_id' => env('PADDLE_PRODUCT_ID'),
        'webhook_secret' => env('PADDLE_WEBHOOK_SECRET'),
        'environment' => env('PADDLE_ENVIRONMENT', 'sandbox'), // 'sandbox' or 'production'
    ],

    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => env('APP_URL').'/login/google/callback',
    ],

    'discord' => [
        'client_id' => env('DISCORD_CLIENT_ID'),
        'client_secret' => env('DISCORD_CLIENT_SECRET'),
        'redirect' => env('APP_URL').'/login/discord/callback',
    ],

    'apple' => [
        'client_id' => env('APPLE_CLIENT_ID'),
        'client_secret' => env('APPLE_CLIENT_SECRET'),
        'redirect' => env('APP_URL').'/login/apple/callback',
    ],

    'google_analytics' => [
        'measurement_id' => env('GOOGLE_ANALYTICS_MEASUREMENT_ID'),
        'api_secret' => env('GOOGLE_ANALYTICS_API_SECRET'),
        'enabled' => env('GOOGLE_ANALYTICS_ENABLED', true),
    ],

    'posthog' => [
        'api_key' => env('POSTHOG_API_KEY'),
        'host' => env('POSTHOG_HOST', 'https://app.posthog.com'),
    ],

    'brevo' => [
        'key' => env('BREVO_API_KEY'),
        'verify_template_id' => env('BREVO_TEMPLATE_VERIFY_ID'),
        'welcome_template_id' => env('BREVO_TEMPLATE_WELCOME_ID'),
    ],

    'tap' => [
        'secret_key' => env('TAP_SECRET_KEY'),
        'public_key' => env('TAP_PUBLIC_KEY'),
        'webhook_secret' => env('TAP_WEBHOOK_SECRET'),
        'sandbox' => env('TAP_SANDBOX', true),
        'api_url' => env('TAP_SANDBOX', true) 
            ? 'https://api.tap.company/v2' 
            : 'https://api.tap.company/v2',
    ],
];
