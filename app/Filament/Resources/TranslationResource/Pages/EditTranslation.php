<?php

namespace App\Filament\Resources\TranslationResource\Pages;

use App\Filament\Resources\TranslationResource;
use App\Models\Translation;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditTranslation extends EditRecord
{
    protected static string $resource = TranslationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterSave(): void
    {
        try {
            Translation::syncToFiles();
            
            Notification::make()
                ->title('Translation updated and synced')
                ->body('JSON files have been updated automatically')
                ->success()
                ->send();
        } catch (\Exception $e) {
            Notification::make()
                ->title('Sync warning')
                ->body('Translation updated but sync failed: ' . $e->getMessage())
                ->warning()
                ->send();
        }
    }
}

