<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSupplierScoresRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'quality_score' => 'required|numeric|min:0|max:1',
            'delivery_score' => 'required|numeric|min:0|max:1',
        ];
    }

    public function messages(): array
    {
        return [
            'quality_score.required' => 'La puntuación de calidad es obligatoria.',
            'quality_score.numeric' => 'La puntuación de calidad debe ser numérica.',
            'quality_score.min' => 'La puntuación de calidad no puede ser menor que 0.',
            'quality_score.max' => 'La puntuación de calidad no puede ser mayor que 1.',
            'delivery_score.required' => 'La puntuación de entrega es obligatoria.',
            'delivery_score.numeric' => 'La puntuación de entrega debe ser numérica.',
            'delivery_score.min' => 'La puntuación de entrega no puede ser menor que 0.',
            'delivery_score.max' => 'La puntuación de entrega no puede ser mayor que 1.',
        ];
    }
}
