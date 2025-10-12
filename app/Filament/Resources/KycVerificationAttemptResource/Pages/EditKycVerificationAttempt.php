<?php

namespace App\Filament\Resources\KycVerificationAttemptResource\Pages;

use App\Filament\Resources\KycVerificationAttemptResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditKycVerificationAttempt extends EditRecord
{
    protected static string $resource = KycVerificationAttemptResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Automatically set the reviewed_at timestamp when saving
        $data['reviewed_at'] = now();
        
        // Also update the seller's KYC status and reviewed timestamp
        if ($this->record && $this->record->seller) {
            $seller = $this->record->seller;
            
            // Update seller KYC status based on the attempt status
            if (isset($data['status'])) {
                $seller->kyc_status = $data['status'];
                
                if ($data['status'] === 'approved') {
                    $seller->kyc_reviewed_at = now();
                    $seller->kyc_rejection_reason = null; // Clear rejection reason on approval
                } elseif ($data['status'] === 'rejected') {
                    $seller->kyc_reviewed_at = now();
                    // Keep rejection reason if provided
                }
                
                $seller->kyc_reviewed_by = auth()->id();
                $seller->save();
            }
        }
        
        return $data;
    }

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('KYC Verification Updated')
            ->body('The verification has been reviewed and updated successfully.');
    }
}
