<?php

namespace App\Domains\Products\Controllers;

use App\Http\Controllers\Controller;
use App\Domains\Products\Services\ProductService;
use App\Domains\Products\Controllers\Requests\ViewProductControllerRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ViewProductController extends Controller
{
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
        $this->service->create($request->validated());
        
        return redirect()
            ->route('products.index')
            ->with('success', 'Produto criado com sucesso!');
    }

    public function edit(int $id): View
    {
        $product = $this->service->getById($id);
        return view('products.edit', compact('product'));
    }

    public function update(ViewProductControllerRequest $request, int $id): RedirectResponse
    {
        $product = $this->service->getById($id);
        
        $this->service->update($product, $request->validated());

        return redirect()
            ->route('products.index')
            ->with('success', 'Produto atualizado com sucesso!');
    }

    public function destroy(int $id): RedirectResponse
    {
        $product = $this->service->getById($id);
        $this->service->delete($product);

        return redirect()
            ->route('products.index')
            ->with('success', 'Produto excluído com sucesso!');
    }
}