<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBudgetAssignmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'department_id' => 'required|integer|exists:departments,id',
            'budget_category_id' => 'required|integer|exists:budget_categories,id',
            'year' => [
                'required',
                'integer',
                'digits:4',
                Rule::unique('budget_assignments')->where(function ($query) {
                    return $query
                        ->where('department_id', $this->department_id)
                        ->where('budget_category_id', $this->budget_category_id);
                }),
            ],
            'assigned_amount' => 'required|numeric|min:0',
            'justification' => 'nullable|string',
            'approved_by' => 'nullable|integer|exists:users,id',
        ];
    }

    public function messages(): array
    {
        return [
            'department_id.required' => 'El departamento es obligatorio.',
            'department_id.exists' => 'El departamento seleccionado no existe.',
            'budget_category_id.required' => 'La categoría presupuestaria es obligatoria.',
            'budget_category_id.exists' => 'La categoría presupuestaria seleccionada no existe.',
            'year.required' => 'El año es obligatorio.',
            'year.digits' => 'El año debe tener 4 dígitos.',
            'year.unique' => 'Ya existe una asignación para el mismo departamento, categoría y año.',
            'assigned_amount.required' => 'El monto asignado es obligatorio.',
            'assigned_amount.numeric' => 'El monto asignado debe ser numérico.',
            'assigned_amount.min' => 'El monto asignado no puede ser negativo.',
            'justification.string' => 'La justificación debe ser texto válido.',
            'approved_by.exists' => 'El usuario aprobador no existe.',
        ];
    }
}
