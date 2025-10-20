<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
            'kyc.verified' => \App\Http\Middleware\KycVerificationMiddleware::class,
            'require.kyc' => \App\Http\Middleware\RequireKycVerification::class,
            'require.phone' => \App\Http\Middleware\RequirePhoneVerification::class,
            'require.seller.verifications' => \App\Http\Middleware\RequireSellerVerifications::class,
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ]);
        
        // Add locale middleware to web group
    $middleware->web(append: [
        \App\Http\Middleware\SetLocale::class,
        \App\Http\Middleware\SanitizeInput::class,
        \App\Http\Middleware\SecurityMonitoring::class,
        \App\Http\Middleware\CspMiddleware::class,
        \App\Http\Middleware\SecurityHeadersMiddleware::class,
    ]);
        
        // Configure rate limiting
        $middleware->throttleApi();
        
        // Add adaptive rate limiting to specific routes
        $middleware->alias([
            'adaptive.rate.limit' => \App\Http\Middleware\AdaptiveRateLimit::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
