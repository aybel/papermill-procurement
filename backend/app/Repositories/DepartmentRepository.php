<?php

namespace App\Repositories;

use App\Models\Department;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class DepartmentRepository implements DepartmentRepositoryInterface
{
    public function __construct(private Department $model)
    {
    }

    public function getAll(?bool $onlyActive = null, string $sortBy = 'name', string $sortDir = 'asc'): Collection
    {
        $query = $this->model->newQuery()->orderBy($sortBy, $sortDir);

        if ($onlyActive === true) {
            $query->where('is_active', true);
        } elseif ($onlyActive === false) {
            $query->where('is_active', false);
        }

        return $query->get();
    }

    public function findById(int $id): ?Department
    {
        return $this->model->find($id);
    }

    public function create(array $data): Department
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): Department
    {
        $item = $this->model->findOrFail($id);
        $item->update($data);

        return $item->fresh();
    }

    public function delete(int $id): bool
    {
        $item = $this->model->findOrFail($id);

        return (bool) $item->delete();
    }

    public function search(string $search, int $perPage = 15, ?bool $onlyActive = null): LengthAwarePaginator
    {
        $query = $this->model
            ->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%");
            })
            ->orderBy('name');

        if ($onlyActive === true) {
            $query->where('is_active', true);
        } elseif ($onlyActive === false) {
            $query->where('is_active', false);
        }

        return $query->paginate($perPage);
    }
}
