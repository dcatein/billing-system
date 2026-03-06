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
        $userId = 99;
        $tenantId = 2;

        DB::table('tenants')->insert([
            'id' => $tenantId,
            'name' => 'Empresa Demo',
            'slug' => 'empresa-demo',
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

        
    }
}