<?php

namespace App\Repositories\Concerns;

trait AppliesStructuredFilters
{
    abstract protected function getAllowedFilterFields(): array;

    protected function getBooleanFilterFields(): array
    {
        return [];
    }

    /**
     * Aplica filtros estructurados de forma comun para los repositorios.
     */
    protected function applyFilters($query, array $filters)
    {
        $allowedFields = $this->getAllowedFilterFields();

        foreach ($filters as $filter) {
            if (!isset($filter['field'], $filter['operator'])) {
                continue;
            }

            $field = $filter['field'];
            $operator = $filter['operator'];
            $value = $filter['value'] ?? null;

            if (!in_array($field, $allowedFields, true)) {
                continue;
            }

            $value = $this->normalizeFilterValue($field, $value);

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

        return $query;
    }

    /**
     * Normaliza valores para comparaciones seguras en filtros estructurados.
     */
    protected function normalizeFilterValue(string $field, mixed $value): mixed
    {
        if (in_array($field, $this->getBooleanFilterFields(), true)) {
            if (is_string($value)) {
                $normalizedValue = filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);

                if ($normalizedValue !== null) {
                    return $normalizedValue;
                }
            }

            return (bool) $value;
        }

        return $value;
    }
}
