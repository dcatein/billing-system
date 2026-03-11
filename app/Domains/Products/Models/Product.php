<?php

namespace App\Domains\Products\Models;

use Illuminate\Database\Eloquent\Model;
use App\Domains\Tenants\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Builder;

class Product extends Model
{
    use BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'category_id',
        'name',
        'sku',
        'barcode',
        'price',
        'active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'active' => 'boolean',
    ];
    
        public function scopeSearch(Builder $query, ?string $search): Builder
    {
        if (!$search) {
            return $query;
        }

        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('sku', 'like', "%{$search}%");
        });
    }

    public function scopeStatus(Builder $query, $status): Builder
    {
        if ($status === null || $status === '') {
            return $query;
        }

        return $query->where('active', $status);
    }

    public function scopeSort(Builder $query, ?string $sort, ?string $direction): Builder
    {
        $allowedSorts = ['name', 'sku', 'price', 'active'];

        if (!$sort || !in_array($sort, $allowedSorts)) {
            return $query->orderBy('name');
        }

        $direction = $direction === 'desc' ? 'desc' : 'asc';

        return $query->orderBy($sort, $direction);
    }
}