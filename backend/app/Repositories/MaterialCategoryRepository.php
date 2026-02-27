<?php

namespace App\Repositories;

use App\Models\MaterialCategory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class MaterialCategoryRepository implements MaterialCategoryRepositoryInterface
{
    public function __construct(private MaterialCategory $model)
    {
    }

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
}
