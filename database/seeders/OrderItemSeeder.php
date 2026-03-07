<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Domains\Orders\Models\Order;
use App\Domains\Products\Models\Product;
use App\Domains\Orders\Models\OrderItem;

class OrderItemSeeder extends Seeder
{
    public function run(): void
    {
        // Busca todas as orders e products existentes
        $orders = Order::all();
        $products = Product::all();

        if ($orders->isEmpty() || $products->isEmpty()) {
            $this->command->warn('Nenhuma Order ou Product encontrada. Execute os seeders de Orders e Products primeiro.');
            return;
        }

        foreach ($orders as $order) {
            // Cada order terá entre 1 e 5 itens
            $numItems = fake()->numberBetween(1, 5);

            for ($i = 0; $i < $numItems; $i++) {
                $product = $products->random();
                $quantity = fake()->numberBetween(1, 5);
                $unitPrice = $product->price;
                $total = $unitPrice * $quantity;

                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $product->id,
                    'description'=> $product->name,
                    'quantity'   => $quantity,
                    'unit_price' => $unitPrice,
                    'total'      => $total,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
