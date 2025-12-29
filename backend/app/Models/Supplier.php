<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'tax_id',
        'supplier_type_id',
        'supplier_status_id',
        'primary_contact_id',
        'quality_score',
        'delivery_score',
        'payment_terms_id',
        'currency_id',
        'credit_limit',
        'notes',
    ];

    protected $casts = [
        'quality_score' => 'decimal:2',
        'delivery_score' => 'decimal:2',
        'credit_limit' => 'decimal:2',
        'deleted_at' => 'datetime',
    ];

    protected $appends = [
        'overall_score',
    ];

    /**
     * Relación con el tipo de proveedor
     */
    public function supplierType(): BelongsTo
    {
        return $this->belongsTo(SupplierType::class);
    }

    /**
     * Relación con el estado del proveedor
     */
    public function supplierStatus(): BelongsTo
    {
        return $this->belongsTo(SupplierStatus::class);
    }

    /**
     * Relación con el contacto principal
     */
    public function primaryContact(): BelongsTo
    {
        return $this->belongsTo(SupplierContact::class, 'primary_contact_id');
    }

    /**
     * Relación con todos los contactos del proveedor
     */
    public function contacts(): HasMany
    {
        return $this->hasMany(SupplierContact::class);
    }

    /**
     * Relación con los términos de pago
     */
    public function paymentTerms(): BelongsTo
    {
        return $this->belongsTo(PaymentTerm::class, 'payment_terms_id');
    }

    /**
     * Relación con la moneda
     */
    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    /**
     * Relación con las órdenes de compra
     */
    public function purchaseOrders(): HasMany
    {
        return $this->hasMany(PurchaseOrder::class);
    }

    /**
     * Accessor para calcular el score general al vuelo
     */
    public function getOverallScoreAttribute(): float
    {
        return round(($this->quality_score + $this->delivery_score) / 2, 2);
    }

    /**
     * Scope para filtrar por estado activo
     */
    public function scopeActive($query)
    {
        return $query->where('supplier_status_id', 1);
    }

    /**
     * Scope para filtrar por tipo de proveedor
     */
    public function scopeOfType($query, $typeId)
    {
        return $query->where('supplier_type_id', $typeId);
    }

    /**
     * Scope para buscar por código o nombre
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('code', 'like', "%{$search}%")
              ->orWhere('name', 'like', "%{$search}%")
              ->orWhere('tax_id', 'like', "%{$search}%");
        });
    }
}
