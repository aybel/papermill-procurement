<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MaterialType extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'description',
        'attributes',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'attributes' => 'array',
        'sort_order' => 'integer',
    ];

    /**
     * Materiales asociados a este tipo.
     */
    public function materials(): HasMany
    {
        return $this->hasMany(Material::class);
    }
}
