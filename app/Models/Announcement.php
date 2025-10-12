<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $fillable = [
        'title',
        'message',
        'type',
        'target',
        'is_dismissible',
        'is_active',
        'starts_at',
        'ends_at',
    ];

    protected $casts = [
        'is_dismissible' => 'boolean',
        'is_active' => 'boolean',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('starts_at')->orWhere('starts_at', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('ends_at')->orWhere('ends_at', '>=', now());
            });
    }

    public function scopeForUser($query, User $user)
    {
        return $query->where(function ($q) use ($user) {
            $q->where('target', 'all')
                ->orWhere(function ($sq) use ($user) {
                    if ($user->seller) {
                        $sq->where('target', 'sellers');
                    } else {
                        $sq->where('target', 'buyers');
                    }
                });
        });
    }
}

