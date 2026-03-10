<?php

namespace App\Domains\Orders\Models;

use App\Domains\Tenants\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use BelongsToTenant;

    protected $fillable = [
        'status',
        'subtotal',
        'discount',
        'discount_type',
        'total',
        'notes',
        'tenant_id',
        'customer_id',
        'user_id'
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}