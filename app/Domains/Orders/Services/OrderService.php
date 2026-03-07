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
        return $this->repository->create($data);
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
}
