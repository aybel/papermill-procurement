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
            'submitted_by' => $this->resource->submitted_by,
            'approved_by' => $this->resource->approved_by,
            'submitted_at' => $this->resource->submitted_at?->toISOString(),
            'approved_at' => $this->resource->approved_at?->toISOString(),
            'created_at' => $this->resource->created_at?->toISOString(),
            'updated_at' => $this->resource->updated_at?->toISOString(),
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
