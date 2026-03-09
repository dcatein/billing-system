<?php

namespace App\Domains\Products\Services;

use App\Domains\Products\Repositories\Contracts\ProductRepositoryInterface;
use App\Domains\Products\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Domains\Products\Exceptions\ProductNotFoundException;


class ProductService
{
    public function __construct(
        protected ProductRepositoryInterface $repository
    ) {}

    public function create(array $data): Product
    {
        $data['tenant_id'] = 2;
        $data['active'] = true;

    return $this->repository->create($data);
    }

    public function update(Product $product, array $data): Product
    {
        return $this->repository->update($product, $data);
    }

    public function deactivate(Product $product): Product
    {
        return $this->repository->update($product, [
            'active' => false
        ]);
    }

    public function index(int $perPage = 15): LengthAwarePaginator 
    {
        return $this->repository->paginate(perPage: $perPage);
    }

    public function getById(int $id) : Product 
    {
        $product = $this->repository->findById($id);

        if (!$product) {
            throw new ProductNotFoundException();
        }

        return $product;
    }

    public function delete(Product $product): void
    {
        $this->repository->delete($product);
    }
}