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

        // Super admin gate
        Gate::before(function ($user, $ability) {
            return $user->hasRole('admin') ? true : null;
        });

        // Rate limiters
        RateLimiter::for('reviews', function (Request $request) {
            return Limit::perMinute(5)->by($request->user()?->id ?: $request->ip());
        });

        RateLimiter::for('delivery', function (Request $request) {
            // Allow 20 requests per minute for credential viewing
            return Limit::perMinute(20)->by($request->user()?->id ?: $request->ip());
        });

        // Register view composers
        \Illuminate\Support\Facades\View::composer('*', \App\View\Composers\AnnouncementComposer::class);
    }
}
