# Migraciones del Sistema de Compras - Papermill

## Cambios Implementados

Se han creado las migraciones del sistema usando **IDs autoincrementales** de MySQL, con una estructura simplificada enfocándose en las funcionalidades core del sistema de compras para la industria papelera.

## Tablas Principales

### Tablas Catálogo

#### 1. supplier_types
- Catálogo de tipos de proveedores
- Tipos predefinidos: raw_material, packaging, chemical, service, equipment
- Permite agregar nuevos tipos desde la aplicación

#### 2. supplier_statuses
- Catálogo de estados de proveedores
- Estados: active, suspended, inactive
- Incluye campo color para UI

### 3. material_categories
- Categorías jerárquicas para clasificar materiales
- Soporte para atributos personalizados en JSON
- Soft deletes habilitado

### 4. suppliers (Proveedores)
- Información de contacto completa
- Métricas de desempeño (calidad, entrega, score general)
- Gestión de crédito y términos de pago
- Relacionado con supplier_types y supplier_statuses mediante foreign keys
- Relación con supplier_contacts para contacto principal

### 4a. supplier_contacts (Contactos de Proveedores)
- Almacena múltiples contactos por proveedor
- Información detallada: nombre, email, teléfono, celular, cargo, departamento
- Campo is_primary para identificar contacto principal
- Relación uno-a-muchos con suppliers

### 5. materials (Materiales)
- Campos específicos para industria papelera: grammage, width, length, color
- Gestión de stock con reorder_point calculado automáticamente
- Tracking de costos (promedio y último precio de compra)

### 6. purchase_requisitions (Requisiciones)
- Workflow de aprobación con approver_id
- Estados: draft, pending_approval, approved, rejected, converted, cancelled
- Prioridades: low, medium, high, urgent

### 7. purchase_orders (Órdenes de Compra)
- Desglose financiero completo: subtotal, tax, shipping_cost, total_amount
- Tracking de fechas: issue_date, expected_delivery, actual_delivery
- Estados: draft, sent, confirmed, partial_received, completed, cancelled

### 8. purchase_order_items
- Relación muchos-a-muchos entre purchase_orders y materials
- Campo total_price calculado automáticamente (stored generated column)
- Tracking de cantidades recibidas y rechazadas

### 9. receipts
- Registro de recepción de materiales
- Vinculado a purchase_orders

### 10. quality_inspections
- Pruebas específicas para papel:
  - Grammage (gramaje)
  - Humidity (humedad)
  - Thickness (espesor/calibre)
  - Tensile strength (resistencia a tracción)
- Inspección visual y defectos
- Estados: pending, passed, failed, conditional

### 11. supplier_performance_daily (Vista)
- Vista SQL para KPIs de proveedores
- Métricas diarias agregadas: órdenes, cantidad, gasto, calidad, entregas a tiempo

## Comandos de Migración

### Ejecutar todas las migraciones
```bash
docker exec -it papermill-php php artisan migrate
```

### Refrescar base de datos (desarrollo)
```bash
docker exec -it papermill-php php artisan migrate:fresh
```

### Con seeders
```bash
docker exec -it papermill-php php artisan migrate:fresh --seed
```

### Rollback última migración
```bash
docker exec -it papermill-php php artisan migrate:rollback
```

## Orden de Ejecución

Las migraciones se ejecutan en este orden:
1. `2025_12_27_000001a_create_supplier_types_table.php` - Catálogo de tipos de proveedores
2. `2025_12_27_000001b_create_supplier_statuses_table.php` - Catálogo de estados de proveedores
3. `2025_12_27_000001c_create_material_categories_table.php` - Material categories
4. `2025_12_27_000002_create_suppliers_table.php` - Suppliers
5. `2025_12_27_000002a_create_supplier_contacts_table.php` - Supplier contacts
6. `2025_12_27_000002b_add_primary_contact_to_suppliers.php` - Agrega FK de contacto principal a suppliers
7. `2025_12_27_000003_create_materials_table.php` - Materials
8. `2025_12_27_000005_create_requisitions_table.php` - Purchase requisitions
9. `2025_12_27_000009_create_purchase_orders_table.php` - Purchase orders
10. `2025_12_27_000016_create_purchase_order_items_table.php` - PO items
11. `2025_12_27_000017_create_receipts_table.php` - Receipts
12. `2025_12_27_000018_create_quality_inspections_table.php` - Quality inspections
13. `2025_12_27_000019_create_supplier_performance_view.php` - Performance view

## Notas Importantes

### Generated Columns

Algunos campos se calculan automáticamente:
- `materials.reorder_point` = `min_stock + safety_stock`
- `purchase_order_items.total_price` = `quantity * unit_price`

Estos campos NO se pueden asignar manualmente en Laravel, se calculan en la base de datos.

### Soft Deletes

Las siguientes tablas tienen soft deletes:
- `material_categories`
- `suppliers`

Usa `->withTrashed()` para incluir registros eliminados en consultas.

### Índices

Se han creado índices en:
- Campos de búsqueda frecuente (sku, code, status)
- Foreign keys para optimizar joins
- Campos usados en WHERE y ORDER BY

## Base de Datos Recomendada

El esquema está optimizado para **MySQL 8.0+**, que soporta:
- Generated columns (STORED)
- JSON columns
- Funciones avanzadas para vistas

## Ejemplo de Modelo Laravel

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'tax_id',
        'supplier_type_id',
        'supplier_status_id',
        'contact_name',
        'contact_email',
        'contact_phone',
        'quality_score',
        'delivery_score',
        'overall_score',
        'payment_terms',
        'credit_limit',
    ];

    protected $casts = [
        'quality_score' => 'decimal:2',
        'delivery_score' => 'decimal:2',
        'overall_score' => 'decimal:2',
        'credit_limit' => 'decimal:2',
        'deleted_at' => 'datetime',
    ];

    public function supplierType()
    {
        return $this->belongsTo(SupplierType::class);
    }

    public function supplierStatus()
    {
        return $this->belongsTo(SupplierStatus::class);
    }

    public function purchaseOrders()
    {
        return $this->hasMany(PurchaseOrder::class);
    }

    public function contacts()
    {
        return $this->hasMany(SupplierContact::class);
    }

    public function primaryContact()
    {
        return $this->belongsTo(SupplierContact::class, 'primary_contact_id');
    }
}
```

### Modelo SupplierContact

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplierContact extends Model
{
    protected $fillable = [
        'supplier_id',
        'name',
        'email',
        'phone',
        'mobile',
        'position',
        'department',
        'is_primary',
        'active',
        'notes',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
        'active' => 'boolean',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
```

### Modelos de Catálogo

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplierType extends Model
{
    protected $fillable = ['code', 'name', 'description', 'active'];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function suppliers()
    {
        return $this->hasMany(Supplier::class);
    }
}

class SupplierStatus extends Model
{
    protected $fillable = ['code', 'name', 'description', 'color', 'active'];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function suppliers()
    {
        return $this->hasMany(Supplier::class);
    }
}
```

## Testing

Para verificar que las migraciones funcionan correctamente:

```bash
docker exec -it papermill-php bash
php artisan migrate:fresh
php artisan tinker

# En tinker, prueba crear un registro
App\Models\Supplier::create([
    'code' => 'SUP001',
    'name' => 'Test Supplier',
    'supplier_type' => 'raw_material',
    'status' => 'active'
]);
```

## Próximos Pasos

1. Crear los modelos Eloquent correspondientes
2. Crear seeders con datos de prueba
3. Implementar factories para testing
4. Configurar relaciones entre modelos
5. Crear observers para calcular métricas automáticamente
