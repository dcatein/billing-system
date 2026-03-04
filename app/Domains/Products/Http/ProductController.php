<?php

namespace App\Domains\Products\Http;

use App\Http\Controllers\Controller;
use App\Domains\Products\Services\ProductService;
use App\Domains\Products\Repositories\Contracts\ProductRepositoryInterface;
use App\Domains\Products\Http\Requests\StoreProductRequest;
use App\Domains\Products\Http\Requests\UpdateProductRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductController extends Controller
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
}