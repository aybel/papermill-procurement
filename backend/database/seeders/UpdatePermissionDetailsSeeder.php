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


            // Supplier contacts
            'supplier_contacts.view_any' => ['resource' => 'supplier_contacts', 'action' => 'view_any', 'category' => 'Proveedores', 'description' => 'Ver contactos de proveedores', 'icon' => 'address-book'],
            'supplier_contacts.view' => ['resource' => 'supplier_contacts', 'action' => 'view', 'category' => 'Proveedores', 'description' => 'Ver detalles de contacto', 'icon' => 'address-book'],
            'supplier_contacts.update' => ['resource' => 'supplier_contacts', 'action' => 'update', 'category' => 'Proveedores', 'description' => 'Actualizar contacto de proveedor', 'icon' => 'edit'],
            'supplier_contacts.delete' => ['resource' => 'supplier_contacts', 'action' => 'delete', 'category' => 'Proveedores', 'description' => 'Eliminar contacto de proveedor', 'icon' => 'trash'],


            // Roles & Permissions
            'roles.manage' => ['resource' => 'roles', 'action' => 'manage', 'category' => 'Administración', 'description' => 'Gestionar roles y permisos', 'icon' => 'shield'],
            'users.manage' => ['resource' => 'users', 'action' => 'manage', 'category' => 'Administración', 'description' => 'Gestionar usuarios', 'icon' => 'users'],

            // Materials
            'materials.view_any' => ['resource' => 'materials', 'action' => 'view_any', 'category' => 'Materiales', 'description' => 'Ver todos los materiales', 'icon' => 'eye'],
            'materials.create' => ['resource' => 'materials', 'action' => 'create', 'category' => 'Materiales', 'description' => 'Crear material', 'icon' => 'plus'],
            'materials.update' => ['resource' => 'materials', 'action' => 'update', 'category' => 'Materiales', 'description' => 'Editar material', 'icon' => 'edit'],
            'materials.delete' => ['resource' => 'materials', 'action' => 'delete', 'category' => 'Materiales', 'description' => 'Eliminar material', 'icon' => 'trash'],

            // Budget Requests
            'budget_requests.view_any' => ['resource' => 'budget_requests', 'action' => 'view_any', 'category' => 'Solicitudes de Calendarización', 'description' => 'Ver todas las solicitudes', 'icon' => 'eye'],
            'budget_requests.create' => ['resource' => 'budget_requests', 'action' => 'create', 'category' => 'Solicitudes de Calendarización', 'description' => 'Crear solicitud de presupuesto', 'icon' => 'plus'],
            'budget_requests.update' => ['resource' => 'budget_requests', 'action' => 'update', 'category' => 'Solicitudes de Calendarización', 'description' => 'Editar solicitud', 'icon' => 'edit'],
            'budget_requests.delete' => ['resource' => 'budget_requests', 'action' => 'delete', 'category' => 'Solicitudes de Calendarización', 'description' => 'Eliminar solicitud', 'icon' => 'trash'],

            // Departments
            'departments.view_any' => ['resource' => 'departments', 'action' => 'view_any', 'category' => 'Departamentos', 'description' => 'Ver departamentos', 'icon' => 'eye'],
            'departments.manage' => ['resource' => 'departments', 'action' => 'manage', 'category' => 'Departamentos', 'description' => 'Gestionar departamentos', 'icon' => 'settings'],

            /******************************Configuraciones******************************/
            // Currencies
            'currencies.view_any' => ['resource' => 'currencies', 'action' => 'view_any', 'category' => 'Configuraciones', 'description' => 'Ver todas las monedas', 'icon' => 'eye'],
            'currencies.view' => ['resource' => 'currencies', 'action' => 'view', 'category' => 'Configuraciones', 'description' => 'Ver moneda', 'icon' => 'eye'],
            'currencies.create' => ['resource' => 'currencies', 'action' => 'create', 'category' => 'Configuraciones', 'description' => 'Crear moneda', 'icon' => 'plus'],
            'currencies.update' => ['resource' => 'currencies', 'action' => 'update', 'category' => 'Configuraciones', 'description' => 'Editar moneda', 'icon' => 'edit'],
            'currencies.delete' => ['resource' => 'currencies', 'action' => 'delete', 'category' => 'Configuraciones', 'description' => 'Eliminar moneda', 'icon' => 'trash'],

            //payment terms
            'payment_terms.view_any' => ['resource' => 'payment_terms', 'action' => 'view_any', 'category' => 'Configuraciones', 'description' => 'Ver todos los términos de pago', 'icon' => 'eye'],
            'payment_terms.view' => ['resource' => 'payment_terms', 'action' => 'view', 'category' => 'Configuraciones', 'description' => 'Ver término de pago', 'icon' => 'eye'],
            'payment_terms.create' => ['resource' => 'payment_terms', 'action' => 'create', 'category' => 'Configuraciones', 'description' => 'Crear término de pago', 'icon' => 'plus'],
            'payment_terms.update' => ['resource' => 'payment_terms', 'action' => 'update', 'category' => 'Configuraciones', 'description' => 'Editar término de pago', 'icon' => 'edit'],
            'payment_terms.delete' => ['resource' => 'payment_terms', 'action' => 'delete', 'category' => 'Configuraciones', 'description' => 'Eliminar término de pago', 'icon' => 'trash'],

            //units_of_measure
            'units_of_measure.view_any' => ['resource' => 'units_of_measure', 'action' => 'view_any', 'category' => 'Configuraciones', 'description' => 'Ver todas las unidades de medida', 'icon' => 'eye'],
            'units_of_measure.view' => ['resource' => 'units_of_measure', 'action' => 'view', 'category' => 'Configuraciones', 'description' => 'Ver unidad de medida', 'icon' => 'eye'],
            'units_of_measure.create' => ['resource' => 'units_of_measure', 'action' => 'create', 'category' => 'Configuraciones', 'description' => 'Crear unidad de medida', 'icon' => 'plus'],
            'units_of_measure.update' => ['resource' => 'units_of_measure', 'action' => 'update', 'category' => 'Configuraciones', 'description' => 'Editar unidad de medida', 'icon' => 'edit'],
            'units_of_measure.delete' => ['resource' => 'units_of_measure', 'action' => 'delete', 'category' => 'Configuraciones', 'description' => 'Eliminar unidad de medida', 'icon' => 'trash'],

            // Supplier types
            'supplier_types.view_any' => ['resource' => 'supplier_types', 'action' => 'view_any', 'category' => 'Configuraciones', 'description' => 'Ver tipos de proveedores', 'icon' => 'list'],

            'supplier_types.view' => ['resource' => 'supplier_types', 'action' => 'view', 'category' => 'Configuraciones', 'description' => 'Ver tipo de proveedor', 'icon' => 'eye'],
            'supplier_types.create' => ['resource' => 'supplier_types', 'action' => 'create', 'category' => 'Configuraciones', 'description' => 'Crear tipo de proveedor', 'icon' => 'plus'],
            'supplier_types.update' => ['resource' => 'supplier_types', 'action' => 'update', 'category' => 'Configuraciones', 'description' => 'Editar tipo de proveedor', 'icon' => 'edit'],
            'supplier_types.delete' => ['resource' => 'supplier_types', 'action' => 'delete', 'category' => 'Configuraciones', 'description' => 'Eliminar tipo de proveedor', 'icon' => 'trash'],

            //material categories
            'material_categories.view_any' => ['resource' => 'material_categories', 'action' => 'view_any', 'category' => 'Configuraciones', 'description' => 'Ver todas las categorías de materiales', 'icon' => 'eye'],
            'material_categories.view' => ['resource' => 'material_categories', 'action' => 'view', 'category' => 'Configuraciones', 'description' => 'Ver categoría de material', 'icon' => 'eye'],
            'material_categories.create' => ['resource' => 'material_categories', 'action' => 'create', 'category' => 'Configuraciones', 'description' => 'Crear categoría de material', 'icon' => 'plus'],
            'material_categories.update' => ['resource' => 'material_categories', 'action' => 'update', 'category' => 'Configuraciones', 'description' => 'Editar categoría de material', 'icon' => 'edit'],
            'material_categories.delete' => ['resource' => 'material_categories', 'action' => 'delete', 'category' => 'Configuraciones', 'description' => 'Eliminar categoría de material', 'icon' => 'trash'],

            // Material types
            'material_types.view_any' => ['resource' => 'material_types', 'action' => 'view_any', 'category' => 'Configuraciones', 'description' => 'Ver todos los tipos de materiales', 'icon' => 'eye'],
            'material_types.view' => ['resource' => 'material_types', 'action' => 'view', 'category' => 'Configuraciones', 'description' => 'Ver tipo de material', 'icon' => 'eye'],
            'material_types.create' => ['resource' => 'material_types', 'action' => 'create', 'category' => 'Configuraciones', 'description' => 'Crear tipo de material', 'icon' => 'plus'],
            'material_types.update' => ['resource' => 'material_types', 'action' => 'update', 'category' => 'Configuraciones', 'description' => 'Editar tipo de material', 'icon' => 'edit'],
            'material_types.delete' => ['resource' => 'material_types', 'action' => 'delete', 'category' => 'Configuraciones', 'description' => 'Eliminar tipo de material', 'icon' => 'trash'],
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
