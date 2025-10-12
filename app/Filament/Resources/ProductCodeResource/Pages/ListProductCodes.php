<?php

namespace App\Filament\Resources\ProductCodeResource\Pages;

use App\Filament\Resources\ProductCodeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProductCodes extends ListRecords
{
    protected static string $resource = ProductCodeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
