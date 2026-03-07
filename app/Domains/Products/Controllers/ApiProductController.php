<?php

namespace App\Domains\Products\Controllers;

use App\Shared\Http\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Domains\Products\Services\ProductService;
use App\Domains\Products\Repositories\Contracts\ProductRepositoryInterface;
use App\Domains\Products\Controllers\Requests\StoreProductRequest;
use App\Domains\Products\Controllers\Requests\UpdateProductRequest;
use Illuminate\Http\JsonResponse;

class ApiProductController extends Controller
{
    use ApiResponseTrait;

    public function __construct(
        protected ProductService $service,
        protected ProductRepositoryInterface $repository
    ) {}

    public function index(): JsonResponse
    {
        $products = $this->service->index();

        return $this->success($products);
    }

    public function store(StoreProductRequest $request): JsonResponse
    {
        $product = $this->service->create(
            $request->validated()
        );

        return $this->created($product, 'Produto criado com sucesso');
    }

    public function update(UpdateProductRequest $request, int $id): JsonResponse
    {
        $product = $this->service->getById($id);

        $updated = $this->service->update(
            $product,
            $request->validated()
        );

        return $this->success($updated, 'Produto atualizado com sucesso');
    }

    public function destroy(int $id): JsonResponse
    {
        $product = $this->service->getById($id);

        $this->service->delete($product);

        return $this->noContent();
    }
}