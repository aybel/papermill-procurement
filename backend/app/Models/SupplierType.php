<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SupplierType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Relación con proveedores
     */
    public function suppliers(): HasMany
    {
        return $this->hasMany(Supplier::class);
    }
    /**
     * Scope para filtrar tipos activos
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
