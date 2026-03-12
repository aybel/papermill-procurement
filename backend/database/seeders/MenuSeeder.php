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
            'semantic_key' => 'module.suppliers',
            'display_name' => 'Proveedores',
            'route_name' => 'suppliers.index',
            'semantic_icon' => 'supplier',
            'semantic_type' => 'module',
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

        // ... CONTINÚA CON EL RESTO DE TU MENÚ ACTUAL
        // Aquí mapeas todo tu sidebarItem actual a este seeder

        // Ejemplo para Configuración con hijos
        $configModule = MenuItem::create([
            'semantic_key' => 'module.config',
            'display_name' => 'Configuración',
            'route_name' => '#',
            'semantic_icon' => 'settings',
            'semantic_type' => 'module',
            'permission_id' => $permissions['catalogs.view_any']->id ?? null,
            'order' => 100,
        ]);

        MenuItem::create([
            'parent_id' => $configModule->id,
            'semantic_key' => 'module.config.currencies',
            'display_name' => 'Monedas',
            'route_name' => 'currencies.index',
            'semantic_icon' => 'currency',
            'semantic_type' => 'link',
            'permission_id' => $permissions['currencies.view_any']->id ?? null,
            'order' => 1,
        ]);
    }
}
