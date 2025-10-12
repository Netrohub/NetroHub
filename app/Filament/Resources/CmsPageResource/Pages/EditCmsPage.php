<?php

namespace App\Filament\Resources\CmsPageResource\Pages;

use App\Filament\Resources\CmsPageResource;
use App\Models\AdminAudit;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCmsPage extends EditRecord
{
    protected static string $resource = CmsPageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('view_history')
                ->label('Version History')
                ->icon('heroicon-o-clock')
                ->modalHeading('Version History')
                ->modalContent(fn ($record) => view('filament.pages.cms-version-history', [
                    'versions' => $record->versions()->with('createdBy')->latest()->get()
                ]))
                ->modalSubmitAction(false)
                ->modalCancelActionLabel('Close'),
            
            Actions\DeleteAction::make()
                ->visible(fn () => auth()->user()->can('delete_cms_pages')),
        ];
    }
    
    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Save current version before updating
        if ($this->record->isDirty('content')) {
            $this->record->createVersion(auth()->user());
            $data['version'] = $this->record->version + 1;
        }
        
        $data['updated_by'] = auth()->id();
        
        return $data;
    }
    
    protected function afterSave(): void
    {
        AdminAudit::log(
            auth()->user(),
            'cms_page_updated',
            $this->record,
            $this->record->getOriginal(),
            $this->record->getChanges()
        );
    }
}
