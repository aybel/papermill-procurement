<?php

namespace App\DTOs\Read\BudgetRequest;

use App\Models\BudgetRequest;

class BudgetRequestListItemDTO
{
    public function __construct(
        public readonly int $id,
        public readonly string $requestNumber,
        public readonly int $year,
        public readonly ?int $departmentId,
        public readonly ?string $departmentCode,
        public readonly ?string $departmentName,
        public readonly ?int $statusId,
        public readonly ?string $statusName,
        public readonly string $submittedAt,
        public readonly string $approvedAt,
        public readonly string $createdAt,
        public readonly string $updatedAt,
        public readonly float $estimatedTotal,
        public readonly string $notes,
    ) {
    }

    public static function fromModel(BudgetRequest $budgetRequest): self
    {
        $submittedAt = $budgetRequest->submitted_at?->toISOString();
        $approvedAt = $budgetRequest->approved_at?->toISOString();
        $createdAt = $budgetRequest->created_at?->toISOString();
        $updatedAt = $budgetRequest->updated_at?->toISOString();

        // In list endpoints this uses relation data when loaded and avoids extra queries.
        $estimatedTotal = (float) ($budgetRequest->relationLoaded('items')
            ? $budgetRequest->items->sum(fn ($item) => (float) $item->quantity * (float) $item->estimated_unit_price)
            : 0.0);

        return new self(
            id: $budgetRequest->id,
            requestNumber: (string) ($budgetRequest->request_number ?? ''),
            year: (int) $budgetRequest->year,
            departmentId: $budgetRequest->department?->id,
            departmentCode: $budgetRequest->department?->code,
            departmentName: $budgetRequest->department?->name,
            statusId: $budgetRequest->status?->id,
            statusName: $budgetRequest->status?->name,
            submittedAt: $submittedAt ?? '',
            approvedAt: $approvedAt ?? '',
            createdAt: $createdAt ?? '',
            updatedAt: $updatedAt ?? '',
            estimatedTotal: $estimatedTotal,
            notes: (string) ($budgetRequest->notes ?? ''),
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'request_number' => $this->requestNumber,
            'year' => $this->year,
            'department' => [
                'id' => $this->departmentId,
                'code' => $this->departmentCode,
                'name' => $this->departmentName,
            ],
            'status' => [
                'id' => $this->statusId,
                'name' => $this->statusName,
            ],
            'submitted_at' => $this->submittedAt,
            'approved_at' => $this->approvedAt,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
            'estimated_total' => $this->estimatedTotal,
            'notes' => $this->notes,
        ];
    }
}
