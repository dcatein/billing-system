<?php

namespace App\Domains\Products\Services;

use App\Domains\Products\Repositories\Contracts\ProductRepositoryInterface;
use App\Domains\Products\Models\Product;

class ProductService
{
    public function __construct(
        protected ProductRepositoryInterface $repository
    ) {}

    public function create(array $data, int $tenantId): Product
    {
        $data['tenant_id'] = $tenantId;
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
}