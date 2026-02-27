<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSupplierStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:100|unique:supplier_statuses,name',
            'code' => 'required|string|max:50|unique:supplier_statuses,code',
            'color' => 'nullable|string|max:20',
            'description' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'name.max' => 'El nombre no debe exceder 100 caracteres.',
            'name.unique' => 'Ya existe un estado con ese nombre.',
            'code.required' => 'El código es obligatorio.',
            'code.max' => 'El código no debe exceder 50 caracteres.',
            'code.unique' => 'Ya existe un estado con ese código.',
            'color.max' => 'El color no debe exceder 20 caracteres.',
            'description.max' => 'La descripción no debe exceder 255 caracteres.',
            'is_active.boolean' => 'El campo "activo" debe ser verdadero o falso.',
        ];
    }
}
