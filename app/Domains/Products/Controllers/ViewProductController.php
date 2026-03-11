<?php

namespace App\Domains\Products\Controllers;

use App\Shared\Http\Controllers\BaseWebController;
use App\Domains\Products\Services\ProductService;
use App\Domains\Products\Controllers\Requests\ViewProductControllerRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ViewProductController extends BaseWebController
{
    protected string $route = 'products';

    public function __construct(
        protected ProductService $service
    ) {}

    public function index(): View
    {
        $products = $this->service->index();

        return view('products.index', compact('products'));
    }

    public function create(): View
    {
        return view('products.create');
    }

    public function store(ViewProductControllerRequest $request): RedirectResponse
    {
        try {
            $this->service->create($request->validated());
            return $this->successStore();

        } catch (\Throwable $e) {
            return $this->error($e);
        }
    }

    public function edit(int $id): View
    {
        $product = $this->service->getById($id);

        return view('products.edit', compact('product'));
    }

    public function update(ViewProductControllerRequest $request, int $id): RedirectResponse
    {
        try {
            $product = $this->service->getById($id);

            $this->service->update($product, $request->validated());

            return $this->successUpdate();

        } catch (\Throwable $e) {
            return $this->error($e, 'edit');
        }
    }

    public function destroy(int $id): RedirectResponse
    {
        try {
            $product = $this->service->getById($id);

            $this->service->delete($product);

            return $this->successDelete();

        } catch (\Throwable $e) {
            return $this->error($e);
        }
    }
}