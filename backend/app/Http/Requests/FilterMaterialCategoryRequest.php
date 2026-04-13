<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FilterMaterialCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'filters' => 'sometimes|array',
            'filters.*.field' => 'required|string|in:id,name,parent_id,created_at,updated_at',
            'filters.*.operator' => 'required|string|in:eq,ne,gt,gte,lt,lte,like,ilike,in,nin,null,notnull,between,startsWith,endsWith',
            'filters.*.value' => 'required_unless:filters.*.operator,null,notnull',

            'order_by' => 'sometimes|array',
            'order_by.column' => 'required_with:order_by|string|in:id,name,parent_id,created_at,updated_at',
            'order_by.direction' => 'required_with:order_by|string|in:asc,desc',

            'pagination' => 'sometimes|array',
            'pagination.page' => 'sometimes|integer|min:1',
            'pagination.limit' => 'sometimes|integer|min:1|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'filters.*.field.in' => 'El campo :input no está permitido para filtrado',
            'filters.*.operator.in' => 'El operador :input no es válido',
            'filters.*.value.required_unless' => 'El valor es requerido para este operador',
            'order_by.column.in' => 'La columna :input no está permitida para ordenamiento',
            'pagination.limit.max' => 'El límite no puede ser mayor a 100 registros',
        ];
    }
}
