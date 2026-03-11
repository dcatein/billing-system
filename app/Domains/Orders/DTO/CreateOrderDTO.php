<?php

namespace App\Domains\Orders\DTO;

class CreateOrderDTO
{
    public function __construct(
        public readonly array $items,
        public readonly string $discountType,
        public readonly float $discountValue,
        public readonly array $payments,
        public readonly int $userId,
        public readonly ?int $customerId = null,
    ) {}

    public function getItems(): array
    {
        return $this->items;
    }

    public function getPayments(): array
    {
        return $this->payments;
    }

    public function getDiscountType(): string
    {
        return $this->discountType;
    }

    public function getDiscountValue(): float
    {
        return $this->discountValue;
    }
}
