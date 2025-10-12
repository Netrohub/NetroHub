<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiteSettingResource\Pages;
use App\Filament\Resources\SiteSettingResource\RelationManagers;
use App\Models\SiteSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SiteSettingResource extends Resource
{
    protected static ?string $model = SiteSetting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    
    protected static ?string $navigationLabel = 'Site Settings';
    
    protected static ?string $navigationGroup = 'CMS';
    
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Setting Information')
                    ->schema([
                        Forms\Components\TextInput::make('key')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->placeholder('e.g., site_name')
                            ->helperText('Unique identifier for this setting (use snake_case)')
                            ->columnSpan(1),
                        
                        Forms\Components\Select::make('group')
                            ->required()
                            ->options([
                                'general' => 'General',
                                'branding' => 'Branding',
                                'seo' => 'SEO',
                                'social' => 'Social Media',
                                'monetization' => 'Monetization',
                                'email' => 'Email',
                                'legal' => 'Legal',
                                'features' => 'Features',
                                'advanced' => 'Advanced',
                            ])
                            ->default('general')
                            ->columnSpan(1),
                    ])->columns(2),
                
                Forms\Components\Section::make('Value Configuration')
                    ->schema([
                        Forms\Components\Select::make('type')
                            ->required()
                            ->options([
                                'text' => 'Text',
                                'textarea' => 'Textarea',
                                'number' => 'Number',
                                'boolean' => 'Boolean',
                                'json' => 'JSON',
                                'image' => 'Image URL',
                                'color' => 'Color Picker',
                                'select' => 'Select Dropdown',
                            ])
                            ->default('text')
                            ->reactive()
                            ->columnSpan(1),
                        
                        Forms\Components\Toggle::make('is_public')
                            ->label('Public (Accessible from frontend)')
                            ->helperText('Enable this if the frontend needs to access this setting')
                            ->default(false)
                            ->columnSpan(1),
                        
                        Forms\Components\Textarea::make('value')
                            ->label('Value')
                            ->placeholder('Enter the setting value')
                            ->rows(3)
                            ->columnSpanFull(),
                        
                        Forms\Components\Textarea::make('description')
                            ->label('Description (Admin Helper Text)')
                            ->placeholder('Describe what this setting controls')
                            ->rows(2)
                            ->columnSpanFull(),
                        
                        Forms\Components\KeyValue::make('options')
                            ->label('Options (for select type)')
                            ->helperText('Add key-value pairs for dropdown options')
                            ->visible(fn ($get) => $get('type') === 'select')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('key')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->label('Setting Key'),
                
                Tables\Columns\BadgeColumn::make('group')
                    ->searchable()
                    ->sortable()
                    ->colors([
                        'primary' => 'general',
                        'success' => 'branding',
                        'warning' => 'seo',
                        'danger' => 'monetization',
                        'info' => 'features',
                    ])
                    ->label('Group'),
                
                Tables\Columns\TextColumn::make('value')
                    ->limit(50)
                    ->searchable()
                    ->label('Current Value'),
                
                Tables\Columns\BadgeColumn::make('type')
                    ->colors([
                        'secondary' => 'text',
                        'success' => 'boolean',
                        'warning' => 'number',
                        'info' => 'json',
                    ])
                    ->label('Type'),
                
                Tables\Columns\IconColumn::make('is_public')
                    ->boolean()
                    ->label('Public')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->since()
                    ->label('Last Updated'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('group')
                    ->options([
                        'general' => 'General',
                        'branding' => 'Branding',
                        'seo' => 'SEO',
                        'social' => 'Social Media',
                        'monetization' => 'Monetization',
                        'email' => 'Email',
                        'legal' => 'Legal',
                        'features' => 'Features',
                        'advanced' => 'Advanced',
                    ]),
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'text' => 'Text',
                        'textarea' => 'Textarea',
                        'number' => 'Number',
                        'boolean' => 'Boolean',
                        'json' => 'JSON',
                        'image' => 'Image',
                        'color' => 'Color',
                    ]),
                Tables\Filters\TernaryFilter::make('is_public')
                    ->label('Public Settings'),
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
            ->defaultSort('group')
            ->poll('30s');
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
            'index' => Pages\ListSiteSettings::route('/'),
            'create' => Pages\CreateSiteSetting::route('/create'),
            'edit' => Pages\EditSiteSetting::route('/{record}/edit'),
        ];
    }
}
