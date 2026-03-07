<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Number;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            BaseSeeder::class,
            ProductSeeder::class,
            OrdersSeeder::class,
            OrderItemSeeder::class
        ]);
    }
}
