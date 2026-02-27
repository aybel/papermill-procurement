<?php
// app/Services/SKUGenerator.php

namespace App\Services;

use App\Models\Material;
use App\Models\MaterialCategory;

class SKUGenerator
{
    /**
     * Genera un SKU basado en la categoría y características
     */
    public function generate(array $attributes): string
    {
        $prefix = $this->getCategoryPrefix($attributes['category_id']);
        $typeCode = $this->getTypeCode($attributes['material_type'] ?? null);
        $specs = $this->getSpecificationsCode($attributes);
        $sequence = $this->getNextSequence($prefix . $typeCode);

        return implode('-', array_filter([$prefix, $typeCode, $specs, $sequence]));
    }

    /**
     * Obtiene prefijo de categoría
     */
    private function getCategoryPrefix($categoryId): string
    {
        $category = MaterialCategory::with('parent')->find($categoryId);

        $prefixes = [
            'Pastas y Fibras' => 'PULP',
            'Papeles Reciclados' => 'REC',
            'Aditivos para Producción' => 'ADIT',
            'Químicos para Tratamiento' => 'QUIM',
            'Cartón Corrugado' => 'CART',
            'Papeles Kraft' => 'KRAFT',
            'Películas Plásticas' => 'FILM',
            'Insumos de Impresión' => 'INK',
        ];

        return $prefixes[$category->name] ?? 'GEN';
    }

    /**
     * Código para tipo de material
     */
    private function getTypeCode($type): string
    {
        $codes = [
            'raw_material' => 'RAW',
            'chemical' => 'CHM',
            'packaging' => 'PKG',
            'consumable' => 'CNS',
        ];

        return $codes[$type] ?? '';
    }

    /**
     * Código para especificaciones (gramaje, color, etc)
     */
    private function getSpecificationsCode(array $attrs): string
    {
        $parts = [];

        if (!empty($attrs['grammage'])) {
            $parts[] = $attrs['grammage'];
        }

        if (!empty($attrs['color']) && $attrs['color'] !== 'natural') {
            $parts[] = substr(strtoupper($attrs['color']), 0, 3);
        }

        if (!empty($attrs['width'])) {
            $parts[] = $attrs['width'] . 'W';
        }

        return implode('-', $parts);
    }

    /**
     * Obtiene el siguiente número de secuencia para un prefijo
     */
    private function getNextSequence(string $prefix): string
    {
        $lastMaterial = Material::where('sku', 'like', $prefix . '%')
            ->orderBy('sku', 'desc')
            ->first();

        if (!$lastMaterial) {
            return '001';
        }

        // Extraer el último número y aumentarlo
        preg_match('/(\d+)$/', $lastMaterial->sku, $matches);
        $lastNumber = isset($matches[1]) ? (int)$matches[1] : 0;
        $nextNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);

        return $nextNumber;
    }

    /**
     * Valida que un SKU siga el formato correcto
     */
    public function validateSku(string $sku): bool
    {
        // Formato: 2-4 letras mayúsculas, luego opcionalmente más códigos separados por guión
        return preg_match('/^[A-Z]{2,4}(-[A-Z0-9]+)*$/', $sku) === 1;
    }
}
