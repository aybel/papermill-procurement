<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Permission;

class AssignPapermillPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cambia el ID por el del usuario que desees
        $user = User::find(1);
        if ($user) {
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
                        $user->givePermissionTo($permission);
                    }
                }
            }
        }
    }
}
