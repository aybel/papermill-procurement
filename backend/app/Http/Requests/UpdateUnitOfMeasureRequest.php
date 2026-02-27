<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUnitOfMeasureRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'code' => 'sometimes|required|string|max:50|unique:units_of_measure,code,' . $id,
            'name' => 'sometimes|required|string|max:100',
            'symbol' => 'nullable|string|max:20',
            'category' => 'nullable|string|max:50',
            'conversion_factor' => 'nullable|numeric|min:0',
            'base_unit_id' => 'nullable|exists:units_of_measure,id',
            'is_base_unit' => 'boolean',
            'decimal_places' => 'nullable|integer|min:0|max:6',
            'description' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'code.required' => 'El código es obligatorio.',
            'code.max' => 'El código no debe exceder 50 caracteres.',
            'code.unique' => 'Ya existe una unidad con ese código.',
            'name.required' => 'El nombre es obligatorio.',
            'name.max' => 'El nombre no debe exceder 100 caracteres.',
            'symbol.max' => 'El símbolo no debe exceder 20 caracteres.',
            'category.max' => 'La categoría no debe exceder 50 caracteres.',
            'conversion_factor.numeric' => 'El factor de conversión debe ser numérico.',
            'conversion_factor.min' => 'El factor de conversión debe ser mayor o igual a 0.',
            'base_unit_id.exists' => 'La unidad base seleccionada no existe.',
            'is_base_unit.boolean' => 'El campo "unidad base" debe ser verdadero o falso.',
            'decimal_places.integer' => 'Los decimales deben ser un número entero.',
            'decimal_places.min' => 'Los decimales no pueden ser negativos.',
            'decimal_places.max' => 'Los decimales no pueden exceder 6 posiciones.',
            'description.max' => 'La descripción no debe exceder 255 caracteres.',
            'is_active.boolean' => 'El campo "activo" debe ser verdadero o falso.',
        ];
    }
}
