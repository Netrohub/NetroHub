<?php

namespace App\Providers\Filament;

use App\Filament\Pages\HealthCheck;
use App\Filament\Pages\Settings\FeesSettings;
use App\Filament\Pages\Settings\GeneralSettings;
use App\Filament\Pages\Settings\SecuritySettings;
use App\Filament\Widgets\CategoryRevenueWidget;
use App\Filament\Widgets\RevenueChartWidget;
use App\Filament\Widgets\StatsOverviewWidget;
use App\Http\Middleware\EnsureUserIsAdmin;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->brandName('NetroHub Control Center')
            ->favicon(asset('favicon.ico'))
            ->darkMode(true)
            ->colors([
                'primary' => Color::Blue,
                'gray' => Color::Slate,
            ])
            ->authGuard('web')
            ->passwordReset()
            ->emailVerification()
            ->globalSearchKeyBindings(['command+k', 'ctrl+k'])
            ->sidebarCollapsibleOnDesktop()
            ->navigationGroups([
                NavigationGroup::make('People')
                    ->icon('heroicon-o-users')
                    ->collapsed(false),
                NavigationGroup::make('Marketplace')
                    ->icon('heroicon-o-shopping-bag')
                    ->collapsed(false),
                NavigationGroup::make('Content & CMS')
                    ->icon('heroicon-o-document-text')
                    ->collapsed(false),
                NavigationGroup::make('Payments')
                    ->icon('heroicon-o-currency-dollar')
                    ->collapsed(true),
                NavigationGroup::make('Moderation')
                    ->icon('heroicon-o-shield-check')
                    ->collapsed(true),
                NavigationGroup::make('Settings')
                    ->icon('heroicon-o-cog-6-tooth')
                    ->collapsed(true),
                NavigationGroup::make('System')
                    ->icon('heroicon-o-server')
                    ->collapsed(true),
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->pages([
                \App\Filament\Pages\Dashboard::class,
                GeneralSettings::class,
                FeesSettings::class,
                SecuritySettings::class,
                HealthCheck::class,
            ])
            ->widgets([
                Widgets\AccountWidget::class,
                StatsOverviewWidget::class,
                RevenueChartWidget::class,
                CategoryRevenueWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
                EnsureUserIsAdmin::class,
            ])
            ->databaseNotifications()
            ->databaseNotificationsPolling('30s')
            ->breadcrumbs(true)
            ->maxContentWidth('full')
            ->spa();
    }
}
