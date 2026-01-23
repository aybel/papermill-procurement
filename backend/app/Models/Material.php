<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'sku', 'name', 'description', 'category_id', 'material_type', 'unit_of_measure',
        'current_stock', 'min_stock', 'max_stock', 'safety_stock', 'avg_unit_cost',
        'last_purchase_price', 'currency_id', 'grammage', 'width', 'length', 'color'
    ];
}
