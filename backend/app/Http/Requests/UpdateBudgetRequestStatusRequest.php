<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBudgetRequestStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'name' => 'sometimes|required|string|max:50|unique:budget_request_statuses,name,' . $id,
            'description' => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'name.max' => 'El nombre no debe exceder 50 caracteres.',
            'name.unique' => 'Ya existe un estado con ese nombre.',
            'description.max' => 'La descripción no debe exceder 255 caracteres.',
        ];
    }
}
