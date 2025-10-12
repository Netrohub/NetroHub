<?php

namespace App\Filament\Resources\UserSubscriptionResource\Pages;

use App\Filament\Resources\UserSubscriptionResource;
use Filament\Actions;
use Filament\Infolists\Components;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;

class ViewUserSubscription extends ViewRecord
{
    protected static string $resource = UserSubscriptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Components\Section::make('Subscription Details')
                    ->schema([
                        Components\TextEntry::make('user.email')->label('User'),
                        Components\TextEntry::make('plan.name')->badge(),
                        Components\TextEntry::make('status')->badge(),
                        Components\TextEntry::make('interval')->badge(),
                        Components\TextEntry::make('paddle_subscription_id'),
                        Components\IconEntry::make('is_gifted')->boolean(),
                    ])->columns(2),

                Components\Section::make('Dates')
                    ->schema([
                        Components\TextEntry::make('period_start')->dateTime(),
                        Components\TextEntry::make('period_end')->dateTime(),
                        Components\TextEntry::make('renews_at')->dateTime(),
                        Components\TextEntry::make('cancel_at')->dateTime(),
                    ])->columns(2),

                Components\Section::make('User Entitlements')
                    ->schema([
                        Components\ViewEntry::make('entitlements')
                            ->label('')
                            ->view('filament.infolists.entitlements-list'),
                    ]),
            ]);
    }
}
