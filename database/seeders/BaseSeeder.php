<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class BaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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

        $user = User::factory()->create([
            'id' => 66,
            'name' => 'Manager 1',
            'email' => 'manager-9@email.com',
            'password' => Hash::make('password'),
            'tenant_id' => 9,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        $user->assignRole(['manager']);

        $user = User::factory()->create([
            'id' => 55,
            'name' => 'Vendor 1',
            'email' => 'seller-9@email.com',
            'password' => Hash::make('password'),
            'tenant_id' => 9,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        $user->assignRole(['seller']);

        $user = User::factory()->create([
            'id' => 44,
            'name' => 'Admin',
            'email' => 'admin-9@email.com',
            'password' => Hash::make('password'),
            'tenant_id' => 9,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        $user->assignRole(['admin']);

        $user = User::factory()->create([
            'id' => 77,
            'name' => 'Manager 1',
            'email' => 'manager@email.com',
            'password' => Hash::make('password'),
            'tenant_id' => 2,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        $user->assignRole(['manager']);

        $user = User::factory()->create([
            'id' => 88,
            'name' => 'Vendor 1',
            'email' => 'seller@email.com',
            'password' => Hash::make('password'),
            'tenant_id' => 2,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        $user->assignRole(['seller']);

        $user = User::factory()->create([
            'id' => 99,
            'name' => 'Admin',
            'email' => 'admin@email.com',
            'password' => Hash::make('password'),
            'tenant_id' => 2,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        $user->assignRole('admin');
    }
}
