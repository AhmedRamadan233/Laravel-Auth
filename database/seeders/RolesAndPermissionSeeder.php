<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'message create',
            'message edit',
            'message delete',
            'message view',
        ];

        // Create permissions
        foreach ($permissions as $permissionName) {
            Permission::create(['name' => $permissionName, 'guard_name' => 'web']);
        }

        // Create role and assign permissions
        $role = Role::firstOrCreate(['name' => 'super admin', 'guard_name' => 'web']);
        $permissions = Permission::whereIn('name', $permissions)->get();
        $role->syncPermissions($permissions);
    }
}
