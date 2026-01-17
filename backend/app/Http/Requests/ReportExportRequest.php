<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReportExportRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Ya está protegido por middleware de permisos
    }

    public function rules()
    {
        return [
            'type' => 'required|string|in:suppliers', // Agrega más tipos si tienes más reportes
            'format' => 'required|string|in:pdf,excel',
            'filters' => 'sometimes|array',
        ];
    }
}
