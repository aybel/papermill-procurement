<?php

namespace App\Http\Resources;

use App\Http\Resources\MenuItemResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class MenuCollection extends ResourceCollection
{
    public function toArray(Request $request): array
    {
        return [
            'menu' => MenuItemResource::collection($this->collection),
            'version' => '1.0',
            'semantic_version' => '2024.1',
        ];
    }
}
