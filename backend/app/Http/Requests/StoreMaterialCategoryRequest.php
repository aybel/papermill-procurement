<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMaterialCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:100',
            'parent_id' => 'nullable|exists:material_categories,id',
            'attributes' => 'nullable|array',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'name.max' => 'El nombre no debe exceder 100 caracteres.',
            'parent_id.exists' => 'La categoría padre seleccionada no existe.',
            'attributes.array' => 'Los atributos deben enviarse como objeto/array.',
        ];
    }
}
