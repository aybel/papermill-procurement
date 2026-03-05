<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'department_id' => 'required|integer|exists:departments,id',
            'roles' => 'required|array|min:1',
            'roles.*' => 'string|exists:roles,name',
            'accessible_departments' => 'nullable|array',
            'accessible_departments.*.department_id' => 'required|integer|exists:departments,id',
            'accessible_departments.*.role' => 'required|in:viewer,manager,approver',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre es requerido',
            'email.required' => 'El email es requerido',
            'email.email' => 'El email debe ser válido',
            'email.unique' => 'El email ya está registrado',
            'password.required' => 'La contraseña es requerida',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres',
            'department_id.required' => 'El departamento es requerido',
            'department_id.exists' => 'El departamento seleccionado no existe',
            'roles.required' => 'Debe asignar al menos un rol',
            'roles.min' => 'Debe asignar al menos un rol',
            'roles.*.string' => 'Los roles deben ser nombres (strings), no IDs. Ejemplo: ["Jefe de Compras", "Aprobador"]',
            'roles.*.exists' => 'Uno o más roles no existen. Envía el nombre del rol, no el ID.',
            'accessible_departments.*.department_id.exists' => 'Uno o más departamentos accesibles no existen',
            'accessible_departments.*.role.in' => 'El rol de departamento debe ser: viewer, manager o approver',
        ];
    }
}
