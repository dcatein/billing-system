<?php

namespace App\Domains\Orders\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'status',
        'subtotal',
        'discount',
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