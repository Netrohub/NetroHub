<?php

namespace App\Filament\Resources\ProductCodeResource\Pages;

use App\Filament\Resources\ProductCodeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProductCode extends EditRecord
{
    protected static string $resource = ProductCodeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
