<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class UpdatePermissionDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissionDetails = [
            // Suppliers
            'suppliers.view_any' => ['resource' => 'suppliers', 'action' => 'view_any', 'category' => 'Proveedores', 'description' => 'Ver todos los proveedores', 'icon' => 'eye'],
            'suppliers.view' => ['resource' => 'suppliers', 'action' => 'view', 'category' => 'Proveedores', 'description' => 'Ver detalles de un proveedor', 'icon' => 'eye'],
            'suppliers.create' => ['resource' => 'suppliers', 'action' => 'create', 'category' => 'Proveedores', 'description' => 'Crear nuevo proveedor', 'icon' => 'plus'],
            'suppliers.update' => ['resource' => 'suppliers', 'action' => 'update', 'category' => 'Proveedores', 'description' => 'Editar proveedor', 'icon' => 'edit'],
            'suppliers.delete' => ['resource' => 'suppliers', 'action' => 'delete', 'category' => 'Proveedores', 'description' => 'Eliminar proveedor', 'icon' => 'trash'],
            'suppliers.restore' => ['resource' => 'suppliers', 'action' => 'restore', 'category' => 'Proveedores', 'description' => 'Restaurar proveedor eliminado', 'icon' => 'undo'],
            'suppliers.update_scores' => ['resource' => 'suppliers', 'action' => 'update_scores', 'category' => 'Proveedores', 'description' => 'Actualizar puntuaciones de proveedores', 'icon' => 'star'],

            // Supplier types
            'supplier_types.view_any' => ['resource' => 'supplier_types', 'action' => 'view_any', 'category' => 'Configuración', 'description' => 'Ver tipos de proveedores', 'icon' => 'list'],
            'supplier_types.create' => ['resource' => 'supplier_types', 'action' => 'create', 'category' => 'Configuración', 'description' => 'Crear tipo de proveedor', 'icon' => 'plus'],
            'supplier_types.update' => ['resource' => 'supplier_types', 'action' => 'update', 'category' => 'Configuración', 'description' => 'Editar tipo de proveedor', 'icon' => 'edit'],
            'supplier_types.delete' => ['resource' => 'supplier_types', 'action' => 'delete', 'category' => 'Configuración', 'description' => 'Eliminar tipo de proveedor', 'icon' => 'trash'],

            // Roles & Permissions
            'roles.manage' => ['resource' => 'roles', 'action' => 'manage', 'category' => 'Administración', 'description' => 'Gestionar roles y permisos', 'icon' => 'shield'],
            'users.manage' => ['resource' => 'users', 'action' => 'manage', 'category' => 'Administración', 'description' => 'Gestionar usuarios', 'icon' => 'users'],

            // Materials
            'materials.view_any' => ['resource' => 'materials', 'action' => 'view_any', 'category' => 'Materiales', 'description' => 'Ver todos los materiales', 'icon' => 'eye'],
            'materials.create' => ['resource' => 'materials', 'action' => 'create', 'category' => 'Materiales', 'description' => 'Crear material', 'icon' => 'plus'],
            'materials.update' => ['resource' => 'materials', 'action' => 'update', 'category' => 'Materiales', 'description' => 'Editar material', 'icon' => 'edit'],
            'materials.delete' => ['resource' => 'materials', 'action' => 'delete', 'category' => 'Materiales', 'description' => 'Eliminar material', 'icon' => 'trash'],

            // Budget Requests
            'budget_requests.view_any' => ['resource' => 'budget_requests', 'action' => 'view_any', 'category' => 'Solicitudes de Presupuesto', 'description' => 'Ver todas las solicitudes', 'icon' => 'eye'],
            'budget_requests.create' => ['resource' => 'budget_requests', 'action' => 'create', 'category' => 'Solicitudes de Presupuesto', 'description' => 'Crear solicitud de presupuesto', 'icon' => 'plus'],
            'budget_requests.update' => ['resource' => 'budget_requests', 'action' => 'update', 'category' => 'Solicitudes de Presupuesto', 'description' => 'Editar solicitud', 'icon' => 'edit'],
            'budget_requests.delete' => ['resource' => 'budget_requests', 'action' => 'delete', 'category' => 'Solicitudes de Presupuesto', 'description' => 'Eliminar solicitud', 'icon' => 'trash'],

            // Departments
            'departments.view_any' => ['resource' => 'departments', 'action' => 'view_any', 'category' => 'Departamentos', 'description' => 'Ver departamentos', 'icon' => 'eye'],
            'departments.manage' => ['resource' => 'departments', 'action' => 'manage', 'category' => 'Departamentos', 'description' => 'Gestionar departamentos', 'icon' => 'settings'],
        ];

        foreach ($permissionDetails as $permissionName => $details) {
            Permission::where('name', $permissionName)
                ->update([
                    'resource' => $details['resource'],
                    'action' => $details['action'],
                    'category' => $details['category'],
                    'description' => $details['description'],
                    'icon' => $details['icon'],
                ]);
        }
    }
}
