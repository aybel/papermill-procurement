<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Creates a materialized view for supplier performance metrics.
     * This view aggregates daily data for KPI tracking.
     */
    public function up(): void
    {
        DB::statement("
            CREATE OR REPLACE VIEW supplier_performance_daily AS
            SELECT
                s.id as supplier_id,
                s.name,
                DATE(r.received_at) as date,
                COUNT(DISTINCT po.id) as total_orders,
                SUM(poi.quantity) as total_quantity,
                SUM(poi.total_price) as total_spent,
                AVG(CASE WHEN qi.overall_status = 'passed' THEN 1.0 ELSE 0.0 END) as quality_rate,
                AVG(CASE WHEN r.received_at <= po.expected_delivery THEN 1.0 ELSE 0.0 END) as on_time_delivery_rate
            FROM suppliers s
            JOIN purchase_orders po ON po.supplier_id = s.id
            JOIN purchase_order_items poi ON poi.purchase_order_id = po.id
            LEFT JOIN receipts r ON r.purchase_order_id = po.id
            LEFT JOIN quality_inspections qi ON qi.receipt_id = r.id
            GROUP BY s.id, s.name, DATE(r.received_at)
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS supplier_performance_daily');
    }
};
