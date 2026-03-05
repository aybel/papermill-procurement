<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // 1. Catálogos de los que dependen los proveedores
            SupplierTypeSeeder::class,
            SupplierStatusSeeder::class,
            PaymentTermSeeder::class,
            CurrencySeeder::class,

            // 1b. Catálogos de materiales (tipos y unidades)
            MaterialTypeSeeder::class,
            UnitOfMeasureSeeder::class,

            // 2. Proveedores (aún sin el contacto primario)
            SupplierSeeder::class,

            // 3. Contactos (que se asocian a proveedores y actualizan el ID primario)
            SupplierContactSeeder::class,

            // 4. Permisos y otros seeders
            PermissionsSeeder::class,
            UpdatePermissionDetailsSeeder::class,

            // 5. Categorías de materiales con sus atributos específicos
            MaterialCategorySeeder::class,

            // 6. Materiales (que se asocian a categorías)
            MaterialSeeder::class,

            // 7. Departamentos y aprobadores
            DepartmentSeeder::class,
            DepartmentApproverSeeder::class,

            // 8. Categorías de presupuesto
            BudgetCategorySeeder::class,

            // 9. Usuarios con diferentes roles y accesos a departamentos (DEBE IR ANTES de BudgetAssignmentSeeder)
            UserDepartmentSeeder::class,

            // 10. Asignaciones de presupuesto (requiere usuarios creados)
            BudgetAssignmentSeeder::class,

        ]);

        // Crear 10 usuarios aleatorios adicionales con departamentos asignados (ÚNICOS)
        $departments = Department::all()->toArray();
        $jefeDeptRole = Role::where('name', 'Jefe de Departamento')->where('guard_name', 'api')->first();

        if (!empty($departments)) {
            // Mezclar departamentos y limitara 10 máximo
            shuffle($departments);
            $departmentsToAssign = array_slice($departments, 0, 10);
            $usersCount = count($departmentsToAssign);

            foreach ($departmentsToAssign as $dept) {
                $firstName = fake()->firstName();
                $lastName = fake()->lastName();
                $email = Str::slug($firstName . '.' . $lastName) . '@company.com';

                $user = User::create([
                    'name' => $firstName . ' ' . $lastName,
                    'email' => $email,
                    'password' => Hash::make('pruebas'),
                    'department_id' => $dept['id'], // Cada usuario en un departamento único
                ]);

                // Asignar rol Jefe de Departamento
                if ($jefeDeptRole) {
                    $user->syncRoles([$jefeDeptRole]);
                }
            }
            $this->command->info("✓ {$usersCount} usuarios adicionales creados (1 Jefe de Departamento por depto)");
        }
    }
}
