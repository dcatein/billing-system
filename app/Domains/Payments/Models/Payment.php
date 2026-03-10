<?php

namespace App\Domains\Payments\Models;

use Illuminate\Database\Eloquent\Model;
use App\Domains\Tenants\Traits\BelongsToTenant;

class Payment extends Model
{
    use BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'order_id',
        'amount',
        'method',
        'paid_at',
        'installments'
    ];
}
