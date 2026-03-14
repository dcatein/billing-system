<?php

namespace App\Domains\Orders\Services;

use App\Domains\Orders\Repositories\Contracts\OrderRepositoryInterface;
use App\Domains\Orders\Models\Order;
use App\Domains\Payments\Repositories\Contracts\PaymentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Domains\Orders\DTO\CreateOrderDTO;

class OrderService
{
    public function __construct(
        protected OrderRepositoryInterface $repository,
        private readonly PaymentRepositoryInterface $paymentRepository
    ) {}

    public function create(CreateOrderDTO $data): Order
    {
        $subTotal = $this->calculateItemsPrice($data->getItems());
        $total = $this->calculateDiscount(
            $subTotal,
            $data->getDiscountType(),
            $data->getDiscountValue()
        );

        $orderDraft = $this->repository->create([
            'customer_id'   => $data->customerId,
            'user_id'       => $data->userId,
            'sub_total'     => $subTotal,
            'discount'      => $data->getDiscountValue(),
            'discount_type' => $data->getDiscountType(),
            'total'         => $total,
            'pickup'        => $data->pickup,
        ]);

        $this->createOrderItems($data->getItems(), $orderDraft->id);
        $this->createPayment($data->getPayments(), $orderDraft->id);

        $status = $this->orderStatus($data->getPayments(), $total);
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

    public function index(array $filters, int $perPage = 15): LengthAwarePaginator
    {
        $preparedFilters = $this->prepareFilters($filters);

        return $this->repository->paginate(filters: $preparedFilters, perPage: $perPage);
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

        foreach ($payments as $payment) {
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

    private function createOrderItems(array $items, $orderId): void
    {
        $this->repository->createOrderItems($items, $orderId);
    }

    private function createPayment(array $payments, $orderId): void
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

    public function getOrderInfo(Order $order): array
    {
        return $this->repository->getOrderInfo($order)->toArray();
    }

    public function pay(Order $order, array $payments): void
    {
        foreach ($payments as $paymentData) {
            $this->paymentRepository->create([
                'order_id'     => $order->id,
                'method'       => $paymentData['method'],
                'amount'       => $paymentData['amount'],
                'installments' => $paymentData['installments'] ?? null,
            ]);
        }

        $totalPaid = $order->payments()->sum('amount');
        if ($totalPaid >= $order->total) {
            $this->repository->updateOrderStatus($order->id, 'paid');
        }
    }

    private function prepareFilters(array $filters): array
    {
        $filters['status'] = $this->filterStatus($filters['status'] ?? null);

       return $filters;
    }

    private function filterStatus(?string $status): ?string
    {
        if (is_null($status)) {
            return null;
        }

        if ($status == 0) {
            return 'cancelled';
        }

        if ($status == 1) {
            return 'pending';
        }

        if ($status == 2) {
            return 'paid';
        }

        return null;
    }

    public function cancel($order, $cancelReason): void
    {
        $this->repository->cancelOrder($order, $cancelReason);
    }
}
