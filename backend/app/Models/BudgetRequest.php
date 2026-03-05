<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BudgetRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_number',
        'year',
        'department_id',
        'budget_request_status_id',
        'submitted_by',
        'approved_by',
        'submitted_at',
        'approved_at',
        'notes',
    ];

    protected $casts = [
        'year' => 'integer',
        'submitted_at' => 'datetime',
        'approved_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (BudgetRequest $request) {
            // Genera request_number con patrón YYYY-####, secuencial por año.
            $year = $request->year ?? now()->year;

            if (! $request->request_number) {
                $request->request_number = DB::transaction(function () use ($year) {
                    $last = static::where('year', $year)
                        ->lockForUpdate()
                        ->max('request_number');

                    $lastSeq = 0;
                    if ($last && str_contains($last, '-')) {
                        [, $seq] = explode('-', $last, 2);
                        $lastSeq = (int) ltrim($seq, '0');
                    }

                    $nextSeq = $lastSeq + 1;

                    return sprintf('%s-%04d', $year, $nextSeq);
                });
            }

            $request->year = $year;
        });
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(BudgetRequestStatus::class, 'budget_request_status_id');
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function submittedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'submitted_by');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function items(): HasMany
    {
        return $this->hasMany(BudgetRequestItem::class);
    }
}
