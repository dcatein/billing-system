<?php

namespace App\Domains\Products\Repositories;

use App\Domains\Products\Models\Product;
use App\Domains\Products\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EloquentProductRepository implements ProductRepositoryInterface
{
    public function paginate(int $tenantId, int $perPage = 15): LengthAwarePaginator
    {
        return Product::query()
            ->where('tenant_id', '=', $tenantId)
            ->where('active', '=', true)
            ->paginate($perPage);
    }

    public function findById(int $id): ?Product
    {
        return Product::find($id);
    }

    public function create(array $data): Product
    {
        return Product::create($data);
    }

    public function update(Product $product, array $data): Product
    {
        $product->update($data);
        return $product;
    }
}