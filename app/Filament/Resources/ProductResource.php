<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\AdminAudit;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $navigationGroup = 'Catalog';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Product Details')->schema([
                Forms\Components\Select::make('seller_id')
                    ->relationship('seller', 'display_name')
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('category_id')
                    ->relationship('category', 'name')
                    ->required(),
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\RichEditor::make('description')
                    ->required(),
                Forms\Components\TagsInput::make('features'),
                Forms\Components\TagsInput::make('tags'),
            ])->columns(2),
            Forms\Components\Section::make('Pricing & Delivery')->schema([
                Forms\Components\TextInput::make('price')
                    ->numeric()
                    ->prefix('$')
                    ->required(),
                Forms\Components\Select::make('delivery_type')
                    ->options(['file' => 'File', 'code' => 'License Code'])
                    ->required(),
                Forms\Components\TextInput::make('stock_count')
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('purchase_limit')
                    ->numeric()
                    ->default(null),
            ])->columns(2),
            Forms\Components\Section::make('Secure Credentials')
                ->description('Manage encrypted account credentials for secure delivery')
                ->schema([
                    Forms\Components\Placeholder::make('credentials_warning')
                        ->label('')
                        ->content('⚠️ Credentials are encrypted and can only be revealed explicitly. All access is logged.')
                        ->visible(fn ($record) => $record?->hasCredentials()),
                    Forms\Components\Toggle::make('is_unique_credential')
                        ->label('Unique Account (One-time sale)')
                        ->helperText('Product will be archived after first sale'),
                    Forms\Components\Select::make('verification_status')
                        ->options([
                            'pending' => 'Pending Verification',
                            'verified' => 'Verified',
                            'skipped_draft' => 'Skipped (Draft)',
                        ])
                        ->default('pending'),
                    Forms\Components\Placeholder::make('credential_status')
                        ->label('Credential Status')
                        ->content(function ($record) {
                            if (! $record || ! $record->hasCredentials()) {
                                return '❌ No credentials set';
                            }
                            $claimed = $record->orderItems()->whereNotNull('credential_claimed_at')->exists();

                            return $claimed ? '✅ Claimed by buyer' : '🔒 Available for sale';
                        })
                        ->visible(fn ($record) => $record !== null),
                ])->columns(2),
            Forms\Components\Section::make('Status')->schema([
                Forms\Components\Select::make('status')
                    ->options(['draft' => 'Draft', 'active' => 'Active', 'suspended' => 'Suspended', 'archived' => 'Archived'])
                    ->required(),
                Forms\Components\Toggle::make('is_featured')->default(false),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\ImageColumn::make('thumbnail_url')->circular(),
            Tables\Columns\TextColumn::make('title')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('seller.display_name')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('category.name')->badge(),
            Tables\Columns\TextColumn::make('delivery_type')->badge(),
            Tables\Columns\IconColumn::make('has_credentials')
                ->label('🔐')
                ->boolean()
                ->getStateUsing(fn ($record) => $record->hasCredentials())
                ->toggleable(),
            Tables\Columns\TextColumn::make('price')->money('USD')->sortable(),
            Tables\Columns\TextColumn::make('stock_count')->sortable(),
            Tables\Columns\TextColumn::make('status')->badge()->colors([
                'gray' => 'draft',
                'success' => 'active',
                'danger' => 'suspended',
            ]),
            Tables\Columns\IconColumn::make('is_featured')->boolean(),
            Tables\Columns\TextColumn::make('sales_count')->sortable(),
            Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
        ])->filters([
            Tables\Filters\SelectFilter::make('status'),
            Tables\Filters\SelectFilter::make('delivery_type'),
            Tables\Filters\SelectFilter::make('category')->relationship('category', 'name'),
            Tables\Filters\TernaryFilter::make('is_featured'),
        ])->actions([
            Tables\Actions\ActionGroup::make([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('publish')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (Product $r) => $r->status !== 'active')
                    ->action(fn (Product $r) => $r->update(['status' => 'active']) && AdminAudit::log(auth()->user(), 'published', $r))
                    ->visible(fn () => auth()->user()->can('publish_products')),
                Tables\Actions\Action::make('suspend')
                    ->icon('heroicon-o-no-symbol')
                    ->color('danger')
                    ->visible(fn (Product $r) => $r->status === 'active')
                    ->action(fn (Product $r) => $r->update(['status' => 'suspended']) && AdminAudit::log(auth()->user(), 'suspended', $r))
                    ->visible(fn () => auth()->user()->can('suspend_products')),
                Tables\Actions\Action::make('feature')
                    ->icon('heroicon-o-star')
                    ->color('warning')
                    ->visible(fn (Product $r) => ! $r->is_featured)
                    ->action(fn (Product $r) => $r->update(['is_featured' => true]) && AdminAudit::log(auth()->user(), 'featured', $r))
                    ->visible(fn () => auth()->user()->can('feature_products')),
                Tables\Actions\Action::make('unfeature')
                    ->icon('heroicon-o-star')
                    ->color('gray')
                    ->visible(fn (Product $r) => $r->is_featured)
                    ->action(fn (Product $r) => $r->update(['is_featured' => false]) && AdminAudit::log(auth()->user(), 'unfeatured', $r))
                    ->visible(fn () => auth()->user()->can('feature_products')),
            ]),
        ])->bulkActions([
            Tables\Actions\DeleteBulkAction::make()->visible(fn () => auth()->user()->can('delete_products')),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        return auth()->user()->can('view_products');
    }
}
