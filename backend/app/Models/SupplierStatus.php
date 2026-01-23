<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SupplierStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'color',
        'description',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    /**
     * Relación con proveedores
     */
    public function suppliers(): HasMany
    {
        return $this->hasMany(Supplier::class);
    }
    /**
     * Scope para filtrar estados activos
     */
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}
