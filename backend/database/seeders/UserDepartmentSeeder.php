<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserDepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener departamentos existentes
        $compras = Department::where('code', 'COMP')->first();
        $produccion = Department::where('code', 'PROD')->first();
        $mantenimiento = Department::where('code', 'MANT')->first();
        $sistemas = Department::where('code', 'IT')->first();
        $administracion = Department::where('code', 'ADM')->first();

        // Si no existe sistemas o administración, usar el primer departamento disponible
        $defaultDeptForAdmin = $sistemas?->id ?? $administracion?->id ?? $compras?->id ?? Department::first()?->id;

        if (!$defaultDeptForAdmin) {
            $this->command->error('⚠ No hay departamentos disponibles. Ejecuta DepartmentSeeder primero.');
            return;
        }

        // Usuario 1: Jefe de Compras (gestiona múltiples departamentos)
        $jefeCompras = User::create([
            'name' => 'Carlos Mendoza',
            'email' => 'carlos.mendoza@company.com',
            'password' => Hash::make('password'),
            'department_id' => $compras?->id ?? $defaultDeptForAdmin, // Su departamento home es Compras
        ]);

        // Asignar rol
        $jefeComprasRole = Role::where('name', 'Jefe de Compras')->where('guard_name', 'api')->first();
        if ($jefeComprasRole) {
            $jefeCompras->syncRoles([$jefeComprasRole]);
        }

        // Tiene acceso funcional a Producción y Mantenimiento como manager
        if ($produccion) {
            $jefeCompras->accessibleDepartments()->attach($produccion->id, ['role' => 'manager']);
        }
        if ($mantenimiento) {
            $jefeCompras->accessibleDepartments()->attach($mantenimiento->id, ['role' => 'manager']);
        }

        // Usuario 2: Comprador (solo lectura en varios departamentos)
        $comprador = User::create([
            'name' => 'Ana López',
            'email' => 'ana.lopez@company.com',
            'password' => Hash::make('password'),
            'department_id' => $compras?->id ?? $defaultDeptForAdmin,
        ]);

        // Asignar rol
        $compradorRole = Role::where('name', 'Comprador')->where('guard_name', 'api')->first();
        if ($compradorRole) {
            $comprador->syncRoles([$compradorRole]);
        }

        if ($produccion) {
            $comprador->accessibleDepartments()->attach($produccion->id, ['role' => 'viewer']);
        }
        if ($mantenimiento) {
            $comprador->accessibleDepartments()->attach($mantenimiento->id, ['role' => 'viewer']);
        }

        // Usuario 3: Jefe de Producción (solo su departamento)
        $jefeProduccion = User::create([
            'name' => 'Roberto Silva',
            'email' => 'roberto.silva@company.com',
            'password' => Hash::make('password'),
            'department_id' => $produccion?->id ?? $defaultDeptForAdmin,
        ]);

        // Asignar rol
        $jefeDeptRole = Role::where('name', 'Jefe de Departamento')->where('guard_name', 'api')->first();
        if ($jefeDeptRole) {
            $jefeProduccion->syncRoles([$jefeDeptRole]);
        }
        // No necesita accesos adicionales, solo ve su departamento

        // Usuario 4: Admin global - Consultar si ya existe, no crear duplicado
        $admin = User::where('name', 'Super Admin')->first();

        if ($admin) {
            // Si existe, actualizar su department_id
            $admin->update(['department_id' => 8]);
            $this->command->info('✓ Super Admin encontrado y actualizado');
        } else {
            // Si no existe, crearlo
            $admin = User::create([
                'name' => 'Super Admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'department_id' => 8,
            ]);
            $this->command->info('✓ Super Admin creado');
        }

        // Asignar rol Super Admin
        $superAdminRole = Role::where('name', 'Super Admin')->where('guard_name', 'api')->first();
        if ($superAdminRole) {
            $admin->syncRoles([$superAdminRole]);
        }

        // Limpiar relaciones previas y asignar acceso funcional a TODOS los departamentos como manager
        $admin->accessibleDepartments()->detach();
        $allDepartments = Department::all();
        foreach ($allDepartments as $dept) {
            if ($dept->id !== $admin->department_id) {
                $admin->accessibleDepartments()->attach($dept->id, ['role' => 'manager']);
            }
        }

        $this->command->info('✓ Usuarios con departamentos, accesos y roles creados correctamente');
        $this->command->info('  - Todos los usuarios tienen department_id asignado');
        $this->command->info('  - Todos los usuarios tienen roles asignados');
        $this->command->info('  - Super Admin tiene acceso funcional a todos los departamentos');
    }
}
