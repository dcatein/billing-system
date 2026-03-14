<?php

namespace App\Domains\Payments\Repositories;

use App\Domains\Payments\Models\Payment;
use App\Domains\Payments\Repositories\Contracts\PaymentRepositoryInterface;

class EloquentPaymentRepository implements PaymentRepositoryInterface
{
    public function create(array $data): Payment
    {
        return Payment::create($data);
    }
}
