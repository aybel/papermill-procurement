<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use App\Models\User;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $guardName = 'api';

        // create permissions
        $permissions = [
            // Suppliers
            'suppliers.view_any',
            'suppliers.view',
            'suppliers.create',
            'suppliers.update',
            'suppliers.delete',
            'suppliers.restore',
            'suppliers.update_scores',
            // Supplier types
            'supplier_types.view_any',
            'supplier_types.view',
            'supplier_types.create',
            'supplier_types.update',
            'supplier_types.delete',
            // Supplier statuses
            'supplier_statuses.view_any',
            'supplier_statuses.view',
            'supplier_statuses.create',
            'supplier_statuses.update',
            'supplier_statuses.delete',
            // Currencies
            'currencies.view_any',
            'currencies.view',
            'currencies.create',
            'currencies.update',
            'currencies.delete',
            // Payment terms
            'payment_terms.view_any',
            'payment_terms.view',
            'payment_terms.create',
            'payment_terms.update',
            'payment_terms.delete',
            // Supplier contacts
            'supplier_contacts.view_any',
            'supplier_contacts.view',
            'supplier_contacts.create',
            'supplier_contacts.update',
            'supplier_contacts.delete',
            // Roles & Permissions
            'roles.manage',
            'permissions.view',
            // Users
            'users.manage',
            // Materials
            'materials.view_any',
            'materials.view',
            'materials.create',
            'materials.update',
            'materials.delete',
            // Material categories
            'material_categories.view_any',
            'material_categories.view',
            'material_categories.create',
            'material_categories.update',
            'material_categories.delete',
        ];

        foreach ($permissions as $permission) {
            // Use firstOrCreate to avoid errors on re-seeding
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => $guardName]);
        }

        // create a role and assign existing permissions
        $superAdminRole = Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => $guardName]);

        // Get all permissions for the 'api' guard and assign them
        $apiPermissions = Permission::where('guard_name', $guardName)->get();
        $superAdminRole->syncPermissions($apiPermissions);

        // create a demo user if it doesn't exist
        $user = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('password'), // Set a default password
            ]
        );

        $user->assignRole($superAdminRole);
    }
}
