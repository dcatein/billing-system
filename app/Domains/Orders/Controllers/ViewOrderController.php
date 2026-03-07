<?php

namespace App\Domains\Orders\Controllers;

use App\Http\Controllers\Controller;
use App\Domains\Orders\Services\OrderService;
use Illuminate\Http\Request;

class ViewOrderController extends Controller
{
    public function __construct(
        protected OrderService $service
    ) {}

    public function index()
    {
        $orders = $this->service->index();

        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        return view('orders.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'status' => 'required|string',
            'discount' => 'required|numeric',
            'notes' => 'nullable|string',
            'tenant_id' => 'required|integer',
            'customer_id' => 'required|integer',
            'user_id' => 'required|integer',
        ]);

        $this->service->create($data);

        return redirect()->route('orders.index');
    }

    public function edit($id)
    {
        $order = $this->service->getById($id);

        return view('orders.edit', compact('order'));
    }

    public function update(Request $request, $id)
    {
        $order = $this->service->getById($id);

        $data = $request->validate([
            'status' => 'required|string',
            'subtotal' => 'required|numeric',
            'discount' => 'required|numeric',
            'total' => 'required|numeric',
            'notes' => 'nullable|string',
            'tenant_id' => 'required|integer',
            'customer_id' => 'required|integer',
            'user_id' => 'required|integer',
        ]);

        $this->service->update($order, $data);

        return redirect()->route('orders.index');
    }

    public function destroy($id)
    {
        $order = $this->service->getById($id);

        $this->service->delete($order);

        return redirect()->route('orders.index');
    }
}
