<?php

namespace App\DTOs\Read\BudgetRequest;

use App\Models\BudgetRequest;
use Illuminate\Support\Carbon;

class BudgetRequestListItemDTO
{
    public function __construct(
        public readonly int $id,
        public readonly string $requestNumber,
        public readonly int $year,
        public readonly string $created,
        public readonly ?int $departmentId,
        public readonly ?string $departmentCode,
        public readonly ?string $departmentName,
        public readonly ?int $statusId,
        public readonly ?string $statusName,
        public readonly ?string $statusDescription,
        public readonly ?int $categoryId,
        public readonly ?string $categoryName,
        public readonly ?int $submittedById,
        public readonly ?string $submittedByName,
        public readonly ?string $submittedByEmail,
        public readonly ?int $approvedById,
        public readonly ?string $approvedByName,
        public readonly ?string $approvedByEmail,
        public readonly string $submittedAt,
        public readonly string $approvedAt,
        public readonly string $createdAt,
        public readonly string $updatedAt,
        public readonly float $estimatedTotal,
        public readonly string $notes,
        public readonly array $items,
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

        $items = $budgetRequest->relationLoaded('items')
            ? $budgetRequest->items->map(function ($item) {
                return [
                    'id' => $item->id,
                    'material_id' => $item->material_id,
                    'material_name' => $item->material?->name,
                    'quantity' => (float) $item->quantity,
                    'estimated_unit_price' => (float) $item->estimated_unit_price,
                    'line_total' => (float) $item->quantity * (float) $item->estimated_unit_price,
                    'technical_specifications' => $item->technical_specifications,
                    'quality_requirements' => $item->quality_requirements,
                    'justification' => $item->justification,
                ];
            })->values()->all()
            : [];

        return new self(
            id: $budgetRequest->id,
            requestNumber: (string) ($budgetRequest->request_number ?? ''),
            year: (int) $budgetRequest->year,
            created: (string) ($budgetRequest->created ?? ''),
            departmentId: $budgetRequest->department?->id,
            departmentCode: $budgetRequest->department?->code,
            departmentName: $budgetRequest->department?->name,
            statusId: $budgetRequest->status?->id,
            statusName: $budgetRequest->status?->name,
            statusDescription: $budgetRequest->status?->description,
            categoryId: $budgetRequest->budgetCategory?->id,
            categoryName: $budgetRequest->budgetCategory?->name,
            submittedById: $budgetRequest->submittedBy?->id,
            submittedByName: $budgetRequest->submittedBy?->name,
            submittedByEmail: $budgetRequest->submittedBy?->email,
            approvedById: $budgetRequest->approvedBy?->id,
            approvedByName: $budgetRequest->approvedBy?->name,
            approvedByEmail: $budgetRequest->approvedBy?->email,
            submittedAt: $submittedAt ?? '',
            approvedAt: $approvedAt ?? '',
            createdAt: $createdAt ?? '',
            updatedAt: $updatedAt ?? '',
            estimatedTotal: $estimatedTotal,
            notes: (string) ($budgetRequest->notes ?? ''),
            items: $items,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'request_number' => $this->requestNumber,
            'year' => $this->year,
            'created' => $this->created,
            'department' => [
                'id' => $this->departmentId,
                'code' => $this->departmentCode,
                'name' => $this->departmentName,
            ],
            'status' => [
                'id' => $this->statusId,
                'name' => $this->statusName,
                'description' => $this->statusDescription,
            ],
            'category' => $this->categoryId !== null ? [
                'id' => $this->categoryId,
                'name' => $this->categoryName,
            ] : null,
            'submittedBy' => $this->submittedById !== null ? [
                'id' => $this->submittedById,
                'name' => $this->submittedByName,
                'email' => $this->submittedByEmail,
            ] : null,
            'approvedBy' => $this->approvedById !== null ? [
                'id' => $this->approvedById,
                'name' => $this->approvedByName,
                'email' => $this->approvedByEmail,
            ] : null,
            'department_name' => $this->departmentName,
            'category_name' => $this->categoryName,
            'status_name' => $this->statusName,
            'submitted_by' => $this->submittedByName,
            'approved_by' => $this->approvedByName,
            'submitted_at' => $this->submittedAt,
            'approved_at' => $this->approvedAt,
            'created_at' => Carbon::parse($this->createdAt)->isoFormat('D [de] MMMM [del] YYYY'),
            'updated_at' => Carbon::parse($this->updatedAt)->isoFormat('D [de] MMMM [del] YYYY'),
            'estimated_total' => number_format($this->estimatedTotal,2,'.',','),
            'notes' => $this->notes,
            'items' => $this->items,
        ];
    }
}
