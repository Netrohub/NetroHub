<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register policies
        Gate::policy(\App\Models\Product::class, \App\Policies\ProductPolicy::class);
        Gate::policy(\App\Models\Review::class, \App\Policies\ReviewPolicy::class);
        Gate::policy(\App\Models\Order::class, \App\Policies\OrderPolicy::class);

        // Super admin gate - Owner and SuperAdmin bypass all gate checks
        Gate::before(function ($user, $ability) {
            if ($user->hasRole(['owner', 'SuperAdmin'])) {
                return true;
            }
            return null;
        });

        // Rate limiters
        RateLimiter::for('reviews', function (Request $request) {
            return Limit::perMinute(5)->by($request->user()?->id ?: $request->ip());
        });

        RateLimiter::for('delivery', function (Request $request) {
            // Allow 20 requests per minute for credential viewing
            return Limit::perMinute(20)->by($request->user()?->id ?: $request->ip());
        });

        // Register event listeners
        \Illuminate\Support\Facades\Event::listen(
            \Illuminate\Auth\Events\Registered::class,
            \App\Listeners\SendBrevoEmailVerification::class,
        );

        \Illuminate\Support\Facades\Event::listen(
            \Illuminate\Auth\Events\Verified::class,
            function ($event) {
                \Log::info('User email verified', ['user_id' => $event->user->id]);
                
                // Send welcome email
                try {
                    if (config('services.brevo.welcome_template_id')) {
                        app(\App\Services\BrevoMailer::class)->sendWelcomeEmail(
                            $event->user->email,
                            $event->user->name
                        );
                    }
                } catch (\Exception $e) {
                    \Log::warning('Failed to send welcome email', ['error' => $e->getMessage()]);
                }
            }
        );

        // Register view composers
        \Illuminate\Support\Facades\View::composer('*', \App\View\Composers\AnnouncementComposer::class);
    }
}
