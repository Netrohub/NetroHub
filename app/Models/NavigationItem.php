<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NavigationItem extends Model
{
    protected $fillable = [
        'location',
        'label',
        'url',
        'cms_page_id',
        'opens_new_tab',
        'is_visible',
        'order',
    ];

    protected $casts = [
        'opens_new_tab' => 'boolean',
        'is_visible' => 'boolean',
        'order' => 'integer',
    ];

    public function cmsPage(): BelongsTo
    {
        return $this->belongsTo(CmsPage::class);
    }

    public function getHref(): string
    {
        if ($this->cms_page_id && $this->cmsPage) {
            return route('cms.page', ['slug' => $this->cmsPage->slug]);
        }
        
        return $this->url ?? '#';
    }
}

