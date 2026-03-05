<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PermissionCollection extends ResourceCollection
{
    public function toArray(Request $request): array
    {
        return [
            'data' => PermissionResource::collection($this->collection),
        ];
    }
}
