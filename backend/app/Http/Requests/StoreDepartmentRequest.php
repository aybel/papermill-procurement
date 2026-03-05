<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDepartmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code' => 'required|string|max:20|unique:departments,code',
            'name' => 'required|string|max:150|unique:departments,name',
            'is_active' => 'in:0,1',
        ];
    }

    public function messages(): array
    {
        return [
            'code.required' => 'El código es obligatorio.',
            'code.max' => 'El código no debe exceder 20 caracteres.',
            'code.unique' => 'Ya existe un departamento con ese código.',
            'name.required' => 'El nombre es obligatorio.',
            'name.max' => 'El nombre no debe exceder 150 caracteres.',
            'name.unique' => 'Ya existe un departamento con ese nombre.',
            'is_active.in' => 'El campo "activo" solo admite 0 o 1.',
        ];
    }
}
