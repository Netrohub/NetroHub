<?php

namespace App\Filament\Widgets;

use App\Models\ContentBlock;
use App\Models\FeatureFlag;
use App\Models\SiteSetting;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CMSStatsWidget extends BaseWidget
{
    protected static ?int $sort = 0;

    protected function getStats(): array
    {
        $activeBlocks = ContentBlock::where('is_active', true)->count();
        $totalBlocks = ContentBlock::count();
        $activeFlags = FeatureFlag::where('is_enabled', true)->count();
        $totalFlags = FeatureFlag::count();
        $totalSettings = SiteSetting::count();
        $publicSettings = SiteSetting::where('is_public', true)->count();

        return [
            Stat::make('Site Settings', $totalSettings)
                ->description($publicSettings . ' public settings')
                ->descriptionIcon('heroicon-o-cog-6-tooth')
                ->color('success')
                ->chart([7, 12, 18, 25, 30, 40, $totalSettings]),
            
            Stat::make('Content Blocks', $totalBlocks)
                ->description($activeBlocks . ' active blocks')
                ->descriptionIcon('heroicon-o-squares-2x2')
                ->color('primary')
                ->chart([2, 5, 10, 15, 20, 25, $totalBlocks]),
            
            Stat::make('Feature Flags', $totalFlags)
                ->description($activeFlags . ' enabled features')
                ->descriptionIcon('heroicon-o-flag')
                ->color('warning')
                ->chart([1, 3, 5, 8, 10, 12, $totalFlags]),
        ];
    }
}

