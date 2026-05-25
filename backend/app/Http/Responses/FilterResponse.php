<?php
namespace App\Http\Responses;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class FilterResponse
{
    public function __construct(
        public readonly array $data,
        public readonly array $meta
    ) {}

    public static function fromPaginator(LengthAwarePaginator $paginator): self
    {
        return new self(
            data: $paginator->items(),
            meta: [
                'total' => $paginator->total(),
                'per_page' => $paginator->perPage(),
                'current_page' => $paginator->currentPage(),
                'last_page' => $paginator->lastPage(),
                'from' => $paginator->firstItem(),
                'to' => $paginator->lastItem(),
                'is_paginated' => true,
            ]
        );
    }

    public static function fromCollection(Collection $collection): self
    {
        return new self(
            data: $collection->values()->toArray(),
            meta: [
                'total' => $collection->count(),
                'is_paginated' => false,
            ]
        );
    }

    public function toResponse(): array
    {
        return [
            'success' => true,
            'data' => $this->data,
            'meta' => $this->meta,
        ];
    }
}
