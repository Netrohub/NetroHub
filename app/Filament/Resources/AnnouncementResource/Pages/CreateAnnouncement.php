<?php

namespace App\Filament\Resources\AnnouncementResource\Pages;

use App\Filament\Resources\AnnouncementResource;
use App\Models\AdminAudit;
use Filament\Resources\Pages\CreateRecord;

class CreateAnnouncement extends CreateRecord
{
    protected static string $resource = AnnouncementResource::class;
    
    protected function afterCreate(): void
    {
        AdminAudit::log(
            auth()->user(),
            'announcement_created',
            $this->record,
            null,
            $this->record->toArray()
        );
    }
}

