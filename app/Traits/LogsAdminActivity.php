<?php

namespace App\Traits;

use App\Models\AdminAudit;
use Illuminate\Database\Eloquent\Model;

trait LogsAdminActivity
{
    protected static function bootLogsAdminActivity()
    {
        static::created(function (Model $model) {
            if (auth()->check() && auth()->user()->hasAnyRole(['owner', 'admin', 'moderator', 'finance', 'support'])) {
                AdminAudit::log(
                    admin: auth()->user(),
                    action: 'created',
                    auditable: $model,
                    newValues: $model->getAttributes()
                );
            }
        });

        static::updated(function (Model $model) {
            if (auth()->check() && auth()->user()->hasAnyRole(['owner', 'admin', 'moderator', 'finance', 'support'])) {
                AdminAudit::log(
                    admin: auth()->user(),
                    action: 'updated',
                    auditable: $model,
                    oldValues: $model->getOriginal(),
                    newValues: $model->getChanges()
                );
            }
        });

        static::deleted(function (Model $model) {
            if (auth()->check() && auth()->user()->hasAnyRole(['owner', 'admin', 'moderator', 'finance', 'support'])) {
                AdminAudit::log(
                    admin: auth()->user(),
                    action: 'deleted',
                    auditable: $model,
                    oldValues: $model->getAttributes()
                );
            }
        });
    }
}
