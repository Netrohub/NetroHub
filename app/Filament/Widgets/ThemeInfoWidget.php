<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ThemeInfoWidget extends BaseWidget
{
    protected static ?string $pollingInterval = null;
    
    protected static ?int $sort = 1;
    
    protected function getStats(): array
    {
        $currentTheme = \App\Models\SiteSetting::get('admin_theme', 'system');
        $darkModeEnabled = \App\Models\SiteSetting::get('enable_dark_mode', true);
        
        return [
            Stat::make('Current Theme', ucfirst($currentTheme))
                ->description('Admin panel theme setting')
                ->descriptionIcon('heroicon-m-paint-brush')
                ->color($currentTheme === 'dark' ? 'gray' : 'primary'),
                
            Stat::make('Dark Mode', $darkModeEnabled ? 'Enabled' : 'Disabled')
                ->description('Dark mode toggle availability')
                ->descriptionIcon('heroicon-m-moon')
                ->color($darkModeEnabled ? 'success' : 'warning'),
                
            Stat::make('Theme Support', 'Full Support')
                ->description('Light & Dark mode compatibility')
                ->descriptionIcon('heroicon-m-eye')
                ->color('success'),
        ];
    }
}
