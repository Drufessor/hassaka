<?php

namespace App\Traits;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

trait Auditable
{
    protected static function bootAuditable()
    {
        static::created(function (Model $model) {
            static::audit('created', $model);
        });

        static::updated(function (Model $model) {
            static::audit('updated', $model);
        });

        static::deleted(function (Model $model) {
            static::audit('deleted', $model);
        });
    }

    protected static function audit(string $event, Model $model)
    {
        $changes = [
            'old' => [],
            'new' => []
        ];

        if ($event === 'updated') {
            $changes = [
                'old' => array_intersect_key($model->getOriginal(), $model->getChanges()),
                'new' => $model->getChanges()
            ];
        } elseif ($event === 'created') {
            $changes['new'] = $model->getAttributes();
        } elseif ($event === 'deleted') {
            $changes['old'] = $model->getAttributes();
        }

        AuditLog::create([
            'user_id' => Auth::id(),
            'event' => $event,
            'auditable_type' => get_class($model),
            'auditable_id' => $model->getKey(),
            'old_values' => $changes['old'],
            'new_values' => $changes['new'],
            'url' => request()->fullUrl(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    public function auditLogs()
    {
        return $this->morphMany(AuditLog::class, 'auditable');
    }
} 