<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMaterialRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $materialId = $this->route('id');

        return [
            'sku' => 'sometimes|required|string|max:50|unique:materials,sku,' . $materialId,
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:material_categories,id',
            'material_type_id' => 'sometimes|required|exists:material_types,id',
            'unit_of_measure_id' => 'sometimes|required|exists:units_of_measure,id',
            'current_stock' => 'nullable|numeric|min:0',
            'min_stock' => 'nullable|numeric|min:0',
            'max_stock' => 'nullable|numeric|min:0',
            'safety_stock' => 'nullable|numeric|min:0',
            'avg_unit_cost' => 'nullable|numeric|min:0',
            'last_purchase_price' => 'nullable|numeric|min:0',
            'currency_id' => 'sometimes|required|exists:currencies,id',
            'grammage' => 'nullable|numeric|min:0',
            'width' => 'nullable|numeric|min:0',
            'length' => 'nullable|numeric|min:0',
            'color' => 'nullable|string|max:50',
        ];
    }

    public function messages(): array
    {
        return [
            'sku.required' => 'El SKU es obligatorio.',
            'sku.unique' => 'El SKU ya está en uso.',
            'sku.max' => 'El SKU no debe exceder 50 caracteres.',
            'name.required' => 'El nombre es obligatorio.',
            'name.max' => 'El nombre no debe exceder 255 caracteres.',
            'category_id.exists' => 'La categoría seleccionada no existe.',
            'material_type_id.required' => 'El tipo de material es obligatorio.',
            'material_type_id.exists' => 'El tipo de material seleccionado no existe.',
            'unit_of_measure_id.required' => 'La unidad de medida es obligatoria.',
            'unit_of_measure_id.exists' => 'La unidad de medida seleccionada no existe.',
            'current_stock.numeric' => 'El stock actual debe ser numérico.',
            'min_stock.numeric' => 'El stock mínimo debe ser numérico.',
            'max_stock.numeric' => 'El stock máximo debe ser numérico.',
            'safety_stock.numeric' => 'El stock de seguridad debe ser numérico.',
            'avg_unit_cost.numeric' => 'El costo promedio debe ser numérico.',
            'last_purchase_price.numeric' => 'El último precio de compra debe ser numérico.',
            'currency_id.required' => 'La moneda es obligatoria.',
            'currency_id.exists' => 'La moneda seleccionada no existe.',
            'grammage.numeric' => 'El gramaje debe ser numérico.',
            'width.numeric' => 'El ancho debe ser numérico.',
            'length.numeric' => 'El largo debe ser numérico.',
            'color.max' => 'El color no debe exceder 50 caracteres.',
        ];
    }
}
