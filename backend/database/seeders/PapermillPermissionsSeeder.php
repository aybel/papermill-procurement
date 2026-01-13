<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PapermillPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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
                Permission::firstOrCreate([
                    'name' => $resource . '.' . $action,
                    'guard_name' => 'api',
                ]);
            }
        }
    }
}
