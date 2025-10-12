<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use App\Models\Seller;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class TopPerformersWidget extends BaseWidget
{
    protected static ?int $sort = 2;
    
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Product::query()
                    ->with(['seller.user'])
                    ->where('status', 'active')
                    ->orderByDesc('sales_count')
                    ->limit(10)
            )
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->limit(40)
                    ->searchable()
                    ->label('Product')
                    ->weight('bold'),
                
                Tables\Columns\TextColumn::make('seller.display_name')
                    ->label('Seller')
                    ->limit(20),
                
                Tables\Columns\TextColumn::make('sales_count')
                    ->label('Sales')
                    ->sortable()
                    ->alignCenter()
                    ->badge()
                    ->color('success'),
                
                Tables\Columns\TextColumn::make('price')
                    ->money('usd')
                    ->label('Price')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('rating')
                    ->label('Rating')
                    ->formatStateUsing(fn ($state) => $state ? number_format($state, 1) . ' ⭐' : 'N/A')
                    ->sortable(),
                
                Tables\Columns\BadgeColumn::make('category.name')
                    ->label('Category')
                    ->colors([
                        'primary' => 'Gaming',
                        'success' => 'Social Media',
                        'warning' => 'Software',
                    ]),
            ])
            ->heading('Top Selling Products')
            ->description('Best performing products by sales volume')
            ->defaultSort('sales_count', 'desc');
    }
}

