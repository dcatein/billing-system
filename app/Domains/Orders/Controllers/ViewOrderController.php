<?php

namespace App\Domains\Orders\Controllers;

use App\Domains\Orders\Controllers\Requests\StoreOrderRequest;
use App\Domains\Orders\Services\OrderService;
use App\Domains\Products\Services\ProductService;
use App\Domains\Users\Services\UsersService;
use App\Shared\Http\Controllers\BaseWebController;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Domains\Orders\DTO\CreateOrderDTO;
use App\Domains\Orders\Models\Order;
use PhpOffice\PhpSpreadsheet\Exception;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ViewOrderController extends BaseWebController
{
    protected string $route = 'orders';

    public function __construct(
        protected OrderService $service,
        protected ProductService $productService,
        protected UsersService $usersService
    ) {}

    public function index(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'nullable|string',
            'status' => 'nullable|in:0,1,2',
            'created_at_start' => 'nullable|string',
            'created_at_end' => 'nullable|string',
            'sort_by' => 'nullable|in:status,user_id,pickup,subtotal,total,discount,created_at',
            'sort_direction' => 'nullable|in:asc,desc',
            'per_page' => 'nullable|integer|in:10,25,50',
            'page' => 'nullable|integer|min:1',
        ]);
        $perPage = $validated['per_page'] ?? 15;

        $orders = $this->service->index($validated, $perPage);

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

    public function store(StoreOrderRequest $request): RedirectResponse
    {
        try {
            $validated = $request->validated();

            $orderData = new CreateOrderDTO(
                items: $validated['items'],
                discountType: $validated['discount_type'],
                discountValue: (float) $validated['discount_value'],
                payments: $validated['payments'] ?? [],
                userId: (int) $validated['user_id'],
                pickup: $validated['pickup']
            );
            $this->service->create($orderData);

            return $this->success(message: '', targetRoute: 'index');
        } catch (\Throwable $e) {
            $this->error($e);
        }
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

    public function cancel(Request $request, $orderId): RedirectResponse
    {
        $validated = $request->validate(['cancel_reason' => 'required|string']);

        $this->service->cancel($orderId, $validated['cancel_reason']);

        return redirect()->route('orders.index');
    }

    /**
     * @throws Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function export(Request $request): BinaryFileResponse
    {
        $filters = $request->only(['user_id','status','created_at_start','created_at_end']);
        return $this->service->export($filters);
    }

}
