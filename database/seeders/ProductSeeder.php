<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        $this->seedTenantProducts($faker, 2, 100);
        $this->seedTenantProducts($faker, 9, 100);
    }

    private function seedTenantProducts($faker, int $tenantId, int $count): void
    {
        $products = [];

        for ($i = 0; $i < $count; $i++) {
            $products[] = [
                'tenant_id' => $tenantId,
                'category_id' => null,
                'name' => $faker->words(3, true),
                'sku' => strtoupper($faker->bothify('SKU-####')),
                'barcode' => $faker->ean13(),
                'price' => $faker->randomFloat(2, 5, 500),
                'active' => $faker->boolean(90),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('products')->insert($products);
    }
}