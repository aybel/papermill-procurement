<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSupplierTypeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'name' => 'sometimes|required|string|max:100|unique:supplier_types,name,' . $id,
            'code' => 'sometimes|required|string|max:50|unique:supplier_types,code,' . $id,
            'description' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'name.max' => 'El nombre no debe exceder 100 caracteres.',
            'name.unique' => 'Ya existe un tipo de proveedor con ese nombre.',
            'code.required' => 'El código es obligatorio.',
            'code.max' => 'El código no debe exceder 50 caracteres.',
            'code.unique' => 'Ya existe un tipo de proveedor con ese código.',
            'description.max' => 'La descripción no debe exceder 255 caracteres.',
            'is_active.boolean' => 'El campo "activo" debe ser verdadero o falso.',
        ];
    }
}
