<?php

namespace App\Domains\Orders\Repositories\Contracts;

use App\Domains\Orders\Models\Order;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface OrderRepositoryInterface
{
    public function paginate(array $filters, int $perPage = 15): LengthAwarePaginator;

    public function findById(int $id): Order;

    public function create(array $data): Order;

    public function update(Order $order, array $data): Order;

    public function delete(Order $order): void;

    public function createOrderItems(array $items, int $orderId): void;

    public function createOrderPayment(array $payment): void;

    public function updateOrderStatus(int $orderId, string $status): void;

    public function getOrderInfo(Order $order): ?Order;

    public function cancelOrder($orderId, $cancelReason): void;
}
