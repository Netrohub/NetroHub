<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class CmsPage extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'slug',
        'title',
        'content',
        'meta_title',
        'meta_description',
        'status',
        'version',
        'updated_by',
    ];

    protected $casts = [
        'version' => 'integer',
    ];

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function versions(): HasMany
    {
        return $this->hasMany(CmsPageVersion::class, 'page_id');
    }

    public function createVersion(User $user): void
    {
        $this->versions()->create([
            'version' => $this->version,
            'content' => $this->content,
            'created_by' => $user->id,
        ]);
    }

    public function restoreVersion(int $versionNumber): bool
    {
        $version = $this->versions()->where('version', $versionNumber)->first();
        
        if (!$version) {
            return false;
        }
        
        $this->content = $version->content;
        $this->version = $this->version + 1;
        $this->save();
        
        return true;
    }
}

