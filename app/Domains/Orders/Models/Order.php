<?php

namespace App\Domains\Orders\Models;

use App\Domains\Payments\Models\Payment;
use App\Domains\Tenants\Traits\BelongsToTenant;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $string, string $string1, int $orderId)
 * @method static findOrFail($orderId)
 * @property mixed $id
 * @property mixed $total
 */
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

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
