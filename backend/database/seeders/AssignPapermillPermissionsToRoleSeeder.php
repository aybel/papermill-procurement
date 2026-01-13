<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AssignPapermillPermissionsToRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cambia el ID o nombre por el del rol que desees
        $role = Role::find(1); // O Role::where('name', 'admin')->first();
        if ($role) {
            $resources = [
                'currencies',
                'payment_terms',
                'supplier_contacts',
                'supplier_statuses',
                'supplier_types',
            ];
            $actions = [
                'view_any',
                'view',
                'create',
                'update',
                'delete',
            ];
            foreach ($resources as $resource) {
                foreach ($actions as $action) {
                    $permissionName = $resource . '.' . $action;
                    $permission = Permission::where('name', $permissionName)->first();
                    if ($permission) {
                        $role->givePermissionTo($permission);
                    }
                }
            }
        }
    }
}
