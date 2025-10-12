<?php

namespace App\Filament\Resources\EmailTemplateResource\Pages;

use App\Filament\Resources\EmailTemplateResource;
use App\Models\AdminAudit;
use Filament\Resources\Pages\CreateRecord;

class CreateEmailTemplate extends CreateRecord
{
    protected static string $resource = EmailTemplateResource::class;
    
    protected function afterCreate(): void
    {
        AdminAudit::log(
            auth()->user(),
            'email_template_created',
            $this->record,
            null,
            $this->record->toArray()
        );
    }
}

