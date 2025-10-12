<?php

namespace App\Filament\Resources\KycSubmissionResource\Pages;

use App\Filament\Resources\KycSubmissionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKycSubmissions extends ListRecords
{
    protected static string $resource = KycSubmissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
