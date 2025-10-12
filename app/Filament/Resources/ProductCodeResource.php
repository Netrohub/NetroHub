<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductCodeResource\Pages;
use App\Models\ProductCode;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProductCodeResource extends Resource
{
    protected static ?string $model = ProductCode::class;

    protected static ?string $navigationIcon = 'heroicon-o-key';

    protected static ?string $navigationGroup = 'Catalog';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationLabel = 'License Codes';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('product_id')
                ->relationship('product', 'title')
                ->required(),
            Forms\Components\TextInput::make('code')
                ->required()
                ->unique(ignoreRecord: true),
            Forms\Components\Select::make('status')
                ->options(['available' => 'Available', 'claimed' => 'Claimed'])
                ->default('available'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('product.title')->searchable(),
            Tables\Columns\TextColumn::make('code')->searchable(),
            Tables\Columns\TextColumn::make('status')->badge()->colors([
                'success' => 'available',
                'gray' => 'claimed',
            ])->sortable(),
            Tables\Columns\TextColumn::make('claimed_at')->dateTime(),
        ])->filters([
            Tables\Filters\SelectFilter::make('status'),
            Tables\Filters\SelectFilter::make('product')->relationship('product', 'title'),
        ])->actions([
            Tables\Actions\EditAction::make(),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProductCodes::route('/'),
            'create' => Pages\CreateProductCode::route('/create'),
            'edit' => Pages\EditProductCode::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        return auth()->user()->can('view_products');
    }
}
