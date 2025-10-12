<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FeatureFlagResource\Pages;
use App\Filament\Resources\FeatureFlagResource\RelationManagers;
use App\Models\FeatureFlag;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FeatureFlagResource extends Resource
{
    protected static ?string $model = FeatureFlag::class;

    protected static ?string $navigationIcon = 'heroicon-o-flag';
    
    protected static ?string $navigationLabel = 'Feature Flags';
    
    protected static ?string $navigationGroup = 'CMS';
    
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Feature Information')
                    ->schema([
                        Forms\Components\TextInput::make('key')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->placeholder('e.g., premium_search')
                            ->helperText('Unique key for checking this feature (use snake_case)')
                            ->columnSpan(1),
                        
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g., Premium Search Features')
                            ->helperText('Display name for admins')
                            ->columnSpan(1),
                        
                        Forms\Components\Textarea::make('description')
                            ->placeholder('Describe what this feature does...')
                            ->rows(2)
                            ->columnSpanFull(),
                    ])->columns(2),
                
                Forms\Components\Section::make('Rollout Configuration')
                    ->schema([
                        Forms\Components\Toggle::make('is_enabled')
                            ->label('Feature Enabled')
                            ->helperText('Master switch for this feature')
                            ->default(false)
                            ->reactive()
                            ->columnSpan(1),
                        
                        Forms\Components\Select::make('environment')
                            ->required()
                            ->options([
                                'all' => 'All Environments',
                                'production' => 'Production Only',
                                'staging' => 'Staging Only',
                                'development' => 'Development Only',
                            ])
                            ->default('all')
                            ->helperText('Control which environment this flag applies to')
                            ->columnSpan(1),
                        
                        Forms\Components\TextInput::make('rollout_percentage')
                            ->label('Rollout Percentage')
                            ->required()
                            ->numeric()
                            ->default(100)
                            ->minValue(0)
                            ->maxValue(100)
                            ->suffix('%')
                            ->helperText('Gradual rollout: 0% = nobody, 100% = everyone')
                            ->columnSpanFull(),
                    ])->columns(2),
                
                Forms\Components\Section::make('Advanced Targeting')
                    ->description('Target specific users or roles for beta testing')
                    ->schema([
                        Forms\Components\TagsInput::make('allowed_users')
                            ->label('Allowed User IDs')
                            ->placeholder('Enter user IDs (one per line)')
                            ->helperText('Only these users will see the feature (leave empty for all)')
                            ->columnSpanFull(),
                        
                        Forms\Components\CheckboxList::make('allowed_roles')
                            ->label('Allowed Roles')
                            ->options([
                                'admin' => 'Admins',
                                'seller' => 'Sellers',
                                'buyer' => 'Buyers',
                            ])
                            ->helperText('Only these roles will see the feature (leave empty for all)')
                            ->columns(3)
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
                    ->weight('bold')
                    ->label('Feature Key'),
                
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->limit(30)
                    ->label('Feature Name'),
                
                Tables\Columns\ToggleColumn::make('is_enabled')
                    ->label('Enabled')
                    ->sortable()
                    ->afterStateUpdated(function ($record, $state) {
                        $state ? $record->enable() : $record->disable();
                    }),
                
                Tables\Columns\BadgeColumn::make('environment')
                    ->colors([
                        'success' => 'all',
                        'warning' => 'production',
                        'info' => 'staging',
                        'secondary' => 'development',
                    ])
                    ->label('Environment'),
                
                Tables\Columns\TextColumn::make('rollout_percentage')
                    ->formatStateUsing(fn ($state) => $state . '%')
                    ->badge()
                    ->color(fn ($state) => match (true) {
                        $state == 100 => 'success',
                        $state >= 50 => 'warning',
                        default => 'gray',
                    })
                    ->label('Rollout')
                    ->sortable(),
                
                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->getStateUsing(fn (FeatureFlag $record) => $record->is_enabled ? 
                        ($record->rollout_percentage < 100 ? 'beta' : 'active') : 'disabled'
                    )
                    ->colors([
                        'success' => 'active',
                        'warning' => 'beta',
                        'danger' => 'disabled',
                    ]),
                
                Tables\Columns\TextColumn::make('enabled_at')
                    ->dateTime()
                    ->sortable()
                    ->since()
                    ->label('Enabled')
                    ->toggleable(),
                
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->since()
                    ->label('Last Updated'),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_enabled')
                    ->label('Enabled Features'),
                Tables\Filters\SelectFilter::make('environment')
                    ->options([
                        'all' => 'All',
                        'production' => 'Production',
                        'staging' => 'Staging',
                        'development' => 'Development',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('toggle')
                    ->label(fn (FeatureFlag $record) => $record->is_enabled ? 'Disable' : 'Enable')
                    ->icon(fn (FeatureFlag $record) => $record->is_enabled ? 'heroicon-o-x-circle' : 'heroicon-o-check-circle')
                    ->color(fn (FeatureFlag $record) => $record->is_enabled ? 'danger' : 'success')
                    ->action(fn (FeatureFlag $record) => $record->is_enabled ? $record->disable() : $record->enable())
                    ->requiresConfirmation(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('enable_all')
                        ->label('Enable Selected')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(fn ($records) => $records->each->enable())
                        ->requiresConfirmation(),
                    Tables\Actions\BulkAction::make('disable_all')
                        ->label('Disable Selected')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->action(fn ($records) => $records->each->disable())
                        ->requiresConfirmation(),
                ]),
            ])
            ->defaultSort('name')
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
            'index' => Pages\ListFeatureFlags::route('/'),
            'create' => Pages\CreateFeatureFlag::route('/create'),
            'edit' => Pages\EditFeatureFlag::route('/{record}/edit'),
        ];
    }
}
