<?php

namespace App\Domains\Products\Controllers;

use App\Http\Controllers\Controller;
use App\Domains\Products\Services\ProductService;
use Illuminate\Http\Request;

class ViewProductController extends Controller
{
    public function __construct(
        protected ProductService $service
    ) {}

    public function index()
    {
        $products = $this->service->index();

        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'sku' => 'nullable|string',
            'barcode' => 'nullable|string',
            'price' => 'required|numeric',
            'active' => 'boolean'
        ]);

        $this->service->create($data);

        return redirect()->route('products.index');
    }

    public function edit($id)
    {
        $product = $this->service->getById($id);

        return view('products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $product = $this->service->getById($id);

        $data = $request->validate([
            'name' => 'required|string',
            'sku' => 'nullable|string',
            'barcode' => 'nullable|string',
            'price' => 'required|numeric',
            'active' => 'boolean'
        ]);

        $this->service->update($product, $data);

        return redirect()->route('products.index');
    }

    public function destroy($id)
    {
        $product = $this->service->getById($id);

        $this->service->delete($product);

        return redirect()->route('products.index');
    }
}