<?php

namespace App\Repositories;

use App\Models\MaterialType;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class MaterialTypeRepository implements MaterialTypeRepositoryInterface
{
    public function __construct(private MaterialType $model) {}

    public function getAll(bool $onlyActive = false, string $sortBy = 'name', string $sortDir = 'asc'): Collection
    {
        $query = $this->model->newQuery()->orderBy($sortBy, $sortDir);

        if ($onlyActive) {
            $query->where('is_active', true);
        }

        return $query->get();
    }

    public function findById(int $id): ?MaterialType
    {
        return $this->model->find($id);
    }

    public function create(array $data): MaterialType
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): MaterialType
    {
        $type = $this->model->findOrFail($id);
        $type->update($data);

        return $type->fresh();
    }

    public function delete(int $id): bool
    {
        $type = $this->model->findOrFail($id);

        return (bool) $type->delete();
    }

    public function search(string $search, int $perPage = 15): LengthAwarePaginator
    {
        return $this->model
            ->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%");
            })
            ->orderBy('name')
            ->paginate($perPage);
    }
    public function filter(array $filters = [], ?array $orderBy = null, ?array $pagination = null): LengthAwarePaginator|Collection
    {
        $query = $this->model->newQuery();

        // Aplicar filtros
        if (!empty($filters)) {
            $query = $this->applyFilters($query, $filters);
        }

        // Aplicar ordenamiento
        if ($orderBy && isset($orderBy['column'], $orderBy['direction'])) {
            $direction = in_array(strtolower($orderBy['direction']), ['asc', 'desc'])
                ? $orderBy['direction']
                : 'asc';
            $query->orderBy($orderBy['column'], $direction);
        } else {
            $query->orderBy('name', 'asc');
        }

        // Caso 1: Sin paginación (traer todos)
        if (is_null($pagination)) {
            return $query->get();
        }

        // Caso 2: Paginación con límite personalizado
        $perPage = $pagination['limit'] ?? 15;
        $page = $pagination['page'] ?? 1;

        // Caso especial: Si limit es 0 o null, traer todos
        if ($perPage === 0 || $perPage === null) {
            return $query->get();
        }

        return $query->paginate($perPage, ['*'], 'page', $page);
    }

    /**
     * Aplica los filtros al query builder
     */
    private function applyFilters($query, array $filters)
    {
        foreach ($filters as $filter) {
            if (!isset($filter['field'], $filter['operator'])) {
                continue;
            }

            $field = $filter['field'];
            $operator = $filter['operator'];
            $value = $filter['value'] ?? null;

            // Solo permitir campos que existen en la tabla
            if (!$this->isValidField($field)) {
                continue;
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

        return $query;
    }

    /**
     * Valida si el campo existe en la tabla
     */
    private function isValidField(string $field): bool
    {
        $allowedFields = [
            'id',
            'name',
            'parent_id',
            'created_at',
            'updated_at'
        ];

        return in_array($field, $allowedFields);
    }
}
