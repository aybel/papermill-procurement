<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UnitOfMeasure extends Model
{
    use HasFactory;

    protected $table = 'units_of_measure';

    protected $fillable = [
        'code',
        'name',
        'symbol',
        'category',
        'conversion_factor',
        'base_unit_id',
        'is_base_unit',
        'decimal_places',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_base_unit' => 'boolean',
        'conversion_factor' => 'decimal:6',
        'decimal_places' => 'integer',
    ];

    /**
     * Materiales que usan esta unidad.
     */
    public function materials(): HasMany
    {
        return $this->hasMany(Material::class);
    }
}
