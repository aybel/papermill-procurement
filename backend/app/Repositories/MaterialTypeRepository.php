<?php

namespace App\Repositories;

use App\Models\MaterialType;
use App\Repositories\Concerns\AppliesStructuredFilters;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class MaterialTypeRepository implements MaterialTypeRepositoryInterface
{
    use AppliesStructuredFilters;

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

    protected function getAllowedFilterFields(): array
    {
        return [
            'id',
            'code',
            'name',
            'description',
            'attributes',
            'is_active',
            'created_at',
            'updated_at'
        ];
    }
    protected function getBooleanFilterFields(): array
    {
        return [
            'is_active',
        ];
    }
}
