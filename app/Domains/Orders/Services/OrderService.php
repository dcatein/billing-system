<?php

namespace App\Domains\Orders\Services;

use App\Domains\Orders\Models\OrderItem;
use App\Domains\Orders\Contracts\OrderRepositoryInterface;
use App\Domains\Products\Models\Product;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function __construct(
        protected OrderRepositoryInterface $orders
    ) {}

    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {

            $order = $this->orders->create([
                'status' => 'draft',
                'tenant_id' => $data['tenant_id'],
                'customer_id' => $data['customer_id'],
                'user_id' => $data['user_id'],
                'notes' => $data['notes'] ?? null,
                'subtotal' => 0,
                'discount' => $data['discount'] ?? 0,
                'total' => 0
            ]);

            $subtotal = 0;

            foreach ($data['items'] as $item) {

                $product = Product::findOrFail($item['product_id']);

                $lineTotal = $product->price * $item['quantity'];

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'description' => $product->name,
                    'quantity' => $item['quantity'],
                    'unit_price' => $product->price,
                    'total' => $lineTotal
                ]);

                $subtotal += $lineTotal;
            }

            $order->update([
                'subtotal' => $subtotal,
                'total' => $subtotal - $order->discount
            ]);

            return $order->load('items.product');
        });
    }
}