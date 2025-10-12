<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserSubscriptionResource\Pages;
use App\Models\UserSubscription;
use App\Services\EntitlementsService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class UserSubscriptionResource extends Resource
{
    protected static ?string $model = UserSubscription::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Subscriptions';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = 'User Subscriptions';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Subscription Details')->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'email')
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('plan_id')
                    ->relationship('plan', 'name')
                    ->required(),
                Forms\Components\Select::make('status')
                    ->options([
                        'active' => 'Active',
                        'past_due' => 'Past Due',
                        'cancelled' => 'Cancelled',
                        'expired' => 'Expired',
                        'paused' => 'Paused',
                    ])
                    ->required(),
                Forms\Components\Select::make('interval')
                    ->options([
                        'monthly' => 'Monthly',
                        'yearly' => 'Yearly',
                    ])
                    ->required(),
            ])->columns(2),

            Forms\Components\Section::make('Dates')->schema([
                Forms\Components\DateTimePicker::make('period_start'),
                Forms\Components\DateTimePicker::make('period_end'),
                Forms\Components\DateTimePicker::make('renews_at'),
                Forms\Components\DateTimePicker::make('cancel_at'),
            ])->columns(2),

            Forms\Components\Section::make('Paddle')->schema([
                Forms\Components\TextInput::make('paddle_subscription_id')
                    ->maxLength(255),
                Forms\Components\Toggle::make('is_gifted')
                    ->default(false),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('id')
                ->sortable(),
            Tables\Columns\TextColumn::make('user.email')
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('plan.name')
                ->badge()
                ->colors([
                    'secondary' => 'Free',
                    'info' => 'Plus',
                    'success' => 'Pro',
                ]),
            Tables\Columns\TextColumn::make('status')
                ->badge()
                ->colors([
                    'success' => 'active',
                    'warning' => 'past_due',
                    'danger' => 'cancelled',
                    'secondary' => 'expired',
                    'info' => 'paused',
                ]),
            Tables\Columns\TextColumn::make('interval')
                ->badge(),
            Tables\Columns\IconColumn::make('is_gifted')
                ->boolean(),
            Tables\Columns\TextColumn::make('renews_at')
                ->dateTime()
                ->sortable(),
            Tables\Columns\TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ])->filters([
            Tables\Filters\SelectFilter::make('plan_id')
                ->relationship('plan', 'name'),
            Tables\Filters\SelectFilter::make('status')
                ->options([
                    'active' => 'Active',
                    'past_due' => 'Past Due',
                    'cancelled' => 'Cancelled',
                    'expired' => 'Expired',
                    'paused' => 'Paused',
                ]),
            Tables\Filters\TernaryFilter::make('is_gifted'),
        ])->actions([
            Tables\Actions\ViewAction::make(),
            Tables\Actions\EditAction::make(),
            Tables\Actions\ActionGroup::make([
                Tables\Actions\Action::make('regenerate_entitlements')
                    ->icon('heroicon-o-arrow-path')
                    ->color('warning')
                    ->action(function (UserSubscription $record) {
                        $entitlementsService = app(EntitlementsService::class);
                        $entitlementsService->regenerateEntitlements($record->user);

                        Notification::make()
                            ->success()
                            ->title('Entitlements Regenerated')
                            ->body('User entitlements have been regenerated from their plan.')
                            ->send();
                    })
                    ->requiresConfirmation(),

                Tables\Actions\Action::make('cancel_subscription')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->action(function (UserSubscription $record) {
                        $record->cancel();

                        Notification::make()
                            ->success()
                            ->title('Subscription Cancelled')
                            ->send();
                    })
                    ->requiresConfirmation()
                    ->visible(fn (UserSubscription $record) => $record->isActive()),

                Tables\Actions\Action::make('resume_subscription')
                    ->icon('heroicon-o-play')
                    ->color('success')
                    ->action(function (UserSubscription $record) {
                        $record->resume();

                        Notification::make()
                            ->success()
                            ->title('Subscription Resumed')
                            ->send();
                    })
                    ->requiresConfirmation()
                    ->visible(fn (UserSubscription $record) => $record->isCancelled()),
            ]),
        ])->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ]),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUserSubscriptions::route('/'),
            'create' => Pages\CreateUserSubscription::route('/create'),
            'view' => Pages\ViewUserSubscription::route('/{record}'),
            'edit' => Pages\EditUserSubscription::route('/{record}/edit'),
        ];
    }
}
