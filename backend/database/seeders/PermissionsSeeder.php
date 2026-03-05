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
            // Material types
            'material_types.view_any',
            'material_types.view',
            'material_types.create',
            'material_types.update',
            'material_types.delete',
            // Units of measure
            'units_of_measure.view_any',
            'units_of_measure.view',
            'units_of_measure.create',
            'units_of_measure.update',
            'units_of_measure.delete',
            // Budget categories
            'budget_categories.view_any',
            'budget_categories.view',
            'budget_categories.create',
            'budget_categories.update',
            'budget_categories.delete',
            // Budget assignments
            'budget_assignments.view_any',
            'budget_assignments.view',
            'budget_assignments.create',
            'budget_assignments.update',
            'budget_assignments.delete',
            //departments
            'departments.view_any',
            'departments.view',
            'departments.create',
            'departments.update',
            'departments.delete',
            //budget-request-statuses
            'budget_request_statuses.view_any',
            'budget_request_statuses.view',
            'budget_request_statuses.create',
            'budget_request_statuses.update',
            'budget_request_statuses.delete',
            //budget-requests
            'budget_requests.view_any',
            'budget_requests.view',
            'budget_requests.create',
            'budget_requests.update',
            'budget_requests.delete',
            //budget-request-items
            'budget_request_items.view_any',
            'budget_request_items.view',
            'budget_request_items.create',
            'budget_request_items.update',
            'budget_request_items.delete',

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

        // Crear roles adicionales para el sistema ERP
        $this->createERPRoles($guardName);

        // Nota: Los usuarios se asignan en UserDepartmentSeeder para evitar duplicados
    }

    /**
     * Crear roles específicos del ERP de procurement
     */
    private function createERPRoles(string $guardName): void
    {
        // Rol: Jefe de Compras - Gestiona todo el proceso de compras
        $jefeComprasRole = Role::firstOrCreate(['name' => 'Jefe de Compras', 'guard_name' => $guardName]);
        $jefeComprasRole->syncPermissions([
            'suppliers.view_any', 'suppliers.view', 'suppliers.create', 'suppliers.update',
            'materials.view_any', 'materials.view', 'materials.create', 'materials.update',
            'budget_requests.view_any', 'budget_requests.view', 'budget_requests.create',
            'budget_requests.update', 'budget_requests.delete',
            'budget_assignments.view_any', 'budget_assignments.view',
            'departments.view_any', 'departments.view',
        ]);

        // Rol: Comprador - Ejecuta órdenes de compra
        $compradorRole = Role::firstOrCreate(['name' => 'Comprador', 'guard_name' => $guardName]);
        $compradorRole->syncPermissions([
            'suppliers.view_any', 'suppliers.view',
            'materials.view_any', 'materials.view',
            'budget_requests.view_any', 'budget_requests.view', 'budget_requests.create',
            'budget_assignments.view_any', 'budget_assignments.view',
        ]);

        // Rol: Jefe de Departamento - Gestiona su departamento
        $jefeDepartamentoRole = Role::firstOrCreate(['name' => 'Jefe de Departamento', 'guard_name' => $guardName]);
        $jefeDepartamentoRole->syncPermissions([
            'budget_requests.view_any', 'budget_requests.view', 'budget_requests.create', 'budget_requests.update',
            'budget_assignments.view_any', 'budget_assignments.view',
            'materials.view_any', 'materials.view',
            'departments.view_any', 'departments.view',
        ]);

        // Rol: Empleado - Solo lectura básica
        $empleadoRole = Role::firstOrCreate(['name' => 'Empleado', 'guard_name' => $guardName]);
        $empleadoRole->syncPermissions([
            'budget_requests.view',
            'materials.view',
        ]);

        // Rol: Operativo - Ejecuta operaciones básicas
        $operativoRole = Role::firstOrCreate(['name' => 'Operativo', 'guard_name' => $guardName]);
        $operativoRole->syncPermissions([
            'suppliers.view_any', 'suppliers.view',
            'materials.view_any', 'materials.view',
            'budget_requests.view_any', 'budget_requests.view', 'budget_requests.create',
            'budget_assignments.view_any', 'budget_assignments.view',
            'departments.view_any', 'departments.view',
        ]);

        // Rol: Aprobador - Aprueba solicitudes
        $aprobadorRole = Role::firstOrCreate(['name' => 'Aprobador', 'guard_name' => $guardName]);
        $aprobadorRole->syncPermissions([
            'budget_requests.view_any', 'budget_requests.view', 'budget_requests.update',
            'budget_assignments.view_any', 'budget_assignments.view',
            'departments.view_any', 'departments.view',
        ]);

        $this->command->info('✓ Roles del ERP creados: Jefe de Compras, Comprador, Jefe de Departamento, Empleado, Operativo, Aprobador');
    }
}
