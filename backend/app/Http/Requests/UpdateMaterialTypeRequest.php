<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMaterialTypeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'code' => 'sometimes|required|string|max:50|unique:material_types,code,' . $id,
            'name' => 'sometimes|required|string|max:100',
            'description' => 'nullable|string|max:255',
            'attributes' => 'nullable|array',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'code.required' => 'El código es obligatorio.',
            'code.max' => 'El código no debe exceder 50 caracteres.',
            'code.unique' => 'Ya existe un tipo con ese código.',
            'name.required' => 'El nombre es obligatorio.',
            'name.max' => 'El nombre no debe exceder 100 caracteres.',
            'description.max' => 'La descripción no debe exceder 255 caracteres.',
            'attributes.array' => 'Los atributos deben enviarse como objeto/array.',
            'sort_order.integer' => 'El orden debe ser un número entero.',
            'sort_order.min' => 'El orden no puede ser negativo.',
            'is_active.boolean' => 'El campo "activo" debe ser verdadero o falso.',
        ];
    }
}
