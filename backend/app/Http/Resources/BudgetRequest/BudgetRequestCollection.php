<?php

namespace App\Http\Resources\BudgetRequest;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\LengthAwarePaginator;

class BudgetRequestCollection extends ResourceCollection
{
    public function toArray(Request $request): array
    {
        $isPaginated = $this->resource instanceof LengthAwarePaginator;

        $data = [
            'items' => BudgetRequestResource::collection($this->collection)->resolve($request),
        ];

        if ($isPaginated) {
            $data['pagination'] = [
                'current_page' => $this->resource->currentPage(),
                'last_page' => $this->resource->lastPage(),
                'per_page' => $this->resource->perPage(),
                'total' => $this->resource->total(),
            ];
        }

        return $data;
    }
}
