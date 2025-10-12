<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\AdminAudit;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'People';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('User Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        Forms\Components\TextInput::make('password')
                            ->password()
                            ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                            ->dehydrated(fn ($state) => filled($state))
                            ->required(fn (string $context): bool => $context === 'create')
                            ->maxLength(255),
                        Forms\Components\FileUpload::make('avatar_url')
                            ->image()
                            ->directory('avatars')
                            ->maxSize(2048),
                    ])->columns(2),

                Forms\Components\Section::make('Status & Roles')
                    ->schema([
                        Forms\Components\Toggle::make('is_active')
                            ->label('Active')
                            ->default(true),
                        Forms\Components\Toggle::make('privacy_mode')
                            ->label('Privacy Mode')
                            ->default(false),
                        Forms\Components\DateTimePicker::make('email_verified_at')
                            ->label('Email Verified At'),
                        Forms\Components\Select::make('roles')
                            ->relationship('roles', 'name')
                            ->multiple()
                            ->preload()
                            ->searchable()
                            ->visible(fn () => auth()->user()->can('assign_roles')),
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
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable()
                    ->copyable(),
                Tables\Columns\IconColumn::make('email_verified_at')
                    ->label('Verified')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-badge')
                    ->falseIcon('heroicon-o-x-circle'),
                Tables\Columns\TextColumn::make('roles.name')
                    ->badge()
                    ->separator(',')
                    ->colors([
                        'danger' => 'owner',
                        'warning' => 'admin',
                        'success' => 'moderator',
                        'info' => 'seller',
                        'gray' => 'user',
                    ]),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('orders_count')
                    ->counts('orders')
                    ->label('Purchases')
                    ->sortable(),
                Tables\Columns\TextColumn::make('seller.total_sales')
                    ->label('Sales')
                    ->default('—')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active')
                    ->placeholder('All users')
                    ->trueLabel('Active only')
                    ->falseLabel('Inactive only'),
                Tables\Filters\TernaryFilter::make('email_verified_at')
                    ->label('Email Verified')
                    ->placeholder('All users')
                    ->trueLabel('Verified only')
                    ->falseLabel('Unverified only')
                    ->queries(
                        true: fn ($query) => $query->whereNotNull('email_verified_at'),
                        false: fn ($query) => $query->whereNull('email_verified_at'),
                    ),
                Tables\Filters\SelectFilter::make('roles')
                    ->relationship('roles', 'name')
                    ->multiple()
                    ->preload(),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\Action::make('verify_email')
                        ->label('Verify Email')
                        ->icon('heroicon-o-check-badge')
                        ->color('success')
                        ->visible(fn (User $record) => ! $record->email_verified_at)
                        ->requiresConfirmation()
                        ->action(function (User $record) {
                            $record->update(['email_verified_at' => now()]);
                            AdminAudit::log(auth()->user(), 'verified_email', $record);
                            Notification::make()->success()->title('Email verified')->send();
                        })
                        ->visible(fn () => auth()->user()->can('verify_users')),
                    Tables\Actions\Action::make('ban')
                        ->label('Ban User')
                        ->icon('heroicon-o-no-symbol')
                        ->color('danger')
                        ->visible(fn (User $record) => $record->is_active)
                        ->requiresConfirmation()
                        ->action(function (User $record) {
                            $record->update(['is_active' => false]);
                            AdminAudit::log(auth()->user(), 'banned', $record);
                            Notification::make()->success()->title('User banned')->send();
                        })
                        ->visible(fn () => auth()->user()->can('ban_users')),
                    Tables\Actions\Action::make('unban')
                        ->label('Unban User')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->visible(fn (User $record) => ! $record->is_active)
                        ->requiresConfirmation()
                        ->action(function (User $record) {
                            $record->update(['is_active' => true]);
                            AdminAudit::log(auth()->user(), 'unbanned', $record);
                            Notification::make()->success()->title('User unbanned')->send();
                        })
                        ->visible(fn () => auth()->user()->can('ban_users')),
                    Tables\Actions\Action::make('impersonate')
                        ->label('Impersonate')
                        ->icon('heroicon-o-arrow-right-on-rectangle')
                        ->color('warning')
                        ->url(fn (User $record) => route('impersonate', $record->id))
                        ->openUrlInNewTab()
                        ->visible(fn () => auth()->user()->can('impersonate_users')),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->visible(fn () => auth()->user()->can('delete_users')),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        return auth()->user()->can('view_users');
    }

    public static function canCreate(): bool
    {
        return auth()->user()->can('create_users');
    }

    public static function canEdit($record): bool
    {
        return auth()->user()->can('edit_users');
    }

    public static function canDelete($record): bool
    {
        return auth()->user()->can('delete_users');
    }
}
