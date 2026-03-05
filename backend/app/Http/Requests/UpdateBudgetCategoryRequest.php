<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBudgetCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'name' => 'sometimes|required|string|max:100|unique:budget_categories,name,' . $id,
            'description' => 'nullable|string',
            'is_active' => 'in:0,1',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'name.max' => 'El nombre no debe exceder 100 caracteres.',
            'name.unique' => 'Ya existe una categoría con ese nombre.',
            'description.string' => 'La descripción debe ser texto válido.',
            'is_active.in' => 'El campo "activo" solo admite 0 o 1.',
        ];
    }
}
