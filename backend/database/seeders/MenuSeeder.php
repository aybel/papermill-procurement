<?php

namespace Database\Seeders;

use App\Models\MenuItem;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        // Mapeo de permisos existentes
        $permissions = Permission::all()->keyBy('name');

        $permissionId = function ($names) use ($permissions): ?int {
            foreach ((array) $names as $name) {
                $permission = $permissions->get($name);
                if ($permission) {
                    return $permission->id;
                }
            }

            return null;
        };

        // Permite ejecutar el seeder varias veces sin colisiones por semantic_key
        MenuItem::query()->delete();

        // 1. Header principal
        MenuItem::create([
            'semantic_key' => 'header.main',
            'display_name' => 'Principal',
            'semantic_type' => 'header',
            'order' => 1,
        ]);

        // 2. Dashboard
        MenuItem::create([
            'semantic_key' => 'module.dashboard',
            'display_name' => 'Dashboard',
            'route_name' => 'dashboard',
            'semantic_icon' => 'dashboard',
            'semantic_type' => 'module',
            'permission_id' => $permissionId('dashboard.view'),
            'order' => 2,
        ]);

        // 3. Header Proveedores////////////////////////////////////////////////////////
        MenuItem::create([
            'semantic_key' => 'header.suppliers',
            'display_name' => 'Gestión de Proveedores',
            'semantic_type' => 'header',
            'order' => 10,
        ]);

        // 4. Modulo Proveedores////////////////////////////////////////////////////////
        $suppliersModule = MenuItem::create([
            'semantic_key' => 'module.suppliers.management',
            'display_name' => 'Proveedores',
            'route_name' => 'suppliers',
            'semantic_icon' => 'supplier',
            'semantic_type' => 'module',
            'permission_id' => $permissionId(['suppliers.view_any', 'supplier.view_any']),
            'order' => 11,
        ]);

        // 5. Submodulos Proveedores
        MenuItem::create([
            'parent_id' => $suppliersModule->id,
            'semantic_key' => 'module.suppliers',
            'display_name' => 'Lista de Proveedores',
            'route_name' => 'suppliers',
            'semantic_icon' => 'contact',
            'semantic_type' => 'link',
            'permission_id' => $permissionId('supplier_contacts.view_any'),
            'order' => 1,
        ]);

        // 5. Submodulos Proveedores
        MenuItem::create([
            'parent_id' => $suppliersModule->id,
            'semantic_key' => 'module.suppliers.contacts',
            'display_name' => 'Contactos',
            'route_name' => 'supplier-contacts',
            'semantic_icon' => 'contact',
            'semantic_type' => 'link',
            'permission_id' => $permissionId('supplier_contacts.view_any'),
            'order' => 2,
        ]);

        MenuItem::create([
            'parent_id' => $suppliersModule->id,
            'semantic_key' => 'module.suppliers.performance',
            'display_name' => 'Desempeño',
            'route_name' => 'supplier-performance',
            'semantic_icon' => 'chart',
            'semantic_type' => 'link',
            'permission_id' => $permissionId('supplier_performance.view_any'),
            'order' => 3,
        ]);

        // 3. Header Materiales///////////////////////////////////////////////////////
        MenuItem::create([
            'semantic_key' => 'header.materials',
            'display_name' => 'Gestión de Materiales',
            'semantic_type' => 'header',
            'order' => 12,
        ]);

        // 6. Modulo Materiales////////////////////////////////////////////////////////
        $materialsModule = MenuItem::create([
            'semantic_key' => 'module.materials.management',
            'display_name' => 'Materiales',
            'route_name' => '#',
            'semantic_icon' => 'materials',
            'semantic_type' => 'module',
            'permission_id' => $permissionId('materials.view_any'),
            'order' => 13,
        ]);

        MenuItem::create([
            'parent_id' => $materialsModule->id,
            'semantic_key' => 'module.materials',
            'display_name' => 'Lista de Materiales',
            'route_name' => 'materials',
            'semantic_icon' => 'list',
            'semantic_type' => 'link',
            'permission_id' => $permissionId('materials.view_any'),
            'order' => 1,
        ]);

        // 3. Header Presupuestos///////////////////////////////////////////////////////
        MenuItem::create([
            'semantic_key' => 'header.budget',
            'display_name' => 'Gestión de Presupuestos',
            'semantic_type' => 'header',
            'order' => 14,
        ]);

        $budgetModule = MenuItem::create([
            'semantic_key' => 'module.budget.management',
            'display_name' => 'Presupuesto',
            'route_name' => '#',
            'semantic_icon' => 'budget',
            'semantic_type' => 'module',
            'permission_id' => $permissionId([
                'budget_categories.view_any',
                'budget_assignments.view_any',
                'budget_requests.view_any',
                'budget-my_budget.view_any',
                'budget-my-budget.view_any',
            ]),
            'order' => 15,
        ]);

        MenuItem::create([
            'parent_id' => $budgetModule->id,
            'semantic_key' => 'module.budget.categories',
            'display_name' => 'Rubros',
            'route_name' => 'budget-categories',
            'semantic_icon' => 'list',
            'semantic_type' => 'link',
            'permission_id' => $permissionId('budget_categories.view_any'),
            'order' => 2,
        ]);

        MenuItem::create([
            'parent_id' => $budgetModule->id,
            'semantic_key' => 'module.budget.assignments',
            'display_name' => 'Asignación',
            'route_name' => 'budget-assignments',
            'semantic_icon' => 'list',
            'semantic_type' => 'link',
            'permission_id' => $permissionId('budget_assignments.view_any'),
            'order' => 3,
        ]);

        MenuItem::create([
            'parent_id' => $budgetModule->id,
            'semantic_key' => 'module.budget.requests',
            'display_name' => 'Solicitudes de calendarización',
            'route_name' => 'budget-requests',
            'semantic_icon' => 'calendar',
            'semantic_type' => 'link',
            'permission_id' => $permissionId('budget_requests.view_any'),
            'order' => 4,
        ]);

        MenuItem::create([
            'parent_id' => $budgetModule->id,
            'semantic_key' => 'module.budget.my_budget',
            'display_name' => 'Mi presupuesto',
            'route_name' => 'budget-requests',
            'semantic_icon' => 'calendar',
            'semantic_type' => 'link',
            'permission_id' => $permissionId(['budget-my_budget.view_any', 'budget-my-budget.view_any']),
            'order' => 5,
        ]);

        // 8. Header Configuración////////////////////////////////////////////////////////////////////////////////////
        MenuItem::create([
            'semantic_key' => 'header.config',
            'display_name' => 'Configuración',
            'semantic_type' => 'header',
            'order' => 40,
        ]);

        // 9. Modulo Configuración
        $configModule = MenuItem::create([
            'semantic_key' => 'module.config',
            'display_name' => 'Configuración',
            'route_name' => '#',
            'semantic_icon' => 'settings',
            'semantic_type' => 'module',
            'permission_id' => $permissionId([
                'currencies.view_any',
                'payment_terms.view_any',
                'supplier_types.view_any',
                'material_categories.view_any',
                'material_types.view_any',
                'units_of_measure.view_any',
                'departments.view_any',
            ]),
            'order' => 41,
        ]);

        MenuItem::create([
            'parent_id' => $configModule->id,
            'semantic_key' => 'module.config.currencies',
            'display_name' => 'Monedas',
            'route_name' => 'currencies',
            'semantic_icon' => 'currency',
            'semantic_type' => 'link',
            'permission_id' => $permissionId('currencies.view_any'),
            'order' => 1,
        ]);

        MenuItem::create([
            'parent_id' => $configModule->id,
            'semantic_key' => 'module.config.payment_terms',
            'display_name' => 'Términos de pago',
            'route_name' => 'payment-terms',
            'semantic_icon' => 'payment',
            'semantic_type' => 'link',
            'permission_id' => $permissionId('payment_terms.view_any'),
            'order' => 2,
        ]);

        MenuItem::create([
            'parent_id' => $configModule->id,
            'semantic_key' => 'module.config.supplier_types',
            'display_name' => 'Tipos de proveedores',
            'route_name' => 'supplier-types',
            'semantic_icon' => 'supplier-type',
            'semantic_type' => 'link',
            'permission_id' => $permissionId('supplier_types.view_any'),
            'order' => 3,
        ]);

        MenuItem::create([
            'parent_id' => $configModule->id,
            'semantic_key' => 'module.config.material_categories',
            'display_name' => 'Categoría de materiales',
            'route_name' => 'material-categories',
            'semantic_icon' => 'material-categories',
            'semantic_type' => 'link',
            'permission_id' => $permissionId('material_categories.view_any'),
            'order' => 4,
        ]);

        MenuItem::create([
            'parent_id' => $configModule->id,
            'semantic_key' => 'module.config.material_types',
            'display_name' => 'Tipos de materiales',
            'route_name' => 'material-types',
            'semantic_icon' => 'material-types',
            'semantic_type' => 'link',
            'permission_id' => $permissionId('material_types.view_any'),
            'order' => 5,
        ]);

        MenuItem::create([
            'parent_id' => $configModule->id,
            'semantic_key' => 'module.config.units_of_measure',
            'display_name' => 'Unidades de medida',
            'route_name' => 'units-of-measure',
            'semantic_icon' => 'unit',
            'semantic_type' => 'link',
            'permission_id' => $permissionId('units_of_measure.view_any'),
            'order' => 6,
        ]);

        MenuItem::create([
            'parent_id' => $configModule->id,
            'semantic_key' => 'module.config.departments',
            'display_name' => 'Departamentos',
            'route_name' => 'departments',
            'semantic_icon' => 'department',
            'semantic_type' => 'link',
            'permission_id' => $permissionId('departments.view_any'),
            'order' => 7,
        ]);

        // 10. Header Administración ////////////////////////////////////////////////////////////////////////////////////
        MenuItem::create([
            'semantic_key' => 'header.administration',
            'display_name' => 'Administración',
            'semantic_type' => 'header',
            'order' => 42,
        ]);

        // 11. Modulo Usuarios
        $usersModule = MenuItem::create([
            'semantic_key' => 'module.users',
            'display_name' => 'Usuarios',
            'route_name' => '#',
            'semantic_icon' => 'users',
            'semantic_type' => 'module',
            'permission_id' => $permissionId('users.view_any'),
            'order' => 43,
        ]);

        MenuItem::create([
            'parent_id' => $usersModule->id,
            'semantic_key' => 'module.users.manage',
            'display_name' => 'Lista  de Usuarios',
            'route_name' => 'users',
            'semantic_icon' => 'user',
            'semantic_type' => 'link',
            'permission_id' => $permissionId('users.view_any'),
            'order' => 1,
        ]);

        // 12. Modulo Roles
        $rolesModule = MenuItem::create([
            'semantic_key' => 'module.roles',
            'display_name' => 'Roles',
            'route_name' => '#',
            'semantic_icon' => 'shield',
            'semantic_type' => 'module',
            'permission_id' => $permissionId('roles.view_any'),
            'order' => 44,
        ]);

        MenuItem::create([
            'parent_id' => $rolesModule->id,
            'semantic_key' => 'module.roles.manage',
            'display_name' => 'Lista de Roles',
            'route_name' => 'roles',
            'semantic_icon' => 'shield',
            'semantic_type' => 'link',
            'permission_id' => $permissionId('roles.view_any'),
            'order' => 1,
        ]);

        // 13. Modulo Permisos
        $permissionsModule = MenuItem::create([
            'semantic_key' => 'module.permissions',
            'display_name' => 'Permisos',
            'route_name' => '#',
            'semantic_icon' => 'key',
            'semantic_type' => 'module',
            'permission_id' => $permissionId('permissions.view_any'),
            'order' => 45,
        ]);

        MenuItem::create([
            'parent_id' => $permissionsModule->id,
            'semantic_key' => 'module.permissions.manage',
            'display_name' => 'Lista de Permisos',
            'route_name' => 'permissions',
            'semantic_icon' => 'key',
            'semantic_type' => 'link',
            'permission_id' => $permissionId('permissions.view_any'),
            'order' => 1,
        ]);
    }
}
