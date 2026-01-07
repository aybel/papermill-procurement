<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contacts = [
            // Contactos para SUP-001 - Celulosa Internacional S.A.
            ['id' => 1, 'supplier_id' => 1, 'name' => 'Carlos Méndez', 'position' => 'Gerente de Ventas', 'email' => 'cmendez@celulosa.com', 'phone' => '+52-555-1234-001', 'mobile' => '+52-555-9876-001', 'is_primary' => 1, 'active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'supplier_id' => 1, 'name' => 'Ana Patricia López', 'position' => 'Coordinadora Logística', 'email' => 'alopez@celulosa.com', 'phone' => '+52-555-1234-002', 'mobile' => '+52-555-9876-002', 'is_primary' => 0, 'active' => 1, 'created_at' => now(), 'updated_at' => now()],

            // Contactos para SUP-002 - Pulpa y Fibras del Norte
            ['id' => 3, 'supplier_id' => 2, 'name' => 'Roberto Sánchez', 'position' => 'Director Comercial', 'email' => 'rsanchez@pfnorte.com', 'phone' => '+52-555-2234-001', 'mobile' => '+52-555-8876-001', 'is_primary' => 1, 'active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'supplier_id' => 2, 'name' => 'María Fernanda Torres', 'position' => 'Asistente de Ventas', 'email' => 'mtorres@pfnorte.com', 'phone' => '+52-555-2234-002', 'mobile' => '+52-555-8876-002', 'is_primary' => 0, 'active' => 1, 'created_at' => now(), 'updated_at' => now()],

            // Contactos para SUP-003 - Reciclados Papel Verde
            ['id' => 5, 'supplier_id' => 3, 'name' => 'Jorge Luis Ramírez', 'position' => 'Gerente General', 'email' => 'jramirez@papelverde.com', 'phone' => '+52-555-3234-001', 'mobile' => '+52-555-7876-001', 'is_primary' => 1, 'active' => 1, 'created_at' => now(), 'updated_at' => now()],

            // Contactos para SUP-004 - Fibras Naturales Europeas
            ['id' => 6, 'supplier_id' => 4, 'name' => 'Hans Mueller', 'position' => 'Export Manager', 'email' => 'hmueller@fibraseu.com', 'phone' => '+49-30-1234-001', 'mobile' => '+49-175-9876-001', 'is_primary' => 1, 'active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 7, 'supplier_id' => 4, 'name' => 'Sophie Laurent', 'position' => 'Sales Representative', 'email' => 'slaurent@fibraseu.com', 'phone' => '+49-30-1234-002', 'mobile' => '+49-175-9876-002', 'is_primary' => 0, 'active' => 1, 'created_at' => now(), 'updated_at' => now()],

            // Contactos para SUP-005 - Empaques Industriales SA
            ['id' => 8, 'supplier_id' => 5, 'name' => 'Pedro Martínez', 'position' => 'Gerente de Cuenta', 'email' => 'pmartinez@empaques.com', 'phone' => '+52-555-4234-001', 'mobile' => '+52-555-6876-001', 'is_primary' => 1, 'active' => 1, 'created_at' => now(), 'updated_at' => now()],

            // Contactos para SUP-006 - Plásticos y Embalajes del Pacífico
            ['id' => 9, 'supplier_id' => 6, 'name' => 'Laura Gómez', 'position' => 'Directora de Ventas', 'email' => 'lgomez@plasticospacifico.com', 'phone' => '+52-555-5234-001', 'mobile' => '+52-555-5876-001', 'is_primary' => 1, 'active' => 1, 'created_at' => now(), 'updated_at' => now()],

            // Contactos para SUP-007 - Químicos Industriales Global
            ['id' => 10, 'supplier_id' => 7, 'name' => 'Ricardo Fernández', 'position' => 'Gerente Regional', 'email' => 'rfernandez@quimicosglobal.com', 'phone' => '+52-555-6234-001', 'mobile' => '+52-555-4876-001', 'is_primary' => 1, 'active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 11, 'supplier_id' => 7, 'name' => 'Claudia Reyes', 'position' => 'Ingeniera de Aplicaciones', 'email' => 'creyes@quimicosglobal.com', 'phone' => '+52-555-6234-002', 'mobile' => '+52-555-4876-002', 'is_primary' => 0, 'active' => 1, 'created_at' => now(), 'updated_at' => now()],

            // Contactos para SUP-008 - Aditivos y Colorantes Especializados
            ['id' => 12, 'supplier_id' => 8, 'name' => 'Fernando Castro', 'position' => 'Gerente Técnico Comercial', 'email' => 'fcastro@aditivos.com', 'phone' => '+52-555-7234-001', 'mobile' => '+52-555-3876-001', 'is_primary' => 1, 'active' => 1, 'created_at' => now(), 'updated_at' => now()],

            // Contactos para SUP-009 - Tratamientos Químicos del Centro
            ['id' => 13, 'supplier_id' => 9, 'name' => 'Gabriela Morales', 'position' => 'Representante de Ventas', 'email' => 'gmorales@tqcentro.com', 'phone' => '+52-555-8234-001', 'mobile' => '+52-555-2876-001', 'is_primary' => 1, 'active' => 1, 'created_at' => now(), 'updated_at' => now()],

            // Contactos para SUP-010 - Transportes y Logística Express
            ['id' => 14, 'supplier_id' => 10, 'name' => 'Miguel Ángel Ruiz', 'position' => 'Coordinador de Operaciones', 'email' => 'mruiz@transportesexpress.com', 'phone' => '+52-555-9234-001', 'mobile' => '+52-555-1876-001', 'is_primary' => 1, 'active' => 1, 'created_at' => now(), 'updated_at' => now()],

            // Contactos para SUP-011 - Mantenimiento Industrial Profesional
            ['id' => 15, 'supplier_id' => 11, 'name' => 'José Luis Herrera', 'position' => 'Ingeniero Jefe', 'email' => 'jherrera@mantprofesional.com', 'phone' => '+52-555-0234-001', 'mobile' => '+52-555-0876-001', 'is_primary' => 1, 'active' => 1, 'created_at' => now(), 'updated_at' => now()],

            // Contactos para SUP-012 - Consultoría Ambiental Sostenible
            ['id' => 16, 'supplier_id' => 12, 'name' => 'Diana Rodríguez', 'position' => 'Consultora Senior', 'email' => 'drodriguez@ambientalsost.com', 'phone' => '+52-555-1235-001', 'mobile' => '+52-555-9877-001', 'is_primary' => 1, 'active' => 1, 'created_at' => now(), 'updated_at' => now()],

            // Contactos para SUP-013 - Maquinaria Papelera Internacional
            ['id' => 17, 'supplier_id' => 13, 'name' => 'Wolfgang Schmidt', 'position' => 'Sales Director', 'email' => 'wschmidt@maquinariapapel.com', 'phone' => '+49-40-5234-001', 'mobile' => '+49-170-1876-001', 'is_primary' => 1, 'active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 18, 'supplier_id' => 13, 'name' => 'Andrea Bianchi', 'position' => 'Technical Support Manager', 'email' => 'abianchi@maquinariapapel.com', 'phone' => '+39-02-3234-001', 'mobile' => '+39-340-7876-001', 'is_primary' => 0, 'active' => 1, 'created_at' => now(), 'updated_at' => now()],

            // Contactos para SUP-014 - Repuestos y Refacciones Técnicas
            ['id' => 19, 'supplier_id' => 14, 'name' => 'Alberto Vargas', 'position' => 'Gerente de Ventas', 'email' => 'avargas@repuestos.com', 'phone' => '+52-555-2235-001', 'mobile' => '+52-555-8877-001', 'is_primary' => 1, 'active' => 1, 'created_at' => now(), 'updated_at' => now()],

            // Contactos para SUP-015 - Instrumentación y Control Automatizado
            ['id' => 20, 'supplier_id' => 15, 'name' => 'Patricia Jiménez', 'position' => 'Gerente de Proyectos', 'email' => 'pjimenez@instrucontrol.com', 'phone' => '+52-555-3235-001', 'mobile' => '+52-555-7877-001', 'is_primary' => 1, 'active' => 1, 'created_at' => now(), 'updated_at' => now()],

            // Contactos para SUP-016 - Almidones y Adhesivos Naturales
            ['id' => 21, 'supplier_id' => 16, 'name' => 'Raúl Domínguez', 'position' => 'Director Comercial', 'email' => 'rdominguez@almidonesnaturales.com', 'phone' => '+52-555-4235-001', 'mobile' => '+52-555-6877-001', 'is_primary' => 1, 'active' => 1, 'created_at' => now(), 'updated_at' => now()],

            // Contactos para SUP-017 - Energía y Combustibles Industriales
            ['id' => 22, 'supplier_id' => 17, 'name' => 'Héctor Medina', 'position' => 'Gerente de Cuentas Industriales', 'email' => 'hmedina@energiacombustible.com', 'phone' => '+52-555-5235-001', 'mobile' => '+52-555-5877-001', 'is_primary' => 1, 'active' => 1, 'created_at' => now(), 'updated_at' => now()],

            // Contactos para SUP-018 - Bobinas y Rollos Premium
            ['id' => 23, 'supplier_id' => 18, 'name' => 'Verónica Ortiz', 'position' => 'Gerente de Ventas', 'email' => 'vortiz@bobinaspremium.com', 'phone' => '+52-555-6235-001', 'mobile' => '+52-555-4877-001', 'is_primary' => 1, 'active' => 1, 'created_at' => now(), 'updated_at' => now()],

            // Contactos para SUP-019 - Laboratorio de Análisis de Calidad
            ['id' => 24, 'supplier_id' => 19, 'name' => 'Dr. Enrique Navarro', 'position' => 'Director Técnico', 'email' => 'enavarro@labcalidad.com', 'phone' => '+52-555-7235-001', 'mobile' => '+52-555-3877-001', 'is_primary' => 1, 'active' => 1, 'created_at' => now(), 'updated_at' => now()],

            // Contactos para SUP-020 - Fibras Sintéticas Avanzadas
            ['id' => 25, 'supplier_id' => 20, 'name' => 'Sergio Aguilar', 'position' => 'Gerente Regional', 'email' => 'saguilar@fibrassinteticas.com', 'phone' => '+52-555-8235-001', 'mobile' => '+52-555-2877-001', 'is_primary' => 1, 'active' => 0, 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('supplier_contacts')->insert($contacts);

        // Actualizar primary_contact_id en la tabla suppliers
        $updates = [
            ['id' => 1, 'primary_contact_id' => 1],
            ['id' => 2, 'primary_contact_id' => 3],
            ['id' => 3, 'primary_contact_id' => 5],
            ['id' => 4, 'primary_contact_id' => 6],
            ['id' => 5, 'primary_contact_id' => 8],
            ['id' => 6, 'primary_contact_id' => 9],
            ['id' => 7, 'primary_contact_id' => 10],
            ['id' => 8, 'primary_contact_id' => 12],
            ['id' => 9, 'primary_contact_id' => 13],
            ['id' => 10, 'primary_contact_id' => 14],
            ['id' => 11, 'primary_contact_id' => 15],
            ['id' => 12, 'primary_contact_id' => 16],
            ['id' => 13, 'primary_contact_id' => 17],
            ['id' => 14, 'primary_contact_id' => 19],
            ['id' => 15, 'primary_contact_id' => 20],
            ['id' => 16, 'primary_contact_id' => 21],
            ['id' => 17, 'primary_contact_id' => 22],
            ['id' => 18, 'primary_contact_id' => 23],
            ['id' => 19, 'primary_contact_id' => 24],
            ['id' => 20, 'primary_contact_id' => 25],
        ];

        foreach ($updates as $update) {
            DB::table('suppliers')
                ->where('id', $update['id'])
                ->update(['primary_contact_id' => $update['primary_contact_id']]);
        }
    }
}
