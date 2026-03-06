<?php

namespace App\Domains\Tenants\Traits;

use App\Domains\Tenants\Scopes\TenantScope;

trait BelongsToTenant
{
    protected static function bootBelongsToTenant()
    {
        static::addGlobalScope(new TenantScope);

        static::creating(function ($model) {
            if (app()->bound('tenant_id')) {
                $model->tenant_id = app('tenant_id');
            }
        });
    }
}