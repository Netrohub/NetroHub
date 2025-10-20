<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Encrypted implements CastsAttributes
{
    /**
     * Cast the given value.
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if (is_null($value)) {
            return null;
        }

        try {
            return Crypt::decryptString($value);
        } catch (\Exception $e) {
            // Log decryption errors but don't expose them
            \Log::error('Failed to decrypt sensitive data', [
                'model' => get_class($model),
                'key' => $key,
                'error' => $e->getMessage()
            ]);
            
            return null;
        }
    }

    /**
     * Prepare the given value for storage.
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if (is_null($value)) {
            return null;
        }

        return Crypt::encryptString($value);
    }
}
