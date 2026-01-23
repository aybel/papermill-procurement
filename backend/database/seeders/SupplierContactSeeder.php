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
            // Contactos para SUP-001 (Celulosa Internacional S.A.)
            [
                'supplier_id' => 1,
                'name' => 'Carlos Mendoza',
                'email' => 'cmendoza@celulosa-int.com',
                'phone' => '+1-555-0101',
                'mobile' => '+1-555-0102',
                'position' => 'Gerente de Ventas',
                'department' => 'Ventas',
                'primary' => true,
                'active' => true,
                'notes' => 'Contacto principal para órdenes de celulosa kraft',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'supplier_id' => 1,
                'name' => 'Ana Martínez',
                'email' => 'amartinez@celulosa-int.com',
                'phone' => '+1-555-0103',
                'mobile' => '+1-555-0104',
                'position' => 'Coordinadora de Logística',
                'department' => 'Logística',
                'primary' => false,
                'active' => true,
                'notes' => 'Coordinación de embarques y fechas de entrega',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Contactos para SUP-002 (Pulpa y Fibras del Norte)
            [
                'supplier_id' => 2,
                'name' => 'Roberto García',
                'email' => 'rgarcia@pulpafibras.mx',
                'phone' => '+52-55-1234-5601',
                'mobile' => '+52-55-1234-5602',
                'position' => 'Director Comercial',
                'department' => 'Comercial',
                'primary' => true,
                'active' => true,
                'notes' => 'Decisor en precios y términos de pago',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'supplier_id' => 2,
                'name' => 'María López',
                'email' => 'mlopez@pulpafibras.mx',
                'phone' => '+52-55-1234-5603',
                'mobile' => null,
                'position' => 'Asistente de Ventas',
                'department' => 'Ventas',
                'primary' => false,
                'active' => true,
                'notes' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Contactos para SUP-003 (Reciclados Papel Verde)
            [
                'supplier_id' => 3,
                'name' => 'Luis Fernández',
                'email' => 'lfernandez@papelverde.mx',
                'phone' => '+52-33-9876-5401',
                'mobile' => '+52-33-9876-5402',
                'position' => 'Gerente General',
                'department' => 'Dirección',
                'primary' => true,
                'active' => true,
                'notes' => 'Propietario de la empresa',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Contactos para SUP-004 (Fibras Naturales Europeas)
            [
                'supplier_id' => 4,
                'name' => 'Jean-Pierre Dubois',
                'email' => 'jp.dubois@fibres-europe.eu',
                'phone' => '+33-1-4567-8901',
                'mobile' => '+33-6-7890-1234',
                'position' => 'Export Manager',
                'department' => 'International Sales',
                'primary' => true,
                'active' => true,
                'notes' => 'Contacto para cuentas de Latinoamérica',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'supplier_id' => 4,
                'name' => 'Sophie Laurent',
                'email' => 'slaurent@fibres-europe.eu',
                'phone' => '+33-1-4567-8902',
                'mobile' => null,
                'position' => 'Technical Support',
                'department' => 'Technical',
                'primary' => false,
                'active' => true,
                'notes' => 'Especificaciones técnicas y certificaciones',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Contactos para SUP-005 (Empaques Industriales SA)
            [
                'supplier_id' => 5,
                'name' => 'Pedro Ramírez',
                'email' => 'pramirez@empaques-ind.mx',
                'phone' => '+52-81-5555-0101',
                'mobile' => '+52-81-5555-0102',
                'position' => 'Ejecutivo de Cuenta',
                'department' => 'Ventas',
                'primary' => true,
                'active' => true,
                'notes' => 'Órdenes y cotizaciones',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Contactos para SUP-007 (Químicos Industriales Global)
            [
                'supplier_id' => 7,
                'name' => 'Dr. Miguel Ángel Torres',
                'email' => 'mtorres@quimicos-global.com',
                'phone' => '+1-713-555-0201',
                'mobile' => '+1-713-555-0202',
                'position' => 'Technical Sales Manager',
                'department' => 'Technical Sales',
                'primary' => true,
                'active' => true,
                'notes' => 'Especialista en blanqueadores',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'supplier_id' => 7,
                'name' => 'Patricia Gómez',
                'email' => 'pgomez@quimicos-global.com',
                'phone' => '+1-713-555-0203',
                'mobile' => '+1-713-555-0204',
                'position' => 'Customer Service Representative',
                'department' => 'Customer Service',
                'primary' => false,
                'active' => true,
                'notes' => 'Seguimiento de pedidos y facturación',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Contactos para SUP-008 (Aditivos y Colorantes Especializados)
            [
                'supplier_id' => 8,
                'name' => 'Ing. Jorge Morales',
                'email' => 'jmorales@aditivos-color.com',
                'phone' => '+1-305-555-0301',
                'mobile' => '+1-305-555-0302',
                'position' => 'Applications Engineer',
                'department' => 'Technical',
                'primary' => true,
                'active' => true,
                'notes' => 'Desarrollo de colorantes personalizados',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Contactos para SUP-010 (Transportes y Logística Express)
            [
                'supplier_id' => 10,
                'name' => 'Daniel Ortiz',
                'email' => 'dortiz@translogex.mx',
                'phone' => '+52-55-8888-0101',
                'mobile' => '+52-55-8888-0102',
                'position' => 'Coordinador de Operaciones',
                'department' => 'Operaciones',
                'primary' => true,
                'active' => true,
                'notes' => 'Disponible 24/7 para emergencias',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Contactos para SUP-013 (Maquinaria Papelera Internacional)
            [
                'supplier_id' => 13,
                'name' => 'Klaus Müller',
                'email' => 'kmuller@machinery-intl.de',
                'phone' => '+49-89-1234-5678',
                'mobile' => '+49-172-9876543',
                'position' => 'Senior Sales Engineer',
                'department' => 'Sales',
                'primary' => true,
                'active' => true,
                'notes' => 'Equipos Voith y proyectos de gran escala',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'supplier_id' => 13,
                'name' => 'Stefan Weber',
                'email' => 'sweber@machinery-intl.de',
                'phone' => '+49-89-1234-5679',
                'mobile' => null,
                'position' => 'After Sales Manager',
                'department' => 'Service',
                'primary' => false,
                'active' => true,
                'notes' => 'Soporte técnico y mantenimiento',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Contactos para SUP-014 (Repuestos y Refacciones Técnicas)
            [
                'supplier_id' => 14,
                'name' => 'Fernando Castro',
                'email' => 'fcastro@repuestos-tech.com',
                'phone' => '+1-713-777-0401',
                'mobile' => '+1-713-777-0402',
                'position' => 'Parts Specialist',
                'department' => 'Sales',
                'primary' => true,
                'active' => true,
                'notes' => 'Especialista en repuestos originales',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Contactos para SUP-017 (Energía y Combustibles Industriales)
            [
                'supplier_id' => 17,
                'name' => 'Alejandro Núñez',
                'email' => 'anunez@energia-comb.mx',
                'phone' => '+52-55-3333-0501',
                'mobile' => '+52-55-3333-0502',
                'position' => 'Gerente de Cuentas Industriales',
                'department' => 'Ventas',
                'primary' => true,
                'active' => true,
                'notes' => 'Contratos de suministro de gas natural',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Contactos para SUP-019 (Laboratorio de Análisis de Calidad)
            [
                'supplier_id' => 19,
                'name' => 'Dra. Laura Sánchez',
                'email' => 'lsanchez@lab-calidad.mx',
                'phone' => '+52-33-2222-0601',
                'mobile' => '+52-33-2222-0602',
                'position' => 'Directora de Laboratorio',
                'department' => 'Técnico',
                'primary' => true,
                'active' => true,
                'notes' => 'Certificaciones ISO y análisis especializados',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'supplier_id' => 19,
                'name' => 'Gabriela Ruiz',
                'email' => 'gruiz@lab-calidad.mx',
                'phone' => '+52-33-2222-0603',
                'mobile' => null,
                'position' => 'Coordinadora Administrativa',
                'department' => 'Administración',
                'primary' => false,
                'active' => true,
                'notes' => 'Cotizaciones y facturación',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('supplier_contacts')->insert($contacts);

        // Actualizar el primary_contact_id en la tabla suppliers
        $primaryContacts = [
            1 => 1,   // SUP-001 -> Carlos Mendoza
            2 => 3,   // SUP-002 -> Roberto García
            3 => 5,   // SUP-003 -> Luis Fernández
            4 => 6,   // SUP-004 -> Jean-Pierre Dubois
            5 => 8,   // SUP-005 -> Pedro Ramírez
            7 => 9,   // SUP-007 -> Dr. Miguel Ángel Torres
            8 => 11,  // SUP-008 -> Ing. Jorge Morales
            10 => 12, // SUP-010 -> Daniel Ortiz
            13 => 13, // SUP-013 -> Klaus Müller
            14 => 15, // SUP-014 -> Fernando Castro
            17 => 16, // SUP-017 -> Alejandro Núñez
            19 => 17, // SUP-019 -> Dra. Laura Sánchez
        ];

        foreach ($primaryContacts as $supplierId => $contactId) {
            DB::table('suppliers')
                ->where('id', $supplierId)
                ->update(['primary_contact_id' => $contactId]);
        }
    }
}
