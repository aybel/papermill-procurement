<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBudgetRequestRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $departmentId = $this->user()?->department_id;

        if ($departmentId !== null) {
            $this->merge([
                'department_id' => $departmentId,
            ]);
        }

        $this->merge([
            'budget_request_status_id' => 1, // Asignar el estado "Borrador" por defecto
        ]);
    }

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'year' => 'required|integer|digits:4',
            'department_id' => 'required|integer|exists:departments,id',
            'budget_category_id' => 'required|integer|exists:budget_categories,id',
            'created' => 'required|date',
            'budget_request_status_id' => 'required|integer|exists:budget_request_statuses,id',
            'submitted_by' => 'nullable|integer|exists:users,id',
            'approved_by' => 'nullable|integer|exists:users,id',
            'submitted_at' => 'nullable|date',
            'approved_at' => 'nullable|date',
            'notes' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'year.required' => 'El año es obligatorio.',
            'year.digits' => 'El año debe tener 4 dígitos.',
            'department_id.required' => 'El departamento es obligatorio.',
            'department_id.exists' => 'El departamento seleccionado no existe.',
            'budget_request_status_id.required' => 'El estado es obligatorio.',
            'budget_request_status_id.exists' => 'El estado seleccionado no existe.',
            'budget_request_status_id.integer' => 'El estado debe ser un número entero.',
            'submitted_by.exists' => 'El usuario que envía no existe.',
            'approved_by.exists' => 'El usuario aprobador no existe.',
            'budget_category_id.exists' => 'La categoría de presupuesto seleccionada no existe.',
            'budget_category_id.required' => 'La categoría de presupuesto es obligatoria.',
            'budget_category_id.integer' => 'La categoría de presupuesto debe ser un número entero.',
            'submitted_at.date' => 'La fecha de envío debe ser válida.',
            'approved_at.date' => 'La fecha de aprobación debe ser válida.',
            'created.date' => 'La fecha de creación debe ser válida.',
            'created.required' => 'La fecha de creación es obligatoria.',
        ];
    }
}
