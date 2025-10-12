<?php

namespace App\Filament\Resources\PlanResource\Pages;

use App\Filament\Resources\PlanResource;
use App\Models\PlanFeature;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Tables;
use Filament\Tables\Table;

class ManagePlanFeatures extends ManageRelatedRecords
{
    protected static string $resource = PlanResource::class;

    protected static string $relationship = 'features';

    protected static ?string $navigationIcon = 'heroicon-o-list-bullet';

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('key')
                ->required()
                ->maxLength(255)
                ->helperText('Internal key (e.g., boost_slots, platform_fee_pct)'),

            Forms\Components\TextInput::make('label')
                ->required()
                ->maxLength(255)
                ->helperText('Display label shown to users'),

            Forms\Components\Group::make([
                Forms\Components\Select::make('value_type')
                    ->label('Value Type')
                    ->options([
                        'boolean' => 'Boolean (true/false)',
                        'integer' => 'Integer (whole numbers)',
                        'decimal' => 'Decimal (numbers with decimals)',
                        'text' => 'Text',
                    ])
                    ->required()
                    ->live(),

                Forms\Components\TextInput::make('value')
                    ->label('Value')
                    ->required()
                    ->helperText('Enter the feature value'),
            ])->columns(2),

            Forms\Components\TextInput::make('sort_order')
                ->numeric()
                ->default(0)
                ->label('Sort Order'),

            Forms\Components\Toggle::make('is_new')
                ->label('Show "New" Badge')
                ->default(false),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('sort_order')
                    ->sortable()
                    ->width(50),
                Tables\Columns\TextColumn::make('key')
                    ->searchable()
                    ->badge()
                    ->color('info'),
                Tables\Columns\TextColumn::make('label')
                    ->searchable()
                    ->wrap(),
                Tables\Columns\TextColumn::make('value_json')
                    ->label('Value')
                    ->formatStateUsing(fn ($state) => $state['value'] ?? 'N/A'),
                Tables\Columns\IconColumn::make('is_new')
                    ->boolean()
                    ->label('New'),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_new'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['value_json'] = [
                            'value' => $data['value'],
                            'type' => $data['value_type'],
                        ];
                        unset($data['value'], $data['value_type']);

                        return $data;
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->mutateFormDataUsing(function (array $data, PlanFeature $record): array {
                        $data['value'] = $record->value_json['value'] ?? '';
                        $data['value_type'] = $record->value_json['type'] ?? 'text';

                        return $data;
                    })
                    ->mutateRecordDataUsing(function (array $data): array {
                        $data['value_json'] = [
                            'value' => $data['value'],
                            'type' => $data['value_type'],
                        ];
                        unset($data['value'], $data['value_type']);

                        return $data;
                    }),
                Tables\Actions\DeleteAction::make(),
            ])
            ->reorderable('sort_order')
            ->defaultSort('sort_order');
    }
}
