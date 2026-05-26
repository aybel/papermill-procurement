<?php

namespace App\Repositories;

use App\Models\MaterialCategory;
use App\Repositories\Concerns\AppliesStructuredFilters;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class MaterialCategoryRepository implements MaterialCategoryRepositoryInterface
{
    use AppliesStructuredFilters;

    public function __construct(private MaterialCategory $model) {}

    public function getAll(?int $parentId = null, string $sortBy = 'name', string $sortDir = 'asc'): Collection
    {
        $query = $this->model->newQuery()->orderBy($sortBy, $sortDir);

        if ($parentId !== null) {
            $query->where('parent_id', $parentId);
        }

        return $query->get();
    }

    public function findById(int $id, bool $withTrashed = false): ?MaterialCategory
    {
        $query = $withTrashed ? $this->model->withTrashed() : $this->model->newQuery();

        return $query->find($id);
    }

    public function create(array $data): MaterialCategory
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): MaterialCategory
    {
        $category = $this->model->findOrFail($id);
        $category->update($data);

        return $category->fresh();
    }

    public function delete(int $id): bool
    {
        $category = $this->model->findOrFail($id);

        return (bool) $category->delete();
    }

    public function search(string $search, int $perPage = 15): LengthAwarePaginator
    {
        return $this->model
            ->where('name', 'like', "%{$search}%")
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
            'name',
            'parent_id',
            'created_at',
            'updated_at'
        ];
    }
    protected function getBooleanFilterFields(): array
    {
        return [

        ];
    }
}
