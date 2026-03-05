<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBudgetRequestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'year' => 'required|integer|digits:4',
            'department_id' => 'required|integer|exists:departments,id',
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
            'submitted_by.exists' => 'El usuario que envía no existe.',
            'approved_by.exists' => 'El usuario aprobador no existe.',
            'submitted_at.date' => 'La fecha de envío debe ser válida.',
            'approved_at.date' => 'La fecha de aprobación debe ser válida.',
        ];
    }
}
