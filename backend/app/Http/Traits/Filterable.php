<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait Filterable
{
    /**
     * Aplica filtros al query builder
     */
    public function scopeFilter(Builder $query, array $filters): Builder
    {
        foreach ($filters as $filter) {
            $this->applyFilter($query, $filter);
        }

        return $query;
    }

    /**
     * Aplica ordenamiento
     */
    public function scopeApplyOrderBy(Builder $query, ?array $orderBy): Builder
    {
        if ($orderBy && isset($orderBy['column'], $orderBy['direction'])) {
            $direction = in_array(strtolower($orderBy['direction']), ['asc', 'desc'])
                ? $orderBy['direction']
                : 'asc';

            $query->orderBy($orderBy['column'], $direction);
        }

        return $query;
    }

    /**
     * Aplica un filtro individual
     */
    private function applyFilter(Builder $query, array $filter): void
    {
        $field = $filter['field'];
        $operator = $filter['operator'];
        $value = $filter['value'] ?? null;

        // Validar que el campo existe en la tabla
        if (!$this->isValidField($field)) {
            return;
        }

        switch ($operator) {
            case 'eq':
                $query->where($field, '=', $value);
                break;

            case 'ne':
                $query->where($field, '!=', $value);
                break;

            case 'gt':
                $query->where($field, '>', $value);
                break;

            case 'gte':
                $query->where($field, '>=', $value);
                break;

            case 'lt':
                $query->where($field, '<', $value);
                break;

            case 'lte':
                $query->where($field, '<=', $value);
                break;

            case 'like':
                $query->where($field, 'LIKE', "%{$value}%");
                break;

            case 'ilike':
                $query->where($field, 'ILIKE', "%{$value}%");
                break;

            case 'in':
                $query->whereIn($field, (array) $value);
                break;

            case 'nin':
                $query->whereNotIn($field, (array) $value);
                break;

            case 'null':
                $query->whereNull($field);
                break;

            case 'notnull':
                $query->whereNotNull($field);
                break;

            case 'between':
                if (is_array($value) && count($value) === 2) {
                    $query->whereBetween($field, $value);
                }
                break;

            case 'startsWith':
                $query->where($field, 'LIKE', "{$value}%");
                break;

            case 'endsWith':
                $query->where($field, 'LIKE', "%{$value}");
                break;
        }
    }

    /**
     * Valida si el campo existe en la tabla
     */
    private function isValidField(string $field): bool
    {
        $allowedFields = $this->getFilterableFields();

        // Si no hay restricciones, permitir todos los campos
        if (empty($allowedFields)) {
            return true;
        }

        return in_array($field, $allowedFields);
    }

    /**
     * Sobreescribir en el modelo para restringir campos filtrables
     */
    protected function getFilterableFields(): array
    {
        return property_exists($this, 'filterable') ? $this->filterable : [];
    }
}
