<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('currencies')->truncate();
        Schema::enableForeignKeyConstraints();
        DB::table('currencies')->insert([
            ['id' => 1, 'code' => 'USD', 'name' => 'Dólar Estadounidense', 'symbol' => '$', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'code' => 'EUR', 'name' => 'Euro', 'symbol' => '€', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'code' => 'MXN', 'name' => 'Peso Mexicano', 'symbol' => '$', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
