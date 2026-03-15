<?php

namespace App\Domains\Products\Services;

use App\Domains\Products\Repositories\Contracts\ProductRepositoryInterface;
use App\Domains\Products\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Domains\Products\Exceptions\ProductNotFoundException;
use Illuminate\Validation\ValidationException;


class ProductService
{
    public function __construct(
        protected ProductRepositoryInterface $repository
    ) {}

    public function create(array $data): Product
    {
    return $this->repository->create($data);
    }

    public function update(Product $product, array $data): Product
    {
        if ($product->sku !== null && blank($data['sku'] ?? null)) {
            throw ValidationException::withMessages([
            'sku' => 'O SKU é obrigatório pois já foi definido anteriormente.'
            ]);
        }

    return $this->repository->update($product, $data);
    }      

    public function deactivate(Product $product): Product
    {
        return $this->repository->update($product, [
            'active' => false
        ]);
    }

    public function index(array $filters, int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository->paginate($filters, $perPage);
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
