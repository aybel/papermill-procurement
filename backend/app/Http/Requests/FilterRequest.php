<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FilterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'filters' => 'sometimes|array',
            'filters.*.field' => 'required|string',
            'filters.*.operator' => 'required|string|in:eq,ne,gt,gte,lt,lte,like,ilike,in,nin,null,notnull,between,startsWith,endsWith',
            'filters.*.value' => 'required_unless:filters.*.operator,null,notnull',

            'order_by' => 'sometimes|array',
            'order_by.column' => 'required_with:order_by|string',
            'order_by.direction' => 'required_with:order_by|string|in:asc,desc',

            'pagination' => 'sometimes|array',
            'pagination.page' => 'sometimes|integer|min:1',
            'pagination.limit' => 'sometimes|integer|min:1|max:100',

            // Mantener compatibilidad con 'q'
            'q' => 'sometimes|string|nullable',
        ];
    }

    public function messages(): array
    {
        return [
            'filters.*.operator.in' => 'El operador :input no es válido',
            'order_by.column.required_with' => 'La columna es requerida cuando se especifica ordenamiento',
            'pagination.limit.max' => 'El límite no puede ser mayor a 100',
        ];
    }
}
