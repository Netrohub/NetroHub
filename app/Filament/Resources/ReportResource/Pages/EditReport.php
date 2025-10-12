<?php

namespace App\Filament\Resources\ReportResource\Pages;

use App\Filament\Resources\ReportResource;
use App\Models\AdminAudit;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReport extends EditRecord
{
    protected static string $resource = ReportResource::class;

    protected function afterSave(): void
    {
        AdminAudit::log(
            auth()->user(),
            'report_updated',
            $this->record,
            $this->record->getOriginal(),
            $this->record->getChanges()
        );
    }
}
