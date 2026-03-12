<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MenuItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => data_get($this->resource, 'id'),
            'semantic_key' => data_get($this->resource, 'semantic_key'),
            'type' => data_get($this->resource, 'type'),
            'name' => data_get($this->resource, 'name'),
            'icon' => data_get($this->resource, 'icon'),
            'permission' => data_get($this->resource, 'permission'),
            'route' => data_get($this->resource, 'route'),
            'children' => self::collection(collect(data_get($this->resource, 'children', []))),
        ];
    }
}
