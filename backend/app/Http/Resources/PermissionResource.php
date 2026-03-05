<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PermissionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'full_name' => $this->name,
            'resource' => $this->resource,
            'action' => $this->action,
            'category' => $this->category,
            'description' => $this->description,
            'icon' => $this->icon,
        ];
    }
}
