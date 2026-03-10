<?php

namespace App\Domains\Products\Repositories;

use App\Domains\Products\Models\Product;
use App\Domains\Products\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EloquentProductRepository implements ProductRepositoryInterface
{

    public function paginate(array $filters, int $perPage = 15): LengthAwarePaginator
{
    $query = Product::query();

    if (!empty($filters['search'])) {
        $query->where(function($q) use ($filters) {
            $q->where('name', 'like', '%' . $filters['search'] . '%')
              ->orWhere('sku', 'like', '%' . $filters['search'] . '%');
        });
    }

    if (isset($filters['status']) && $filters['status'] !== '') {
        $query->where('active', $filters['status']);
    }

    if (!empty($filters['sort'])) {
        $query->orderBy(
            $filters['sort'],
            $filters['direction'] ?? 'asc'
        );
    }

    return $query->paginate($perPage)->withQueryString();
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

    public function delete(Product $product): void
    {
        $product->delete();
    }
}