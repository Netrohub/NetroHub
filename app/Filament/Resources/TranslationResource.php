<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TranslationResource\Pages;
use App\Models\Translation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;

class TranslationResource extends Resource
{
    protected static ?string $model = Translation::class;

    protected static ?string $navigationIcon = 'heroicon-o-language';

    protected static ?string $navigationGroup = 'Content Management';

    protected static ?int $navigationSort = 10;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Translation Details')
                    ->schema([
                        Forms\Components\TextInput::make('key')
                            ->label('Translation Key')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->helperText('Unique identifier for this translation (e.g., "Home", "Login")'),
                        
                        Forms\Components\Select::make('group')
                            ->label('Group')
                            ->options([
                                'common' => 'Common',
                                'auth' => 'Authentication',
                                'nav' => 'Navigation',
                                'legal' => 'Legal',
                                'product' => 'Products',
                                'account' => 'Account',
                                'payment' => 'Payments',
                                'other' => 'Other',
                            ])
                            ->searchable()
                            ->helperText('Group translations by category for better organization'),
                        
                        Forms\Components\Textarea::make('description')
                            ->label('Description')
                            ->rows(2)
                            ->helperText('Optional description or context for this translation'),
                    ]),
                
                Forms\Components\Section::make('Translations')
                    ->schema([
                        Forms\Components\Textarea::make('en')
                            ->label('English')
                            ->required()
                            ->rows(3)
                            ->helperText('English translation'),
                        
                        Forms\Components\Textarea::make('ar')
                            ->label('Arabic / العربية')
                            ->required()
                            ->rows(3)
                            ->helperText('Arabic translation / الترجمة العربية'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('key')
                    ->label('Key')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->weight('bold'),
                
                Tables\Columns\TextColumn::make('en')
                    ->label('English')
                    ->searchable()
                    ->limit(50)
                    ->wrap(),
                
                Tables\Columns\TextColumn::make('ar')
                    ->label('العربية')
                    ->searchable()
                    ->limit(50)
                    ->wrap(),
                
                Tables\Columns\BadgeColumn::make('group')
                    ->label('Group')
                    ->colors([
                        'primary' => 'common',
                        'success' => 'auth',
                        'warning' => 'nav',
                        'danger' => 'legal',
                        'info' => 'product',
                    ])
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Last Updated')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('group')
                    ->options([
                        'common' => 'Common',
                        'auth' => 'Authentication',
                        'nav' => 'Navigation',
                        'legal' => 'Legal',
                        'product' => 'Products',
                        'account' => 'Account',
                        'payment' => 'Payments',
                        'other' => 'Other',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('key', 'asc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTranslations::route('/'),
            'create' => Pages\CreateTranslation::route('/create'),
            'edit' => Pages\EditTranslation::route('/{record}/edit'),
        ];
    }
}

