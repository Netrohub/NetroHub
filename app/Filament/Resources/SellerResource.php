<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SellerResource\Pages;
use App\Models\AdminAudit;
use App\Models\Seller;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class SellerResource extends Resource
{
    protected static ?string $model = Seller::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';

    protected static ?string $navigationGroup = 'People';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Seller Information')
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->relationship('user', 'email')
                            ->searchable()
                            ->required()
                            ->disabled(fn ($context) => $context === 'edit'),
                        Forms\Components\TextInput::make('display_name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('bio')
                            ->rows(3)
                            ->maxLength(1000),
                        Forms\Components\FileUpload::make('avatar_url')
                            ->image()
                            ->directory('sellers/avatars')
                            ->maxSize(2048),
                        Forms\Components\FileUpload::make('banner_url')
                            ->image()
                            ->directory('sellers/banners')
                            ->maxSize(5120),
                    ])->columns(2),

                Forms\Components\Section::make('KYC Information')
                    ->schema([
                        Forms\Components\Select::make('kyc_status')
                            ->options([
                                'pending' => 'Pending',
                                'approved' => 'Approved',
                                'rejected' => 'Rejected',
                            ])
                            ->required()
                            ->default('pending'),
                        Forms\Components\KeyValue::make('kyc_documents')
                            ->label('KYC Documents')
                            ->keyLabel('Document Type')
                            ->valueLabel('URL/Path')
                            ->reorderable(),
                        Forms\Components\Textarea::make('kyc_notes')
                            ->label('Admin Notes')
                            ->rows(3),
                        Forms\Components\DateTimePicker::make('kyc_submitted_at')
                            ->label('Submitted At')
                            ->disabled(),
                        Forms\Components\DateTimePicker::make('kyc_reviewed_at')
                            ->label('Reviewed At')
                            ->disabled(),
                    ])->columns(2)->visible(fn () => auth()->user()->can('approve_kyc')),

                Forms\Components\Section::make('Status & Stats')
                    ->schema([
                        Forms\Components\Toggle::make('is_active')
                            ->label('Active')
                            ->default(true),
                        Forms\Components\TextInput::make('rating')
                            ->numeric()
                            ->default(0)
                            ->disabled(),
                        Forms\Components\TextInput::make('total_sales')
                            ->numeric()
                            ->default(0)
                            ->disabled(),
                        Forms\Components\TextInput::make('payout_method')
                            ->maxLength(255),
                        Forms\Components\KeyValue::make('payout_details')
                            ->label('Payout Details'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\ImageColumn::make('avatar_url')
                    ->circular()
                    ->defaultImageUrl(url('/img/default-avatar.png')),
                Tables\Columns\TextColumn::make('user.email')
                    ->label('User')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('display_name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('kyc_status')
                    ->badge()
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'approved',
                        'danger' => 'rejected',
                    ])
                    ->sortable(),
                Tables\Columns\TextColumn::make('wallet_balance')
                    ->label('Balance')
                    ->money('USD')
                    ->getStateUsing(fn (Seller $record) => $record->getWalletBalance())
                    ->sortable(query: function (Builder $query, string $direction): Builder {
                        return $query->select('sellers.*')
                            ->selectSub(
                                'SELECT COALESCE(SUM(CASE WHEN type IN ("sale", "adjustment") THEN amount WHEN type IN ("payout", "refund") THEN -amount ELSE 0 END), 0) FROM wallet_transactions WHERE wallet_transactions.seller_id = sellers.id',
                                'wallet_balance'
                            )
                            ->orderBy('wallet_balance', $direction);
                    }),
                Tables\Columns\TextColumn::make('total_sales')
                    ->label('Total Sales')
                    ->sortable(),
                Tables\Columns\TextColumn::make('products_count')
                    ->counts('products')
                    ->label('Products')
                    ->sortable(),
                Tables\Columns\TextColumn::make('rating')
                    ->badge()
                    ->color('success')
                    ->formatStateUsing(fn ($state) => number_format($state, 1).' ⭐')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('kyc_status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ])
                    ->multiple(),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active')
                    ->placeholder('All sellers')
                    ->trueLabel('Active only')
                    ->falseLabel('Inactive only'),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\Action::make('approve_kyc')
                        ->label('Approve KYC')
                        ->icon('heroicon-o-check-badge')
                        ->color('success')
                        ->visible(fn (Seller $record) => $record->kyc_status === 'pending')
                        ->form([
                            Forms\Components\Textarea::make('notes')
                                ->label('Admin Notes')
                                ->rows(3),
                        ])
                        ->action(function (Seller $record, array $data) {
                            $record->update([
                                'kyc_status' => 'approved',
                                'kyc_reviewed_at' => now(),
                                'kyc_notes' => $data['notes'] ?? null,
                            ]);
                            AdminAudit::log(auth()->user(), 'approved_kyc', $record);
                            Notification::make()->success()->title('KYC Approved')->send();
                        })
                        ->visible(fn () => auth()->user()->can('approve_kyc')),
                    Tables\Actions\Action::make('reject_kyc')
                        ->label('Reject KYC')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->visible(fn (Seller $record) => $record->kyc_status === 'pending')
                        ->form([
                            Forms\Components\Textarea::make('notes')
                                ->label('Rejection Reason')
                                ->required()
                                ->rows(3),
                        ])
                        ->action(function (Seller $record, array $data) {
                            $record->update([
                                'kyc_status' => 'rejected',
                                'kyc_reviewed_at' => now(),
                                'kyc_notes' => $data['notes'],
                            ]);
                            AdminAudit::log(auth()->user(), 'rejected_kyc', $record);
                            Notification::make()->danger()->title('KYC Rejected')->send();
                        })
                        ->visible(fn () => auth()->user()->can('reject_kyc')),
                    Tables\Actions\Action::make('suspend')
                        ->label('Suspend')
                        ->icon('heroicon-o-no-symbol')
                        ->color('danger')
                        ->visible(fn (Seller $record) => $record->is_active)
                        ->requiresConfirmation()
                        ->action(function (Seller $record) {
                            $record->update(['is_active' => false]);
                            AdminAudit::log(auth()->user(), 'suspended', $record);
                            Notification::make()->success()->title('Seller Suspended')->send();
                        })
                        ->visible(fn () => auth()->user()->can('suspend_sellers')),
                    Tables\Actions\Action::make('unsuspend')
                        ->label('Unsuspend')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->visible(fn (Seller $record) => ! $record->is_active)
                        ->requiresConfirmation()
                        ->action(function (Seller $record) {
                            $record->update(['is_active' => true]);
                            AdminAudit::log(auth()->user(), 'unsuspended', $record);
                            Notification::make()->success()->title('Seller Unsuspended')->send();
                        })
                        ->visible(fn () => auth()->user()->can('suspend_sellers')),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->visible(fn () => auth()->user()->can('edit_sellers')),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSellers::route('/'),
            'create' => Pages\CreateSeller::route('/create'),
            'edit' => Pages\EditSeller::route('/{record}/edit'),
            'view' => Pages\ViewSeller::route('/{record}'),
        ];
    }

    public static function canViewAny(): bool
    {
        return auth()->user()->can('view_sellers');
    }

    public static function canCreate(): bool
    {
        return false; // Sellers are created through the frontend
    }

    public static function canEdit($record): bool
    {
        return auth()->user()->can('edit_sellers');
    }

    public static function canDelete($record): bool
    {
        return auth()->user()->can('edit_sellers');
    }
}
