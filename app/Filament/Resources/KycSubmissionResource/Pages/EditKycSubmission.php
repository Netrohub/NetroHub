<?php

namespace App\Filament\Resources\KycSubmissionResource\Pages;

use App\Filament\Resources\KycSubmissionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKycSubmission extends EditRecord
{
    protected static string $resource = KycSubmissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
