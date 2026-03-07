<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Number;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class BaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userId = 99;
        $tenantId = 2;

        DB::table('tenants')->insert([
            'id' => $tenantId,
            'name' => 'Empresa Demo',
            'slug' => 'empresa-demo',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('tenants')->insert([
            'id' => 9,
            'name' => 'Empresa ID 9',
            'slug' => 'empresa ID 9',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('users')->insert([
            'id' => $userId,
            'name' => 'Admin',
            'email' => 'admin@email.com',
            'password' => Hash::make('password'),
            'tenant_id' => $tenantId,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('users')->insert([
            'id' => 88,
            'name' => 'Admin',
            'email' => 'admin88@email.com',
            'password' => Hash::make('password'),
            'tenant_id' => $tenantId,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('users')->insert([
            'id' => 77,
            'name' => 'Admin',
            'email' => 'admin77@email.com',
            'password' => Hash::make('password'),
            'tenant_id' => 9,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('customers')->insert([
            'id' => 1,
            'tenant_id' => 2,
            'name' => 'Customer 1 Tenant 2',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('customers')->insert([
            'id' => 2,
            'tenant_id' => 2,
            'name' => 'Customer 2 Tenant 2',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
