<?php

namespace Database\Seeders;

use App\Domains\Orders\Models\Order;
use Illuminate\Database\Seeder;

class OrdersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 100; $i++) {
            $subtotal = fake()->randomFloat(2, 50, 500);
            $discount = fake()->randomFloat(2, 0, 50);
            $total = $subtotal - $discount;

            Order::create([
                'status' => fake()->randomElement(['pending', 'paid', 'cancelled']),
                'subtotal' => $subtotal,
                'discount' => $discount,
                'total' => $total,
                'notes' => fake()->optional()->sentence(),
                'tenant_id' => 2,
                'customer_id' => fake()->randomElement([1, 2]),
                'user_id' => fake()->randomElement([99, 88]),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
