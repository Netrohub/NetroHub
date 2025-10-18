<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    public static function getNavigationGroup(): ?string
    {
        return 'Product Management';
    }

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Product Information')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('description')
                            ->required()
                            ->rows(4),
                        Forms\Components\TextInput::make('price')
                            ->numeric()
                            ->prefix('$')
                            ->required(),
                        Forms\Components\Select::make('category_id')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload(),
                        Forms\Components\Select::make('status')
                            ->options([
                                'draft' => 'Draft',
                                'active' => 'Active',
                                'inactive' => 'Inactive',
                                'sold_out' => 'Sold Out',
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('stock')
                            ->numeric()
                            ->default(1),
                        Forms\Components\Toggle::make('is_featured')
                            ->label('Featured Product'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('seller.name')
                    ->label('Seller')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Category')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->money('USD')
                    ->sortable(),
                Tables\Columns\TextColumn::make('stock')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'draft' => 'gray',
                        'active' => 'success',
                        'inactive' => 'warning',
                        'sold_out' => 'danger',
                    }),
                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Featured')
                    ->boolean(),
                Tables\Columns\TextColumn::make('sales_count')
                    ->label('Sales')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                        'sold_out' => 'Sold Out',
                    ]),
                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('Featured'),
                Tables\Filters\SelectFilter::make('category')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'view' => Pages\ViewProduct::route('/{record}'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
