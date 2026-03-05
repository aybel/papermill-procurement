<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BudgetAssignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'department_id',
        'budget_category_id',
        'year',
        'assigned_amount',
        'justification',
        'created_by',
        'approved_by',
    ];

    protected $casts = [
        'year' => 'integer',
        'assigned_amount' => 'decimal:4',
        'created_by' => 'integer',
        'approved_by' => 'integer',
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(BudgetCategory::class, 'budget_category_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
