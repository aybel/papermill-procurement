<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBudgetRequestItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'budget_request_id' => 'required|integer|exists:budget_requests,id',
            'material_id' => 'required|integer|exists:materials,id',
            'quantity' => 'required|numeric|min:0',
            'estimated_unit_price' => 'required|numeric|min:0',
            'technical_specifications' => 'nullable|string',
            'quality_requirements' => 'nullable|string',
            'justification' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'budget_request_id.required' => 'La solicitud de presupuesto es obligatoria.',
            'budget_request_id.exists' => 'La solicitud de presupuesto no existe.',
            'material_id.required' => 'El material es obligatorio.',
            'material_id.exists' => 'El material no existe.',
            'quantity.required' => 'La cantidad es obligatoria.',
            'quantity.numeric' => 'La cantidad debe ser numérica.',
            'quantity.min' => 'La cantidad no puede ser negativa.',
            'estimated_unit_price.required' => 'El precio unitario es obligatorio.',
            'estimated_unit_price.numeric' => 'El precio unitario debe ser numérico.',
            'estimated_unit_price.min' => 'El precio unitario no puede ser negativo.',
        ];
    }
}
