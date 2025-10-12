<?php

namespace App\Filament\Resources\KycVerificationAttemptResource\Pages;

use App\Filament\Resources\KycVerificationAttemptResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKycVerificationAttempts extends ListRecords
{
    protected static string $resource = KycVerificationAttemptResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
