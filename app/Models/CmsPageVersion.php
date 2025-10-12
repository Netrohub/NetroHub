<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CmsPageVersion extends Model
{
    protected $fillable = [
        'page_id',
        'version',
        'content',
        'created_by',
    ];

    protected $casts = [
        'version' => 'integer',
    ];

    public function page(): BelongsTo
    {
        return $this->belongsTo(CmsPage::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}

