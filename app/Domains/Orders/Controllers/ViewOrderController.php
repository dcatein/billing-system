<?php

namespace App\Domains\Orders\Controllers;

use App\Domains\Orders\Controllers\Requests\StoreOrderRequest;
use App\Http\Controllers\Controller;
use App\Domains\Orders\Services\OrderService;
use App\Domains\Products\Services\ProductService;
use App\Domains\Users\Services\UsersService;
use Illuminate\Http\Request;
use App\Domains\Orders\DTO\CreateOrderDTO;

class ViewOrderController extends Controller
{
    public function __construct(
        protected OrderService $service,
        protected ProductService $productService,
        protected UsersService $usersService
    ) {}

    public function index()
    {
        $orders = $this->service->index();

        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $products = $this->productService->index(1000);
        $users = $this->usersService->all();

        $data = ['products' => $products, 'users' => $users];
        return view('orders.create', $data);
    }

    public function store(StoreOrderRequest $request)
    {
        $validated = $request->validated();

        $orderData = new CreateOrderDTO(
            items: $validated['items'],
            discountType: $validated['discount_type'],
            discountValue: (float) $validated['discount_value'],
            payments: $validated['payments'] ?? [],
            userId: (int) $validated['user_id']
        );
        $this->service->create($orderData);

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
