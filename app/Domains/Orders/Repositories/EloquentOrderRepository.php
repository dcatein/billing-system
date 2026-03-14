<?php

namespace App\Domains\Orders\Repositories;

use App\Domains\Orders\Repositories\Contracts\OrderRepositoryInterface;
use App\Domains\Orders\Models\Order;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Domains\Orders\Models\OrderItem;
use App\Domains\Payments\Models\Payment;
use Illuminate\Database\Eloquent\Collection;

class EloquentOrderRepository implements OrderRepositoryInterface
{
    public function paginate(array $filters, int $perPage = 15): LengthAwarePaginator
    {
        $query = Order::with('items.product');

        if (!empty($filters['user_id'])) {
            $query->where('user_id', $filters['user_id']);
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['sort_by'])) {
            $direction = $filters['sort_direction'] ?? 'asc';
            $query->orderBy($filters['sort_by'], $direction);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        return $query->paginate($perPage);
    }

    public function findById(int $id): Order
    {
        return Order::with('items.product')->findOrFail($id);
    }

    public function create(array $data): Order
    {
        return Order::create($data);
    }

    public function update(Order $order, array $data): Order
    {
        $order->update($data);
        return $order;
    }

    public function delete(Order $order): void
    {
        $order->delete();
    }

    public function createOrderItems(array $items, int $orderId): void
    {
        $data = [];

        foreach ($items as $item) {
            $data[] = [
                'order_id'   => $orderId,
                'product_id' => $item['product_id'],
                'quantity'   => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'total'      => $item['total'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        OrderItem::insert($data);
    }

    public function createOrderPayment(array $payment): void
    {
        Payment::create($payment);
    }

    public function updateOrderStatus(int $orderId, string $status): void
    {
        Order::where('id', '=', $orderId)
            ->update(['status' => $status]);
    }

    public function getOrderInfo(Order $order): Order
    {
        return Order::with([
            'items.product',
            'payments',
            'user'
        ])->findOrFail($order->id);
    }
}
