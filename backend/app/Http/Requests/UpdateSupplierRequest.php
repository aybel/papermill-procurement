<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSupplierRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $supplierId = $this->route('id');

        return [
            'code' => 'sometimes|required|string|max:20|unique:suppliers,code,' . $supplierId,
            'name' => 'sometimes|required|string|max:255',
            'tax_id' => 'nullable|string|max:20',
            'supplier_type_id' => 'nullable|exists:supplier_types,id',
            'supplier_status_id' => 'sometimes|required|exists:supplier_statuses,id',
            'primary_contact_id' => 'nullable|exists:supplier_contacts,id',
            'quality_score' => 'nullable|numeric|min:0|max:1',
            'delivery_score' => 'nullable|numeric|min:0|max:1',
            'payment_terms_id' => 'sometimes|required|exists:payment_terms,id',
            'currency_id' => 'sometimes|required|exists:currencies,id',
            'credit_limit' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'code.required' => 'El código es obligatorio.',
            'code.max' => 'El código no debe exceder 20 caracteres.',
            'code.unique' => 'El código ya está en uso.',
            'name.required' => 'El nombre es obligatorio.',
            'name.max' => 'El nombre no debe exceder 255 caracteres.',
            'tax_id.max' => 'El identificador fiscal no debe exceder 20 caracteres.',
            'supplier_type_id.exists' => 'El tipo de proveedor seleccionado no existe.',
            'supplier_status_id.required' => 'El estado del proveedor es obligatorio.',
            'supplier_status_id.exists' => 'El estado de proveedor seleccionado no existe.',
            'primary_contact_id.exists' => 'El contacto principal seleccionado no existe.',
            'quality_score.numeric' => 'La puntuación de calidad debe ser numérica.',
            'quality_score.min' => 'La puntuación de calidad no puede ser menor que 0.',
            'quality_score.max' => 'La puntuación de calidad no puede ser mayor que 1.',
            'delivery_score.numeric' => 'La puntuación de entrega debe ser numérica.',
            'delivery_score.min' => 'La puntuación de entrega no puede ser menor que 0.',
            'delivery_score.max' => 'La puntuación de entrega no puede ser mayor que 1.',
            'payment_terms_id.required' => 'Los términos de pago son obligatorios.',
            'payment_terms_id.exists' => 'Los términos de pago seleccionados no existen.',
            'currency_id.required' => 'La moneda es obligatoria.',
            'currency_id.exists' => 'La moneda seleccionada no existe.',
            'credit_limit.numeric' => 'El límite de crédito debe ser numérico.',
            'credit_limit.min' => 'El límite de crédito no puede ser negativo.',
            'notes.max' => 'Las notas no deben exceder 500 caracteres.',
        ];
    }
}
