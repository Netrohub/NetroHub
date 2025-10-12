<?php

namespace App\Filament\Resources\AdminAuditResource\Pages;

use App\Filament\Resources\AdminAuditResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAdminAudit extends EditRecord
{
    protected static string $resource = AdminAuditResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
