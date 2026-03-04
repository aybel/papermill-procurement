# Documentación de Migraciones - Papermill Procurement

Este documento proporciona una descripción detallada de la estructura de la base de datos, organizada por módulos funcionales.

## Módulo Core y de Autenticación

Tablas base de Laravel y para la gestión de usuarios y permisos.

-   **`users`**: Almacena las cuentas de usuario.
-   **`password_reset_tokens`**: Tokens para el reseteo de contraseñas.
-   **`sessions`**: Gestiona las sesiones de los usuarios.
-   **`cache` / `cache_locks`**: Tablas para el sistema de caché de Laravel.
-   **`jobs` / `job_batches` / `failed_jobs`**: Tablas para la gestión de colas de trabajos.
-   **`permissions` / `roles` / `model_has_permissions` / `model_has_roles` / `role_has_permissions`**: Tablas del paquete `spatie/laravel-permission` para el control de acceso basado en roles.

---

## Módulo de Catálogos Generales

Tablas que almacenan información de configuración y catálogos transversales.

### `departments`
Almacena los departamentos de la empresa para vincular solicitudes y presupuestos.
-   **`id`**: Identificador único.
-   **`name`**: Nombre del departamento (ej. "Producción", "Mantenimiento").

### `currencies`
Catálogo de monedas para transacciones.
-   **`code`**: Código ISO (ej. "USD").
-   **`name`**: Nombre de la moneda (ej. "Dólar Estadounidense").
-   **`symbol`**: Símbolo (ej. "$").
-   **`exchange_rate`**: Tasa de cambio respecto a una moneda base.
-   **`is_base`**: Booleano que indica si es la moneda principal del sistema.

### `payment_terms`
Catálogo de términos de pago.
-   **`code`**: Código único (ej. "NET30").
-   **`name`**: Nombre descriptivo (ej. "Neto 30 días").
-   **`days`**: Número de días para el pago.

---

## Módulo de Proveedores (Suppliers)

Gestión integral de la información de los proveedores.

### `supplier_types`
Clasifica a los proveedores.
-   **`code`**: Código único (ej. "raw_material").
-   **`name`**: Nombre del tipo (ej. "Materia Prima").

### `supplier_statuses`
Define el estado de un proveedor.
-   **`code`**: Código único (ej. "active").
-   **`name`**: Nombre del estado (ej. "Activo").
-   **`color`**: Color para la interfaz de usuario.

### `suppliers`
Tabla central de proveedores.
-   **`code`**: Código interno del proveedor.
-   **`name`**: Razón social.
-   **`tax_id`**: Identificación fiscal (RUC, RFC).
-   **`supplier_type_id`**: FK a `supplier_types`.
-   **`supplier_status_id`**: FK a `supplier_statuses`.
-   **`primary_contact_id`**: FK al contacto principal en `supplier_contacts`.
-   **`quality_score` / `delivery_score`**: Métricas de rendimiento.
-   **`payment_terms_id`**: FK a `payment_terms`.
-   **`currency_id`**: FK a `currencies` (moneda principal del proveedor).
-   **`credit_limit`**: Límite de crédito.

### `supplier_contacts`
Contactos asociados a un proveedor.
-   **`supplier_id`**: FK a `suppliers`.
-   **`name`**, **`email`**, **`phone`**, **`position`**: Datos del contacto.
-   **`is_primary`**: Booleano para marcar al contacto principal.

---

## Módulo de Materiales (Inventory)

Gestión de materiales, inventario y especificaciones.

### `material_categories`
Categorías jerárquicas para materiales.
-   **`name`**: Nombre de la categoría.
-   **`parent_id`**: FK para anidar categorías.
-   **`attributes`**: JSON para atributos específicos.

### `material_types`
Tipos de material.
-   **`code`**: Código único (ej. "chemical").
-   **`name`**: Nombre del tipo (ej. "Químico").

### `units_of_measure`
Unidades de medida.
-   **`code`**: Código único (ej. "kg").
-   **`name`**: Nombre de la unidad (ej. "Kilogramo").
-   **`symbol`**: Símbolo ("kg").
-   **`category`**: Categoría (peso, volumen, etc.).
-   **`conversion_factor`**: Factor para conversiones.

### `materials`
Tabla central de materiales.
-   **`sku`**: Código único de producto.
-   **`name`**: Nombre del material.
-   **`category_id`**: FK a `material_categories`.
-   **`material_type_id`**: FK a `material_types`.
-   **`unit_of_measure_id`**: FK a `units_of_measure`.
-   **`current_stock`**, **`min_stock`**, **`max_stock`**: Control de inventario.
-   **`avg_unit_cost`**, **`last_purchase_price`**: Costos.
-   **`grammage`**, **`width`**, **`length`**, **`color`**: Especificaciones para papel.
---

## Módulo de Presupuestos (Budgeting)

Gestiona la creación y asignación de presupuestos anuales por rubro y departamento.

### `budget_rubros`
Catálogo para las diferentes categorías o rubros en los que se divide el presupuesto.
-   **`id`**: Identificador único.
-   **`name`**: Nombre del rubro (ej. "Gastos de Operación", "Inversión en Maquinaria").
-   **`description`**: Descripción detallada del rubro.
-   **`is_active`**: Booleano para activar o desactivar el uso del rubro.

### `budget_assignments`
Asigna un monto específico de presupuesto a un departamento para un rubro y año determinados.
-   **`id`**: Identificador único.
-   **`department_id`**: FK al departamento al que se le asigna el presupuesto.
-   **`budget_rubro_id`**: FK al rubro presupuestal.
-   **`year`**: Año para el cual aplica la asignación.
-   **`assigned_amount`**: Monto total asignado.
-   **`justification`**: Justificación o notas sobre la asignación.
-   **`created_by` / `approved_by`**: FK a `users` para auditoría.
-   **`unique_dept_rubro_year`**: Restricción única para evitar duplicados por departamento, rubro y año.

---

## Módulo de Adquisiciones (Procurement)

Flujo completo desde la solicitud interna hasta el pago de facturas.

### `budget_requests`
Solicitudes de presupuesto anual por departamento.
-   **`year`**: Año del presupuesto.
-   **`department_id`**: FK a `departments`.
-   **`status`**: Estado ('borrador', 'en_revision', 'aprobado', 'rechazado').
-   **`total_amount`**: Monto total solicitado.
-   **`approved_amount`**: Monto final aprobado.
-   **`submitted_by` / `approved_by`**: FK a `users`.

### `purchase_requisitions`
Solicitudes internas de compra de materiales.
-   **`pr_number`**: Número único de requisición.
-   **`requisition_type`**: Tipo ('normal', 'urgente').
-   **`department_id`**: FK a `departments`.
-   **`requested_by` / `approved_by`**: FK a `users`.
-   **`budget_request_id`**: FK a `budget_requests` para vincular al presupuesto.
-   **`justification`**: Motivo de la compra.
-   **`status`**: Estado del ciclo de vida de la requisición.
-   **`total_estimated`**: Costo estimado.

### `purchase_requisition_items`
Líneas de detalle de una requisición.
-   **`purchase_requisition_id`**: FK a `purchase_requisitions`.
-   **`material_id`**: FK a `materials`.
-   **`quantity`**: Cantidad solicitada.
-   **`specifications`**: Requerimientos técnicos para este ítem.

### `rfqs` (Request for Quotation)
Solicitudes de cotización enviadas a proveedores.
-   **`rfq_number`**: Número único de RFQ.
-   **`purchase_requisition_id`**: FK a la requisición que la originó.
-   **`status`**: Estado ('borrador', 'enviada', 'evaluando', 'adjudicada').
-   **`submission_deadline`**: Fecha límite para recibir cotizaciones.
-   **`evaluation_method`**: Criterio de selección ('menor_precio', 'mejor_valor').

### `rfq_suppliers`
Registra qué proveedores fueron invitados a una RFQ.
-   **`rfq_id`**: FK a `rfqs`.
-   **`supplier_id`**: FK a `suppliers`.
-   **`status`**: Estado de la invitación ('invitado', 'aceptado', 'cotizo').

### `quotations`
Cotizaciones recibidas de los proveedores.
-   **`quotation_number`**: Número de cotización del proveedor.
-   **`rfq_id`**: FK a la RFQ correspondiente.
-   **`supplier_id`**: FK al proveedor que cotiza.
-   **`valid_until`**: Fecha de validez de la oferta.
-   **`delivery_time_days`**: Plazo de entrega ofrecido.
-   **`total_amount`**: Monto total cotizado.
-   **`status`**: Estado ('recibida', 'evaluada', 'seleccionada', 'rechazada').
-   **`evaluation_score`**: Puntaje de evaluación.
-   **`document_path`**: Ruta al archivo PDF de la cotización.

### `quotation_items`
Líneas de detalle de una cotización.
-   **`quotation_id`**: FK a `quotations`.
-   **`material_id`**: FK a `materials`.
-   **`quantity`**, **`unit_price`**, **`discount_percent`**, **`tax_rate`**: Detalles financieros por línea.
-   **`supplier_sku`**: SKU del proveedor para el material.

### `purchase_orders`
Órdenes de compra formales.
-   **`po_number`**: Número único de orden de compra.
-   **`quotation_id`**: FK a la cotización ganadora.
-   **`supplier_id`**: FK al proveedor.
-   **`subtotal`**, **`tax_total`**, **`total_amount`**: Montos finales.
-   **`expected_delivery_date`**: Fecha de entrega acordada.
-   **`status`**: Estado del ciclo de vida de la orden ('borrador', 'aprobada', 'enviada', 'completada').

### `purchase_order_items`
Líneas de detalle de una orden de compra.
-   **`purchase_order_id`**: FK a `purchase_orders`.
-   **`material_id`**: FK a `materials`.
-   **`quantity`**, **`unit_price`**, **`total_price`**: Valores finales de compra.
-   **`quantity_received`**, **`quantity_rejected`**: Cantidades recibidas y rechazadas.

### `purchase_order_tracking`
Seguimiento logístico de una orden de compra.
-   **`purchase_order_id`**: FK a `purchase_orders`.
-   **`status`**: Estado del envío ('en_produccion', 'embarcado', 'en_transito', 'entregado').
-   **`tracking_number`**: Número de seguimiento del transportista.
-   **`carrier`**: Nombre del transportista.

### `receipts`
Registro de recepción de mercancías.
-   **`receipt_number`**: Número único de recepción.
-   **`purchase_order_id`**: FK a la orden de compra.
-   **`received_by`**: FK al usuario que recibe.
-   **`receipt_date`**: Fecha de recepción.
-   **`delivery_note_number`**: Número de guía o remisión del proveedor.

### `receipt_items`
Líneas de detalle de una recepción.
-   **`receipt_id`**: FK a `receipts`.
-   **`purchase_order_item_id`**: FK al ítem de la orden de compra.
-   **`quantity_received`**: Cantidad física recibida.
-   **`quantity_accepted` / `quantity_rejected`**: Cantidades tras la inspección de calidad.
-   **`batch_number` / `expiry_date`**: Trazabilidad del lote.

### `quality_inspections`
Inspecciones de control de calidad.
-   **`inspection_number`**: Número único de inspección.
-   **`receipt_item_id`**: FK al ítem recibido que se está inspeccionando.
-   **`inspected_by`**: FK al usuario inspector.
-   **`grammage_test`**, **`thickness_test`**, etc.: Resultados de pruebas específicas para papel.
-   **`result`**: Resultado final ('aprobado', 'rechazado', 'cuarentena').
-   **`defect_description`**: Descripción de los defectos encontrados.

### `supplier_invoices`
Facturas emitidas por los proveedores.
-   **`invoice_number`**: Número de factura del proveedor.
-   **`purchase_order_id`**: FK a la orden de compra asociada.
-   **`invoice_date` / `due_date`**: Fechas de la factura.
-   **`total_amount`**: Monto a pagar.
-   **`payment_status`**: Estado del pago ('pendiente', 'pagada', 'vencida').

### `payments`
Pagos realizados a proveedores.
-   **`payment_number`**: Número único de pago.
-   **`supplier_invoice_id`**: FK a la factura que se está pagando.
-   **`payment_method`**: Método ('transferencia', 'cheque').
-   **`amount`**: Monto pagado.
-   **`payment_date`**: Fecha del pago.
-   **`reference_number`**: Referencia de la transacción bancaria.

---

## Vistas

### `supplier_performance_daily`
Vista materializada para agregar métricas de rendimiento de proveedores, facilitando la generación de KPIs.
