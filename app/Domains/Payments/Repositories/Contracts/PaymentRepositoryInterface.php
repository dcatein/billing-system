<?php

namespace App\Domains\Payments\Repositories\Contracts;

use App\Domains\Payments\Models\Payment;
interface PaymentRepositoryInterface
{
    public function create(array $data): Payment;
}
