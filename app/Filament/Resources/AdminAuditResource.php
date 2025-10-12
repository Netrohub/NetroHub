<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdminAuditResource\Pages;
use App\Models\AdminAudit;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AdminAuditResource extends Resource
{
    protected static ?string $model = AdminAudit::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationGroup = 'Platform';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationLabel = 'Audit Log';

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('id')->sortable(),
            Tables\Columns\TextColumn::make('admin.email')->searchable(),
            Tables\Columns\TextColumn::make('action')->badge(),
            Tables\Columns\TextColumn::make('auditable_type')->label('Model'),
            Tables\Columns\TextColumn::make('auditable_id')->label('ID'),
            Tables\Columns\TextColumn::make('ip_address'),
            Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable(),
        ])->filters([
            Tables\Filters\SelectFilter::make('admin')->relationship('admin', 'email'),
        ])->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAdminAudits::route('/'),
        ];
    }

    public static function canViewAny(): bool
    {
        return auth()->user()->can('view_audit_logs');
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit($record): bool
    {
        return false;
    }

    public static function canDelete($record): bool
    {
        return false;
    }
}
