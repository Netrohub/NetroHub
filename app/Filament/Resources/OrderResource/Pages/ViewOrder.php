<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Infolists\Components;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Enums\FontWeight;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Components\Section::make('Order Details')
                    ->schema([
                        Components\TextEntry::make('order_number')->weight(FontWeight::Bold),
                        Components\TextEntry::make('user.email')->label('Buyer'),
                        Components\TextEntry::make('total')->money('USD'),
                        Components\TextEntry::make('payment_status')->badge(),
                        Components\TextEntry::make('status')->badge(),
                        Components\TextEntry::make('paid_at')->dateTime(),
                        Components\TextEntry::make('created_at')->dateTime(),
                    ])->columns(2),

                Components\Section::make('Order Items')
                    ->schema([
                        Components\RepeatableEntry::make('items')
                            ->label('')
                            ->schema([
                                Components\TextEntry::make('product_title')->label('Product'),
                                Components\TextEntry::make('price')->money('USD'),
                                Components\TextEntry::make('quantity'),
                                Components\TextEntry::make('delivery_type')->badge(),

                                // Credential information
                                Components\Group::make([
                                    Components\TextEntry::make('credential_status')
                                        ->label('Credential Status')
                                        ->getStateUsing(function ($record) {
                                            if (! $record->hasCredentials()) {
                                                return 'N/A';
                                            }

                                            return $record->credential_claimed_at
                                                ? '✅ Claimed: '.$record->credential_claimed_at->format('M d, Y g:i A')
                                                : '🔒 Unclaimed';
                                        })
                                        ->visible(fn ($record) => $record->hasCredentials()),

                                    Components\TextEntry::make('credential_views')
                                        ->label('Views')
                                        ->getStateUsing(fn ($record) => "{$record->credential_view_count} / {$record->credential_view_limit}"
                                        )
                                        ->visible(fn ($record) => $record->hasCredentials()),

                                    Components\Placeholder::make('credential_warning')
                                        ->label('')
                                        ->content('⚠️ Credentials are masked. Admin access is logged.')
                                        ->visible(fn ($record) => $record->hasCredentials()),
                                ])->visible(fn ($record) => $record->hasCredentials()),
                            ])
                            ->columns(2),
                    ]),

                Components\Section::make('View History')
                    ->schema([
                        Components\RepeatableEntry::make('items.credentialViews')
                            ->label('Recent Credential Views')
                            ->schema([
                                Components\TextEntry::make('viewed_at')->dateTime(),
                                Components\TextEntry::make('user.email'),
                                Components\TextEntry::make('ip_address'),
                                Components\TextEntry::make('user_agent')->limit(50),
                            ])
                            ->columns(4)
                            ->visible(function ($record) {
                                return $record->items->some(fn ($item) => $item->credentialViews->isNotEmpty());
                            }),
                    ])
                    ->collapsible()
                    ->collapsed(),
            ]);
    }
}
