<?php

namespace App\Repositories;

use App\Models\MaterialType;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class MaterialTypeRepository implements MaterialTypeRepositoryInterface
{
    public function __construct(private MaterialType $model)
    {
    }

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
}
