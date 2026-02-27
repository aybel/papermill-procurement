<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'sku',
        'name',
        'description',
        'category_id',
        'material_type_id',
        'unit_of_measure_id',
        'current_stock',
        'min_stock',
        'max_stock',
        'safety_stock',
        'avg_unit_cost',
        'last_purchase_price',
        'currency_id',
        'grammage',
        'width',
        'length',
        'color',
    ];

    protected $casts = [
        'current_stock' => 'decimal:4',
        'min_stock' => 'decimal:4',
        'max_stock' => 'decimal:4',
        'safety_stock' => 'decimal:4',
        'reorder_point' => 'decimal:4',
        'avg_unit_cost' => 'decimal:4',
        'last_purchase_price' => 'decimal:4',
        'grammage' => 'decimal:2',
        'width' => 'decimal:2',
        'length' => 'decimal:2',
    ];

    /**
     * Relación con la categoría del material.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(MaterialCategory::class, 'category_id');
    }

    /**
     * Relación con la moneda usada para costos.
     */
    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    /**
     * Relación con el tipo de material.
     */
    public function materialType(): BelongsTo
    {
        return $this->belongsTo(MaterialType::class);
    }

    /**
     * Relación con la unidad de medida.
     */
    public function unitOfMeasure(): BelongsTo
    {
        return $this->belongsTo(UnitOfMeasure::class);
    }
}
