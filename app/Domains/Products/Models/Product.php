<?php

namespace App\Domains\Products\Models;

use Illuminate\Database\Eloquent\Model;
use App\Support\Tenancy\BelongsToTenant;

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
    
}
