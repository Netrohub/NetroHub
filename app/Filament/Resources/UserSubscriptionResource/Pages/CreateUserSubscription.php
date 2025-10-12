<?php

namespace App\Filament\Resources\UserSubscriptionResource\Pages;

use App\Filament\Resources\UserSubscriptionResource;
use App\Services\EntitlementsService;
use Filament\Resources\Pages\CreateRecord;

class CreateUserSubscription extends CreateRecord
{
    protected static string $resource = UserSubscriptionResource::class;

    protected function afterCreate(): void
    {
        // Regenerate entitlements after creating subscription
        $entitlementsService = app(EntitlementsService::class);
        $entitlementsService->regenerateEntitlements($this->record->user);
    }
}
