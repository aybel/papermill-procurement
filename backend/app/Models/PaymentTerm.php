<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaymentTerm extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'days',
        'description',
        'is_active',
    ];

    protected $casts = [
        'days' => 'integer',
        'active' => 'boolean',
    ];

    /**
     * Relación con proveedores
     */
    public function suppliers(): HasMany
    {
        return $this->hasMany(Supplier::class, 'payment_terms_id');
    }
}
