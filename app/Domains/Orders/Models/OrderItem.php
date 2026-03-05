<?php

namespace App\Domains\Orders\Models;

use Illuminate\Database\Eloquent\Model;
use App\Domains\Products\Models\Product;

class OrderItem extends Model
{
    protected $fillable = [
        'description',
        'quantity',
        'unit_price',
        'total',
        'order_id',
        'product_id'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}