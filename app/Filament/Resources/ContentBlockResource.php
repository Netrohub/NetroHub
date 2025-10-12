<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContentBlockResource\Pages;
use App\Filament\Resources\ContentBlockResource\RelationManagers;
use App\Models\ContentBlock;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ContentBlockResource extends Resource
{
    protected static ?string $model = ContentBlock::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';
    
    protected static ?string $navigationLabel = 'Content Blocks';
    
    protected static ?string $navigationGroup = 'CMS';
    
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Block Identification')
                    ->schema([
                        Forms\Components\TextInput::make('identifier')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->placeholder('e.g., homepage_hero')
                            ->helperText('Unique identifier (use snake_case)')
                            ->columnSpan(2),
                        
                        Forms\Components\Select::make('page')
                            ->required()
                            ->options([
                                'homepage' => 'Homepage',
                                'about' => 'About',
                                'pricing' => 'Pricing',
                                'contact' => 'Contact',
                                'products' => 'Products',
                                'custom' => 'Custom',
                            ])
                            ->default('homepage')
                            ->searchable()
                            ->columnSpan(1),
                        
                        Forms\Components\TextInput::make('section')
                            ->placeholder('e.g., hero, features, footer')
                            ->helperText('Optional section grouping')
                            ->columnSpan(1),
                    ])->columns(4),
                
                Forms\Components\Section::make('Content')
                    ->schema([
                        Forms\Components\Select::make('type')
                            ->required()
                            ->options([
                                'text' => 'Text',
                                'html' => 'HTML',
                                'hero' => 'Hero Section',
                                'grid' => 'Grid Layout',
                                'stats' => 'Statistics',
                                'steps' => 'Step-by-Step',
                                'testimonials' => 'Testimonials',
                                'cta' => 'Call-to-Action',
                                'slider' => 'Image Slider',
                                'video' => 'Video',
                            ])
                            ->default('text')
                            ->reactive()
                            ->columnSpan(1),
                        
                        Forms\Components\TextInput::make('order')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->helperText('Display order (lower = first)')
                            ->columnSpan(1),
                        
                        Forms\Components\TextInput::make('title')
                            ->maxLength(255)
                            ->placeholder('Block title')
                            ->columnSpanFull(),
                        
                        Forms\Components\RichEditor::make('content')
                            ->label('Content / Description')
                            ->placeholder('Enter your content here...')
                            ->columnSpanFull(),
                        
                        Forms\Components\KeyValue::make('metadata')
                            ->label('Metadata (JSON)')
                            ->helperText('Additional data like images, links, buttons, etc.')
                            ->columnSpanFull(),
                        
                        Forms\Components\KeyValue::make('styling')
                            ->label('Custom Styling (CSS Classes)')
                            ->helperText('Optional custom CSS classes')
                            ->columnSpanFull(),
                    ])->columns(2),
                
                Forms\Components\Section::make('Visibility Settings')
                    ->schema([
                        Forms\Components\Toggle::make('is_active')
                            ->label('Active')
                            ->helperText('Show this block on the website')
                            ->default(true)
                            ->inline(false)
                            ->columnSpan(1),
                        
                        Forms\Components\Select::make('visibility')
                            ->required()
                            ->options([
                                'public' => 'Public (Everyone)',
                                'members_only' => 'Members Only',
                                'premium' => 'Premium Subscribers Only',
                            ])
                            ->default('public')
                            ->columnSpan(1),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('identifier')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->label('Identifier')
                    ->weight('bold'),
                
                Tables\Columns\BadgeColumn::make('page')
                    ->searchable()
                    ->sortable()
                    ->colors([
                        'primary' => 'homepage',
                        'success' => 'about',
                        'warning' => 'pricing',
                        'info' => 'products',
                    ])
                    ->label('Page'),
                
                Tables\Columns\TextColumn::make('section')
                    ->searchable()
                    ->sortable()
                    ->label('Section')
                    ->placeholder('—'),
                
                Tables\Columns\TextColumn::make('order')
                    ->numeric()
                    ->sortable()
                    ->label('Order')
                    ->alignCenter(),
                
                Tables\Columns\BadgeColumn::make('type')
                    ->colors([
                        'secondary' => 'text',
                        'success' => 'hero',
                        'warning' => 'grid',
                        'danger' => 'cta',
                        'info' => 'stats',
                    ])
                    ->label('Type'),
                
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->limit(30)
                    ->label('Title'),
                
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->label('Active')
                    ->sortable(),
                
                Tables\Columns\BadgeColumn::make('visibility')
                    ->colors([
                        'success' => 'public',
                        'warning' => 'members_only',
                        'danger' => 'premium',
                    ])
                    ->label('Visibility'),
                
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->since()
                    ->label('Last Updated')
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('page')
                    ->options([
                        'homepage' => 'Homepage',
                        'about' => 'About',
                        'pricing' => 'Pricing',
                        'contact' => 'Contact',
                        'products' => 'Products',
                    ]),
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'text' => 'Text',
                        'html' => 'HTML',
                        'hero' => 'Hero',
                        'grid' => 'Grid',
                        'stats' => 'Stats',
                        'cta' => 'CTA',
                    ]),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active Blocks'),
                Tables\Filters\SelectFilter::make('visibility')
                    ->options([
                        'public' => 'Public',
                        'members_only' => 'Members Only',
                        'premium' => 'Premium',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('duplicate')
                    ->icon('heroicon-o-document-duplicate')
                    ->action(fn (ContentBlock $record) => $record->replicate()->save())
                    ->color('warning'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('activate')
                        ->label('Activate Selected')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(fn ($records) => $records->each->update(['is_active' => true])),
                    Tables\Actions\BulkAction::make('deactivate')
                        ->label('Deactivate Selected')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->action(fn ($records) => $records->each->update(['is_active' => false])),
                ]),
            ])
            ->defaultSort('order')
            ->reorderable('order');
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
            'index' => Pages\ListContentBlocks::route('/'),
            'create' => Pages\CreateContentBlock::route('/create'),
            'edit' => Pages\EditContentBlock::route('/{record}/edit'),
        ];
    }
}
