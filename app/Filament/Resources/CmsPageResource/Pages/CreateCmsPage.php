<?php

namespace App\Filament\Resources\CmsPageResource\Pages;

use App\Filament\Resources\CmsPageResource;
use App\Models\AdminAudit;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCmsPage extends CreateRecord
{
    protected static string $resource = CmsPageResource::class;
    
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['updated_by'] = auth()->id();
        $data['version'] = 1;
        
        return $data;
    }
    
    protected function afterCreate(): void
    {
        AdminAudit::log(
            auth()->user(),
            'cms_page_created',
            $this->record,
            null,
            $this->record->toArray()
        );
    }
}
