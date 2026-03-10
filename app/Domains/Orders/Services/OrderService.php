<?php

namespace App\Domains\Orders\Services;

use App\Domains\Orders\Repositories\Contracts\OrderRepositoryInterface;
use App\Domains\Orders\Models\Order;
use Illuminate\Pagination\LengthAwarePaginator;

class OrderService
{
    public function __construct(
        protected OrderRepositoryInterface $repository
    ) {}

    public function create(array $data): Order
    {
        //TODO: Criar um Service Request de Draft Order

        $data['sub_total'] = $this->calculateItemsPrice($data['items']);
        $data['total'] = $this->calculateDiscount(
            $data['sub_total'],
            $data['discount_type'],
            $data['discount_value']
        );
        $data['discount'] = $data['discount_value'];

        $orderDraft = $this->repository->create($data);

        $this->createOrderItems($data['items'], $orderDraft->id);
        $this->createPayment($data['payments'], $orderDraft->id);

        $status = $this->orderStatus($data['payments'], $data['total']);

        $this->updateOrderStatus($orderDraft->id, $status);

        return $orderDraft;
    }

    public function update(Order $order, array $data): Order
    {
        return $this->repository->update($order, $data);
    }

    public function delete(Order $order): void
    {
        $this->repository->delete($order);
    }

    public function index(int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository->paginate(perPage: $perPage);
    }

    public function getById(int $id): Order
    {
        return $this->repository->findById($id);
    }

    private function calculateItemsPrice(array $items)
    {
        $total = 0;

        foreach ($items as $item) {
            $total = $total + $item['total'];
        }

        return $total;
    }

    private function calculateDiscount($total, $discount_type = null, $discount_value = 0)
    {
        //TODO: Exceção se desconto for maior que o total
        if ($discount_type == null || $discount_value <= 0) {
            return $total;
        }

        if ($discount_type == 'valor') {
            $total = $total - $discount_value;
        }

        if ($discount_type == 'percentual') {
            $total = ($total - ($total * ($discount_value / 100)));
        }

        return $total;
    }

    private function orderStatus(array $payments, $total): string
    {
        $totalPay = 0;

        foreach ($payments as $payment) 
        {
            $totalPay = $payment['amount'] + $totalPay;
        }

        if ($totalPay < $total) {
            return 'pending';
        }

        if ($totalPay == $total) {
            return 'paid';
        }

        return 'draft';
    }

    private function createOrderItems(array $items, $orderId) 
    {
        $this->repository->createOrderItems($items, $orderId);
    }

    private function createPayment(array $payments, $orderId)
    {
        foreach ($payments as $payment) {
            $payment['order_id'] = $orderId;
            $this->repository->createOrderPayment($payment);
        }
    }

    private function updateOrderStatus($orderId, $status): void
    {
        $this->repository->updateOrderStatus($orderId, $status);
    }
}
