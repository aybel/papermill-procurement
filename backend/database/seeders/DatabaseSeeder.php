<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         User::factory(10)->create();
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

            // 5. Categorías de materiales con sus atributos específicos
            MaterialCategorySeeder::class,

            // 6. Materiales (que se asocian a categorías)
            MaterialSeeder::class,
            // 7. Departamentos y aprobadores
            DepartmentSeeder::class,
            DepartmentApproverSeeder::class,

        ]);
    }
}
