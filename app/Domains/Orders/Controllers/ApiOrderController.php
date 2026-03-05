<?php

namespace App\Domains\Orders\Controllers;

use App\Http\Controllers\Controller;
use App\Domains\Orders\Services\OrderService;
use Illuminate\Http\Request;

class ApiOrderController extends Controller
{
    public function __construct(
        protected OrderService $service
    ) {}

    public function index()
    {
        return $this->service->orders->paginate();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'tenant_id' => 'required|integer',
            'customer_id' => 'required|integer',
            'user_id' => 'required|integer',
            'discount' => 'numeric',
            'notes' => 'string|nullable',
            'items' => 'required|array',
            'items.*.product_id' => 'required|integer',
            'items.*.quantity' => 'required|integer|min:1'
        ]);

        return $this->service->create($data);
    }

    public function show(int $id)
    {
        return $this->service->orders->find($id);
    }
}