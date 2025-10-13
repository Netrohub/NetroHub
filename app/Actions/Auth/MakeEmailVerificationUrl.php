<?php

namespace App\Actions\Auth;

use Illuminate\Support\Facades\URL;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Carbon;

class MakeEmailVerificationUrl
{
    /**
     * Generate a signed verification URL for the user
     */
    public function __invoke(MustVerifyEmail $user): string
    {
        return URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(60), // Link expires in 60 minutes
            [
                'id'   => $user->getKey(),
                'hash' => sha1($user->getEmailForVerification()),
            ]
        );
    }
}


