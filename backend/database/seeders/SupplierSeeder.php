<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suppliers = [
            // Proveedores de materia prima (tipo 1)
            [
                'code' => 'SUP-001',
                'name' => 'Celulosa Internacional S.A.',
                'tax_id' => 'RFC-CEL-001',
                'supplier_type_id' => 1,
                'supplier_status_id' => 1,
                'primary_contact_id' => null,
                'quality_score' => 0.95,
                'delivery_score' => 0.92,
                'payment_terms_id' => 4, // NET45
                'currency_id' => 1, // USD
                'credit_limit' => 500000.00,
                'notes' => 'Proveedor principal de celulosa kraft blanqueada',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'SUP-002',
                'name' => 'Pulpa y Fibras del Norte',
                'tax_id' => 'RFC-PFN-002',
                'supplier_type_id' => 1,
                'supplier_status_id' => 1,
                'primary_contact_id' => null,
                'quality_score' => 0.88,
                'delivery_score' => 0.90,
                'payment_terms_id' => 3, // NET30
                'currency_id' => 3, // MXN
                'credit_limit' => 300000.00,
                'notes' => 'Proveedor regional de pulpa mecánica',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'SUP-003',
                'name' => 'Reciclados Papel Verde',
                'tax_id' => 'RFC-RPV-003',
                'supplier_type_id' => 1,
                'supplier_status_id' => 1,
                'primary_contact_id' => null,
                'quality_score' => 0.82,
                'delivery_score' => 0.85,
                'payment_terms_id' => 2, // NET15
                'currency_id' => 3, // MXN
                'credit_limit' => 150000.00,
                'notes' => 'Especialista en papel reciclado de alta calidad',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'SUP-004',
                'name' => 'Fibras Naturales Europeas',
                'tax_id' => 'VAT-FNE-004',
                'supplier_type_id' => 1,
                'supplier_status_id' => 1,
                'primary_contact_id' => null,
                'quality_score' => 0.97,
                'delivery_score' => 0.88,
                'payment_terms_id' => 5, // NET60
                'currency_id' => 2, // EUR
                'credit_limit' => 750000.00,
                'notes' => 'Proveedor premium de celulosa de eucalipto',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Proveedores de empaque (tipo 2)
            [
                'code' => 'SUP-005',
                'name' => 'Empaques Industriales SA',
                'tax_id' => 'RFC-EIS-005',
                'supplier_type_id' => 2,
                'supplier_status_id' => 1,
                'primary_contact_id' => null,
                'quality_score' => 0.91,
                'delivery_score' => 0.94,
                'payment_terms_id' => 3, // NET30
                'currency_id' => 3, // MXN
                'credit_limit' => 100000.00,
                'notes' => 'Proveedor de cajas corrugadas y tarimas',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'SUP-006',
                'name' => 'Plásticos y Embalajes del Pacífico',
                'tax_id' => 'RFC-PEP-006',
                'supplier_type_id' => 2,
                'supplier_status_id' => 1,
                'primary_contact_id' => null,
                'quality_score' => 0.89,
                'delivery_score' => 0.91,
                'payment_terms_id' => 3, // NET30
                'currency_id' => 1, // USD
                'credit_limit' => 80000.00,
                'notes' => 'Especialista en film stretch y plásticos industriales',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Proveedores de químicos (tipo 3)
            [
                'code' => 'SUP-007',
                'name' => 'Químicos Industriales Global',
                'tax_id' => 'RFC-QIG-007',
                'supplier_type_id' => 3,
                'supplier_status_id' => 1,
                'primary_contact_id' => null,
                'quality_score' => 0.96,
                'delivery_score' => 0.93,
                'payment_terms_id' => 4, // NET45
                'currency_id' => 1, // USD
                'credit_limit' => 400000.00,
                'notes' => 'Proveedor de blanqueadores y agentes de reforzamiento',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'SUP-008',
                'name' => 'Aditivos y Colorantes Especializados',
                'tax_id' => 'RFC-ACE-008',
                'supplier_type_id' => 3,
                'supplier_status_id' => 1,
                'primary_contact_id' => null,
                'quality_score' => 0.94,
                'delivery_score' => 0.89,
                'payment_terms_id' => 3, // NET30
                'currency_id' => 1, // USD
                'credit_limit' => 250000.00,
                'notes' => 'Colorantes y aditivos para papel tissue y cartón',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'SUP-009',
                'name' => 'Tratamientos Químicos del Centro',
                'tax_id' => 'RFC-TQC-009',
                'supplier_type_id' => 3,
                'supplier_status_id' => 2, // Suspendido
                'primary_contact_id' => null,
                'quality_score' => 0.72,
                'delivery_score' => 0.68,
                'payment_terms_id' => 2, // NET15
                'currency_id' => 3, // MXN
                'credit_limit' => 50000.00,
                'notes' => 'Proveedor suspendido por problemas de calidad',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Proveedores de servicios (tipo 4)
            [
                'code' => 'SUP-010',
                'name' => 'Transportes y Logística Express',
                'tax_id' => 'RFC-TLE-010',
                'supplier_type_id' => 4,
                'supplier_status_id' => 1,
                'primary_contact_id' => null,
                'quality_score' => 0.92,
                'delivery_score' => 0.96,
                'payment_terms_id' => 3, // NET30
                'currency_id' => 3, // MXN
                'credit_limit' => 200000.00,
                'notes' => 'Transporte especializado en materiales químicos',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'SUP-011',
                'name' => 'Mantenimiento Industrial Profesional',
                'tax_id' => 'RFC-MIP-011',
                'supplier_type_id' => 4,
                'supplier_status_id' => 1,
                'primary_contact_id' => null,
                'quality_score' => 0.87,
                'delivery_score' => 0.90,
                'payment_terms_id' => 2, // NET15
                'currency_id' => 3, // MXN
                'credit_limit' => 100000.00,
                'notes' => 'Mantenimiento preventivo y correctivo de maquinaria',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'SUP-012',
                'name' => 'Consultoría Ambiental Sostenible',
                'tax_id' => 'RFC-CAS-012',
                'supplier_type_id' => 4,
                'supplier_status_id' => 1,
                'primary_contact_id' => null,
                'quality_score' => 0.93,
                'delivery_score' => 0.88,
                'payment_terms_id' => 4, // NET45
                'currency_id' => 1, // USD
                'credit_limit' => 150000.00,
                'notes' => 'Certificaciones ambientales y tratamiento de aguas',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Proveedores de equipamiento (tipo 5)
            [
                'code' => 'SUP-013',
                'name' => 'Maquinaria Papelera Internacional',
                'tax_id' => 'RFC-MPI-013',
                'supplier_type_id' => 5,
                'supplier_status_id' => 1,
                'primary_contact_id' => null,
                'quality_score' => 0.98,
                'delivery_score' => 0.85,
                'payment_terms_id' => 6, // NET90
                'currency_id' => 2, // EUR
                'credit_limit' => 2000000.00,
                'notes' => 'Equipos de producción y máquinas papeleras Voith',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'SUP-014',
                'name' => 'Repuestos y Refacciones Técnicas',
                'tax_id' => 'RFC-RRT-014',
                'supplier_type_id' => 5,
                'supplier_status_id' => 1,
                'primary_contact_id' => null,
                'quality_score' => 0.90,
                'delivery_score' => 0.92,
                'payment_terms_id' => 4, // NET45
                'currency_id' => 1, // USD
                'credit_limit' => 500000.00,
                'notes' => 'Repuestos originales y genéricos para maquinaria',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'SUP-015',
                'name' => 'Instrumentación y Control Automatizado',
                'tax_id' => 'RFC-ICA-015',
                'supplier_type_id' => 5,
                'supplier_status_id' => 1,
                'primary_contact_id' => null,
                'quality_score' => 0.95,
                'delivery_score' => 0.87,
                'payment_terms_id' => 5, // NET60
                'currency_id' => 1, // USD
                'credit_limit' => 800000.00,
                'notes' => 'Sistemas SCADA y sensores industriales',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Proveedores adicionales variados
            [
                'code' => 'SUP-016',
                'name' => 'Almidones y Adhesivos Naturales',
                'tax_id' => 'RFC-AAN-016',
                'supplier_type_id' => 3,
                'supplier_status_id' => 1,
                'primary_contact_id' => null,
                'quality_score' => 0.86,
                'delivery_score' => 0.91,
                'payment_terms_id' => 3, // NET30
                'currency_id' => 3, // MXN
                'credit_limit' => 120000.00,
                'notes' => 'Almidones modificados y adhesivos biodegradables',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'SUP-017',
                'name' => 'Energía y Combustibles Industriales',
                'tax_id' => 'RFC-ECI-017',
                'supplier_type_id' => 4,
                'supplier_status_id' => 1,
                'primary_contact_id' => null,
                'quality_score' => 0.89,
                'delivery_score' => 0.95,
                'payment_terms_id' => 2, // NET15
                'currency_id' => 3, // MXN
                'credit_limit' => 600000.00,
                'notes' => 'Gas natural y combustibles para calderas',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'SUP-018',
                'name' => 'Bobinas y Rollos Premium',
                'tax_id' => 'RFC-BRP-018',
                'supplier_type_id' => 2,
                'supplier_status_id' => 1,
                'primary_contact_id' => null,
                'quality_score' => 0.92,
                'delivery_score' => 0.93,
                'payment_terms_id' => 3, // NET30
                'currency_id' => 1, // USD
                'credit_limit' => 180000.00,
                'notes' => 'Bobinas industriales y cores de cartón',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'SUP-019',
                'name' => 'Laboratorio de Análisis de Calidad',
                'tax_id' => 'RFC-LAC-019',
                'supplier_type_id' => 4,
                'supplier_status_id' => 1,
                'primary_contact_id' => null,
                'quality_score' => 0.97,
                'delivery_score' => 0.89,
                'payment_terms_id' => 3, // NET30
                'currency_id' => 3, // MXN
                'credit_limit' => 80000.00,
                'notes' => 'Análisis físico-químicos y certificaciones',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'SUP-020',
                'name' => 'Fibras Sintéticas Avanzadas',
                'tax_id' => 'RFC-FSA-020',
                'supplier_type_id' => 1,
                'supplier_status_id' => 3, // Inactivo
                'primary_contact_id' => null,
                'quality_score' => 0.65,
                'delivery_score' => 0.70,
                'payment_terms_id' => 1, // IMMEDIATE
                'currency_id' => 1, // USD
                'credit_limit' => null,
                'notes' => 'Proveedor inactivo - pendiente de reactivación',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('suppliers')->insert($suppliers);
    }
}
