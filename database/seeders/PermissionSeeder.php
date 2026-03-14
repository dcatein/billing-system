<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $roleAdmin = Role::create(['name' => 'admin']);
        $roleManager = Role::create(['name' => 'manager']);
        $roleSeller = Role::create(['name' => 'seller']);

        Permission::create(['name' => 'dashboard'])->assignRole([$roleAdmin, $roleManager]);
    }
}
