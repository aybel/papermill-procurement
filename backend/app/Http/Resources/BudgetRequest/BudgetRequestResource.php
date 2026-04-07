<?php

namespace App\Http\Resources\BudgetRequest;

use App\DTOs\Read\BudgetRequest\BudgetRequestListItemDTO;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BudgetRequestResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        if ($this->resource instanceof BudgetRequestListItemDTO) {
            return $this->resource->toArray();
        }

        $estimatedTotal = (float) $this->resource->items->sum(
            fn ($item) => (float) $item->quantity * (float) $item->estimated_unit_price
        );

        return [
            'id' => $this->resource->id,
            'request_number' => $this->resource->request_number,
            'year' => $this->resource->year,
            'department' => [
                'id' => $this->resource->department?->id,
                'code' => $this->resource->department?->code,
                'name' => $this->resource->department?->name,
            ],
            'status' => [
                'id' => $this->resource->status?->id,
                'name' => $this->resource->status?->name,
                'description' => $this->resource->status?->description,
            ],
            'category' => $this->resource->budgetCategory ? [
                'id' => $this->resource->budgetCategory->id,
                'name' => $this->resource->budgetCategory->name,
            ] : null,
            'submittedBy' => $this->resource->submittedBy ? [
                'id' => $this->resource->submittedBy->id,
                'name' => $this->resource->submittedBy->name,
                'email' => $this->resource->submittedBy->email,
            ] : null,
            'approvedBy' => $this->resource->approvedBy ? [
                'id' => $this->resource->approvedBy->id,
                'name' => $this->resource->approvedBy->name,
                'email' => $this->resource->approvedBy->email,
            ] : null,
            'department_name' => $this->resource->department?->name,
            'category_name' => $this->resource->budgetCategory?->name,
            'status_name' => $this->resource->status?->name,
            'submitted_by' => $this->resource->submitted_by?->name,
            'approved_by' => $this->resource->approved_by?->name,
            'created' => $this->resource->created,
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at,
            'notes' => $this->resource->notes,
            'estimated_total' => $estimatedTotal,
            'items' => $this->resource->items->map(function ($item) {
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
            }),
        ];
    }
}
