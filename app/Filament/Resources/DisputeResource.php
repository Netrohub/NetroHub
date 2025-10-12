<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DisputeResource\Pages;
use App\Models\AdminAudit;
use App\Models\Dispute;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class DisputeResource extends Resource
{
    protected static ?string $model = Dispute::class;

    protected static ?string $navigationIcon = 'heroicon-o-exclamation-triangle';

    protected static ?string $navigationGroup = 'Commerce';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Textarea::make('admin_notes')->rows(4),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('id')->sortable(),
            Tables\Columns\TextColumn::make('order.order_number')->searchable(),
            Tables\Columns\TextColumn::make('buyer.email')->searchable(),
            Tables\Columns\TextColumn::make('seller.display_name')->searchable(),
            Tables\Columns\TextColumn::make('reason'),
            Tables\Columns\TextColumn::make('status')->badge()->colors([
                'danger' => 'open',
                'warning' => 'in_review',
                'success' => fn ($state) => in_array($state, ['resolved_refund', 'resolved_upheld']),
            ])->sortable(),
            Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable(),
        ])->filters([
            Tables\Filters\SelectFilter::make('status'),
        ])->actions([
            Tables\Actions\ActionGroup::make([
                Tables\Actions\Action::make('review')->icon('heroicon-o-eye')
                    ->visible(fn (Dispute $r) => $r->status === 'open')
                    ->action(fn (Dispute $r) => $r->update(['status' => 'in_review']) && AdminAudit::log(auth()->user(), 'dispute_reviewed', $r))
                    ->visible(fn () => auth()->user()->can('manage_disputes')),
                Tables\Actions\Action::make('refund')->icon('heroicon-o-arrow-uturn-left')->color('warning')
                    ->visible(fn (Dispute $r) => in_array($r->status, ['open', 'in_review']))
                    ->form([Forms\Components\Textarea::make('notes')->required()])
                    ->action(fn (Dispute $r, array $data) => $r->resolve(auth()->user(), 'resolved_refund', $data['notes']))
                    ->visible(fn () => auth()->user()->can('resolve_disputes')),
                Tables\Actions\Action::make('uphold')->icon('heroicon-o-check')->color('success')
                    ->visible(fn (Dispute $r) => in_array($r->status, ['open', 'in_review']))
                    ->form([Forms\Components\Textarea::make('notes')->required()])
                    ->action(fn (Dispute $r, array $data) => $r->resolve(auth()->user(), 'resolved_upheld', $data['notes']))
                    ->visible(fn () => auth()->user()->can('resolve_disputes')),
            ]),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDisputes::route('/'),
        ];
    }

    public static function canViewAny(): bool
    {
        return auth()->user()->can('view_disputes');
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
