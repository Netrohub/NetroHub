<?php

namespace App\Filament\Resources\TranslationResource\Pages;

use App\Filament\Resources\TranslationResource;
use App\Models\Translation;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateTranslation extends CreateRecord
{
    protected static string $resource = TranslationResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterCreate(): void
    {
        try {
            Translation::syncToFiles();
            
            Notification::make()
                ->title('Translation created and synced')
                ->body('JSON files have been updated automatically')
                ->success()
                ->send();
        } catch (\Exception $e) {
            Notification::make()
                ->title('Sync warning')
                ->body('Translation created but sync failed: ' . $e->getMessage())
                ->warning()
                ->send();
        }
    }
}

