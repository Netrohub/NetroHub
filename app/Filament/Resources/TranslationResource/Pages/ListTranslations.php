<?php

namespace App\Filament\Resources\TranslationResource\Pages;

use App\Filament\Resources\TranslationResource;
use App\Models\Translation;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Notifications\Notification;

class ListTranslations extends ListRecords
{
    protected static string $resource = TranslationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('import')
                ->label('Import from JSON')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->action(function () {
                    try {
                        Translation::importFromFiles();
                        
                        Notification::make()
                            ->title('Translations imported successfully')
                            ->success()
                            ->send();
                    } catch (\Exception $e) {
                        Notification::make()
                            ->title('Import failed')
                            ->body($e->getMessage())
                            ->danger()
                            ->send();
                    }
                })
                ->requiresConfirmation(),
            
            Actions\Action::make('export')
                ->label('Export to JSON')
                ->icon('heroicon-o-arrow-up-tray')
                ->color('warning')
                ->action(function () {
                    try {
                        Translation::syncToFiles();
                        
                        Notification::make()
                            ->title('Translations exported successfully')
                            ->body('JSON files have been updated')
                            ->success()
                            ->send();
                    } catch (\Exception $e) {
                        Notification::make()
                            ->title('Export failed')
                            ->body($e->getMessage())
                            ->danger()
                            ->send();
                    }
                })
                ->requiresConfirmation(),
            
            Actions\CreateAction::make(),
        ];
    }
}

