<?php

namespace Database\Seeders;

use App\Models\MenuItem;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run()
    {
        // Mapeo de permisos existentes
        $permissions = Permission::all()->keyBy('name');

        // 1. Headers principales
        $headerPrincipal = MenuItem::create([
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
            'permission_id' => $permissions['dashboard.view']->id ?? null,
            'order' => 2,
        ]);

        // 3. Header Proveedores
        $headerProveedores = MenuItem::create([
            'semantic_key' => 'header.suppliers',
            'display_name' => 'Gestión de Proveedores',
            'semantic_type' => 'header',
            'order' => 10,
        ]);

        // 4. Módulo Proveedores
        $suppliersModule = MenuItem::create([
            'parent_id' => $headerProveedores->id,
            'semantic_key' => 'module.suppliers',
            'display_name' => 'Proveedores',
            'route_name' => 'suppliers.index',
            'semantic_icon' => 'supplier',
            'semantic_type' => 'link',
            'permission_id' => $permissions['suppliers.view_any']->id ?? null,
            'order' => 11,
        ]);

        // 5. Submódulos de Proveedores
        MenuItem::create([
            'parent_id' => $suppliersModule->id,
            'semantic_key' => 'module.suppliers.contacts',
            'display_name' => 'Contactos',
            'route_name' => 'supplier-contacts.index',
            'semantic_icon' => 'contact',
            'semantic_type' => 'link',
            'permission_id' => $permissions['supplier_contacts.view_any']->id ?? null,
            'order' => 1,
        ]);

        MenuItem::create([
            'parent_id' => $suppliersModule->id,
            'semantic_key' => 'module.suppliers.performance',
            'display_name' => 'Desempeño',
            'route_name' => 'supplier-performance.index',
            'semantic_icon' => 'chart',
            'semantic_type' => 'link',
            'permission_id' => $permissions['supplier_performance.view_any']->id ?? null,
            'order' => 2,
        ]);

        // Materiales////////////////////////////////////////////////////////////////////////////////////////////
        $Materials = MenuItem::create([
            'semantic_key' => 'module.materials',
            'display_name' => 'Gestión de Materiales',
            'route_name' => '#',
            'semantic_icon' => 'budget',
            'semantic_type' => 'module',
            'permission_id' => $permissions['materials.view_any']->id ?? null,
            'order' => 12,
        ]);
        // Submódulo de Materiales
        MenuItem::create([
            'parent_id' => $Materials->id,
            'semantic_key' => 'module.materials.view_any',
            'display_name' => 'Materiales',
            'route_name' => 'materials.index',
            'semantic_icon' => 'list',
            'semantic_type' => 'link',
            'permission_id' => $permissions['materials.view_any']->id ?? null,
            'order' => 1,
        ]);
        // Fin Materiales///////////////////////////////////////////////////////////////////////////////////////////

        //Gestión de presupuestos///////////////////////////////////////////////////////////////////////////////////

        $Presupuestos = MenuItem::create([
            'semantic_key' => 'module.budget',
            'display_name' => 'Gestión de Presupuestos',
            'route_name' => '#',
            'semantic_icon' => 'budget',
            'semantic_type' => 'module',
            'permission_id' => ($permissions['budget_categories.view_any']->id ?? null) || ($permissions['budget_assignments.view_any']->id ?? null) || ($permissions['budget_requests.view_any']->id ?? null),
            'order' => 13,
        ]);
        // Submódulo de presupuestos
        MenuItem::create([
            'parent_id' => $Presupuestos->id,
            'semantic_key' => 'module.budget_categories.view_any',
            'display_name' => 'Rubros',
            'route_name' => 'budget-categories.index',
            'semantic_icon' => 'list',
            'semantic_type' => 'link',
            'permission_id' => $permissions['budget_categories.view_any']->id ?? null,
            'order' => 1,
        ]);
        //submodulos Asignación de presupuestos
        MenuItem::create([
            'parent_id' => $Presupuestos->id,
            'semantic_key' => 'module.budget_assignments.view_any',
            'display_name' => 'Asignación',
            'route_name' => 'budget-assignments.index',
            'semantic_icon' => 'list',
            'semantic_type' => 'link',
            'permission_id' => $permissions['budget_assignments.view_any']->id ?? null,
            'order' => 2,
        ]);
        //Submodulo de calendarización
        MenuItem::create([
            'parent_id' => $Presupuestos->id,
            'semantic_key' => 'module.budget_requests.view_any',
            'display_name' => 'Solicitudes de calendarización',
            'route_name' => 'budget-requests.index',
            'semantic_icon' => 'calendar',
            'semantic_type' => 'link',
            'permission_id' => $permissions['budget_requests.view_any']->id ?? null,
            'order' => 3,
        ]);
        //Submodulo de mi presupuesto
        MenuItem::create([
            'parent_id' => $Presupuestos->id,
            'semantic_key' => 'module.budget-my-budget.view_any',
            'display_name' => 'Mi presupuesto',
            'route_name' => 'budget-requests.index',
            'semantic_icon' => 'calendar',
            'semantic_type' => 'link',
            'permission_id' => $permissions['budget-my-budget.view_any']->id ?? null,
            'order' => 4,
        ]);
        //Termina Gestión de presupuestos////////////////////////////////////////////////////////////////////////////////

        //Gestión de catalogos/////////////////////////////////////////////////////////////////////////////////////////////
        $Catalogos = MenuItem::create([
            'semantic_key' => 'module.catalogs',
            'display_name' => 'Gestión de Catálogos',
            'route_name' => '#',
            'semantic_icon' => 'catalogs',
            'semantic_type' => 'module',
            'permission_id' => ($permissions['currencies.view_any']->id ?? null) || ($permissions['payment_terms.view_any']->id ?? null),
            'order' => 14,
        ]);

        //Monedas
        MenuItem::create([
            'parent_id' => $Catalogos->id,
            'semantic_key' => 'module.catalogs.currencies',
            'display_name' => 'Monedas',
            'route_name' => 'currencies.index',
            'semantic_icon' => 'currency',
            'semantic_type' => 'link',
            'permission_id' => $permissions['currencies.view_any']->id ?? null,
            'order' => 1,
        ]);

        //Terminos de pago
        MenuItem::create([
            'parent_id' => $Catalogos->id,
            'semantic_key' => 'module.catalogs.payment_terms',
            'display_name' => 'Términos de pago',
            'route_name' => 'payment-terms.index',
            'semantic_icon' => 'payment',
            'semantic_type' => 'link',
            'permission_id' => $permissions['payment_terms.view_any']->id ?? null,
            'order' => 2,
        ]);
        //Tipos de proveedores
        MenuItem::create([
            'parent_id' => $Catalogos->id,
            'semantic_key' => 'module.catalogs.supplier_types',
            'display_name' => 'Tipos de proveedores',
            'route_name' => 'supplier-types.index',
            'semantic_icon' => 'supplier-type',
            'semantic_type' => 'link',
            'permission_id' => $permissions['supplier_types.view_any']->id ?? null,
            'order' => 3,
        ]);
        //Categoria de materiales
        MenuItem::create([
            'parent_id' => $Catalogos->id,
            'semantic_key' => 'module.catalogs.material_categories',
            'display_name' => 'Categoría de materiales',
            'route_name' => 'material-categories.index',
            'semantic_icon' => 'material-category',
            'semantic_type' => 'link',
            'permission_id' => $permissions['material_categories.view_any']->id ?? null,
            'order' => 4,
        ]);
        //Tipos de materiales
        MenuItem::create([
            'parent_id' => $Catalogos->id,
            'semantic_key' => 'module.catalogs.material_types',
            'display_name' => 'Tipos de materiales',
            'route_name' => 'material-types.index',
            'semantic_icon' => 'material-type',
            'semantic_type' => 'link',
            'permission_id' => $permissions['material_types.view_any']->id ?? null,
            'order' => 5,
        ]);
        //Unidad de medida
        MenuItem::create([
            'parent_id' => $Catalogos->id,
            'semantic_key' => 'module.catalogs.units_of_measure',
            'display_name' => 'Unidades de medida',
            'route_name' => 'units_of_measure.index',
            'semantic_icon' => 'unit',
            'semantic_type' => 'link',
            'permission_id' => $permissions['units_of_measure.view_any']->id ?? null,
            'order' => 6,
        ]);
        //Departamentos
        MenuItem::create([
            'parent_id' => $Catalogos->id,
            'semantic_key' => 'module.catalogs.departments',
            'display_name' => 'Departamentos',
            'route_name' => 'departments.index',
            'semantic_icon' => 'department',
            'semantic_type' => 'link',
            'permission_id' => $permissions['departments.view_any']->id ?? null,
            'order' => 7,
        ]);

        //Gestion de usuarios////////////////////////////////////////////////////////////////////////////////////////////
        $Usuarios = MenuItem::create([
            'semantic_key' => 'module.users',
            'display_name' => 'Gestión de Usuarios',
            'route_name' => '#',
            'semantic_icon' => 'users',
            'semantic_type' => 'module',
            'permission_id' => ($permissions['users.view_any']->id) ?? null,
            'order' => 15,
        ]);
        MenuItem::create([
            'parent_id' => $Usuarios->id,
            'semantic_key' => 'module.users.manage',
            'display_name' => 'Usuarios',
            'route_name' => 'users.index',
            'semantic_icon' => 'user',
            'semantic_type' => 'link',
            'permission_id' => $permissions['users.view_any']->id ?? null,
            'order' => 1,
        ]);
        //Gestion de roles
        $Roles = MenuItem::create([
            'semantic_key' => 'module.roles',
            'display_name' => 'Gestión de Roles',
            'route_name' => '#',
            'semantic_icon' => 'shield',
            'semantic_type' => 'module',
            'permission_id' => ($permissions['roles.view_any']->id) ?? null,
            'order' => 16,
        ]);
        MenuItem::create([
            'parent_id' => $Roles->id,
            'semantic_key' => 'module.roles.manage',
            'display_name' => 'Roles',
            'route_name' => 'roles.index',
            'semantic_icon' => 'shield',
            'semantic_type' => 'link',
            'permission_id' => $permissions['roles.view_any']->id ?? null,
            'order' => 1,
        ]);
        //Gestion de permisos
        $Permisos = MenuItem::create([
            'semantic_key' => 'module.permissions',
            'display_name' => 'Gestión de Permisos',
            'route_name' => '#',
            'semantic_icon' => 'key',
            'semantic_type' => 'module',
            'permission_id' => ($permissions['permissions.view_any']->id) ?? null,
            'order' => 17,
        ]);
        MenuItem::create([
            'parent_id' => $Permisos->id,
            'semantic_key' => 'module.permissions.manage',
            'display_name' => 'Permisos',
            'route_name' => 'permissions.index',
            'semantic_icon' => 'key',
            'semantic_type' => 'link',
            'permission_id' => $permissions['permissions.view_any']->id ?? null,
            'order' => 1,
        ]);
        //Termina Gestión de usuarios////////////////////////////////////////////////////////////////////////////////////////////



















        // // Ejemplo para Configuración con hijos
        // $configModule = MenuItem::create([
        //     'semantic_key' => 'module.config',
        //     'display_name' => 'Configuración',
        //     'route_name' => '#',
        //     'semantic_icon' => 'settings',
        //     'semantic_type' => 'module',
        //     'permission_id' => $permissions['catalogs.view_any']->id ?? null,
        //     'order' => 100,
        // ]);

        // MenuItem::create([
        //     'parent_id' => $configModule->id,
        //     'semantic_key' => 'module.config.currencies',
        //     'display_name' => 'Monedas',
        //     'route_name' => 'currencies.index',
        //     'semantic_icon' => 'currency',
        //     'semantic_type' => 'link',
        //     'permission_id' => $permissions['currencies.view_any']->id ?? null,
        //     'order' => 1,
        // ]);
    }
}
