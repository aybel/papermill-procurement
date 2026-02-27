<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePaymentTermRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'code' => 'sometimes|required|string|max:50|unique:payment_terms,code,' . $id,
            'name' => 'sometimes|required|string|max:100',
            'days' => 'sometimes|required|integer|min:0',
            'description' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'code.required' => 'El código es obligatorio.',
            'code.max' => 'El código no debe exceder 50 caracteres.',
            'code.unique' => 'Ya existe un término de pago con ese código.',
            'name.required' => 'El nombre es obligatorio.',
            'name.max' => 'El nombre no debe exceder 100 caracteres.',
            'days.required' => 'Los días son obligatorios.',
            'days.integer' => 'Los días deben ser un número entero.',
            'days.min' => 'Los días deben ser mayores o iguales a 0.',
            'description.max' => 'La descripción no debe exceder 255 caracteres.',
            'is_active.boolean' => 'El campo "activo" debe ser verdadero o falso.',
        ];
    }
}
