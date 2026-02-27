<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSupplierContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'supplier_id' => 'sometimes|required|exists:suppliers,id',
            'name' => 'sometimes|required|string|max:150',
            'email' => 'nullable|email|max:150',
            'phone' => 'nullable|string|max:20',
            'mobile' => 'nullable|string|max:20',
            'position' => 'nullable|string|max:100',
            'department' => 'nullable|string|max:100',
            'is_primary' => 'boolean',
            'is_active' => 'boolean',
            'notes' => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'supplier_id.required' => 'El proveedor es obligatorio.',
            'supplier_id.exists' => 'El proveedor seleccionado no existe.',
            'name.required' => 'El nombre es obligatorio.',
            'name.max' => 'El nombre no debe exceder 150 caracteres.',
            'email.email' => 'El email no tiene un formato válido.',
            'email.max' => 'El email no debe exceder 150 caracteres.',
            'phone.max' => 'El teléfono no debe exceder 20 caracteres.',
            'mobile.max' => 'El móvil no debe exceder 20 caracteres.',
            'position.max' => 'El puesto no debe exceder 100 caracteres.',
            'department.max' => 'El departamento no debe exceder 100 caracteres.',
            'notes.max' => 'Las notas no deben exceder 500 caracteres.',
            'is_primary.boolean' => 'El campo "principal" debe ser verdadero o falso.',
            'is_active.boolean' => 'El campo "activo" debe ser verdadero o falso.',
        ];
    }
}
