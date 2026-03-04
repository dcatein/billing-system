<?php

namespace App\Domains\Products\Http;

use App\Http\Controllers\Controller;
use App\Domains\Products\Services\ProductService;
use App\Domains\Products\Repositories\Contracts\ProductRepositoryInterface;
use App\Domains\Products\Http\Requests\StoreProductRequest;
use App\Domains\Products\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    public function __construct(
        protected ProductService $service,
        protected ProductRepositoryInterface $repository
    ) {}

    public function index()
    {
        return $this->repository->paginate();
    }

    public function store(StoreProductRequest $request)
    {
        $product = $this->service->create(
            $request->validated(),
            app()->get('currentTenant')->id
        );

        return response()->json($product, 201);
    }

    public function update(UpdateProductRequest $request, $id)
    {
        $product = $this->repository->findById($id);

        return $this->service->update(
            $product,
            $request->validated()
        );
    }
}