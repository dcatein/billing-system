<?php

namespace App\Domains\Orders\Controllers;

use App\Domains\Orders\Controllers\Requests\StoreOrderRequest;
use App\Http\Controllers\Controller;
use App\Domains\Orders\Services\OrderService;
use App\Domains\Products\Services\ProductService;
use App\Domains\Users\Services\UsersService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Domains\Orders\DTO\CreateOrderDTO;
use App\Domains\Orders\Models\Order;
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
        $filters = ['per_page' => 1000];

        $products = $this->productService->index($filters);
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

    public function edit(Order $order, Request $request)
    {
        $fullOrder = $this->service->getOrderInfo($order);
        return view('orders.edit', compact('fullOrder'));
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

    public function pay(Request $request, $orderId): RedirectResponse
    {
        $validated = $request->validate([
            'payments' => 'required|array',
            'payments.*.method' => 'required|string',
            'payments.*.amount' => 'required|numeric|min:0.01',
            'payments.*.installments' => 'nullable|integer|min:1',
        ]);

        $order = Order::findOrFail($orderId);

        $this->service->pay($order, $validated['payments']);

        return redirect()->route('orders.index', [
            'order' => $order->id,
            'action' => 'pay'
        ])->with('success', 'Pagamento registrado com sucesso!');
    }
}
