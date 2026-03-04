<?php

namespace App\Domain\Orders\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    // public function tenant(): BelongsTo
    // {
    //     return $this->belongsTo(\App\Models\Tenant::class);
    // }

    // public function customer(): BelongsTo
    // {
    //     return $this->belongsTo(\App\Domain\Customers\Models\Customer::class);
    // }

    // public function user(): BelongsTo
    // {
    //     return $this->belongsTo(\App\Models\User::class);
    // }
}