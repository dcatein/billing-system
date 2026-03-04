<?php

namespace App\Support\Tenancy;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Domains\Tenancy\Models\Tenant;

trait BelongsToTenant
{
    protected static function bootBelongsToTenant(): void
    {
        static::addGlobalScope('tenant', function (Builder $builder) {
            if (app()->bound('currentTenant')) {
                $tenantId = app('currentTenant')->id;
                $builder->where(
                    $builder->getModel()->getTable() . '.tenant_id',
                    $tenantId
                );
            }
        });

        static::creating(function (Model $model) {
            if (app()->bound('currentTenant') && empty($model->tenant_id)) {
                $model->tenant_id = app('currentTenant')->id;
            }
        });
    }

    public function tenant()
    {
        return $this->belongsTo(
            Tenant::class
        );
    }
}