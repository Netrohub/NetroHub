<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PlanResource\Pages;
use App\Models\Plan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PlanResource extends Resource
{
    protected static ?string $model = Plan::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    protected static ?string $navigationGroup = 'Subscriptions';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Plan Details')->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                Forms\Components\TextInput::make('sort_order')
                    ->numeric()
                    ->default(0),
                Forms\Components\Toggle::make('is_active')
                    ->default(true),
            ])->columns(2),

            Forms\Components\Section::make('Pricing')->schema([
                Forms\Components\TextInput::make('price_month')
                    ->label('Monthly Price')
                    ->numeric()
                    ->prefix('$')
                    ->default(0)
                    ->required(),
                Forms\Components\TextInput::make('price_year')
                    ->label('Yearly Price')
                    ->numeric()
                    ->prefix('$')
                    ->default(0)
                    ->required(),
                Forms\Components\TextInput::make('currency')
                    ->default('USD')
                    ->maxLength(3),
            ])->columns(3),

            Forms\Components\Section::make('Paddle Integration')->schema([
                Forms\Components\TextInput::make('paddle_price_id_month')
                    ->label('Paddle Price ID (Monthly)')
                    ->maxLength(255),
                Forms\Components\TextInput::make('paddle_price_id_year')
                    ->label('Paddle Price ID (Yearly)')
                    ->maxLength(255),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('name')
                ->searchable()
                ->sortable()
                ->weight('bold'),
            Tables\Columns\TextColumn::make('slug')
                ->searchable()
                ->badge(),
            Tables\Columns\TextColumn::make('price_month')
                ->label('Monthly')
                ->money('USD')
                ->sortable(),
            Tables\Columns\TextColumn::make('price_year')
                ->label('Yearly')
                ->money('USD')
                ->sortable(),
            Tables\Columns\TextColumn::make('subscriptions_count')
                ->counts('subscriptions')
                ->label('Subscribers')
                ->sortable(),
            Tables\Columns\IconColumn::make('is_active')
                ->boolean()
                ->sortable(),
            Tables\Columns\TextColumn::make('sort_order')
                ->sortable(),
        ])->filters([
            Tables\Filters\TernaryFilter::make('is_active'),
        ])->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\Action::make('manage_features')
                ->icon('heroicon-o-list-bullet')
                ->url(fn (Plan $record) => PlanResource::getUrl('features', ['record' => $record])),
        ])->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ]),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPlans::route('/'),
            'create' => Pages\CreatePlan::route('/create'),
            'edit' => Pages\EditPlan::route('/{record}/edit'),
            'features' => Pages\ManagePlanFeatures::route('/{record}/features'),
        ];
    }
}
