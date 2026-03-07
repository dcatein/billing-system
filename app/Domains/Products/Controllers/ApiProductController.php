<?php

namespace App\Domains\Products\Controllers;

use App\Http\Controllers\Controller;
use App\Domains\Products\Services\ProductService;
use App\Domains\Products\Repositories\Contracts\ProductRepositoryInterface;
use App\Domains\Products\Controllers\Requests\StoreProductRequest;
use App\Domains\Products\Controllers\Requests\UpdateProductRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

class ApiProductController extends Controller
{
    public function __construct(
        protected ProductService $service,
        protected ProductRepositoryInterface $repository
    ) {}

    public function index(): LengthAwarePaginator
    {
        return $this->service->index();
    }

    public function store(StoreProductRequest $request): JsonResponse
    {
        $product = $this->service->create(
            $request->validated()        
        );

        return new JsonResponse($product, 201);
    }

    public function update(UpdateProductRequest $request, $id)
    {
        $product = $this->service->getById($id);

        return $this->service->update(
            $product,
            $request->validated()
        );
    }

    public function destroy($id): JsonResponse
    {
        $product = $this->service->getById($id);

        $this->service->delete($product);

        return new JsonResponse(null, 204);
    }
}