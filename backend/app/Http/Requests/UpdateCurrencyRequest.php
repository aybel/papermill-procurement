<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCurrencyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'code' => 'sometimes|required|string|max:10|unique:currencies,code,' . $id,
            'name' => 'sometimes|required|string|max:100',
            'symbol' => 'nullable|string|max:10',
            'exchange_rate' => 'nullable|numeric|min:0',
            'is_base' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'code.required' => 'El código es obligatorio.',
            'code.max' => 'El código no debe exceder 10 caracteres.',
            'code.unique' => 'Ya existe una moneda con ese código.',
            'name.required' => 'El nombre es obligatorio.',
            'name.max' => 'El nombre no debe exceder 100 caracteres.',
            'symbol.max' => 'El símbolo no debe exceder 10 caracteres.',
            'exchange_rate.numeric' => 'El tipo de cambio debe ser numérico.',
            'exchange_rate.min' => 'El tipo de cambio debe ser mayor o igual a 0.',
            'is_base.boolean' => 'El campo "moneda base" debe ser verdadero o falso.',
            'is_active.boolean' => 'El campo "activo" debe ser verdadero o falso.',
        ];
    }
}
