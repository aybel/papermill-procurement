<?php

namespace App\Repositories;

use App\Models\UnitOfMeasure;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class UnitOfMeasureRepository implements UnitOfMeasureRepositoryInterface
{
    public function __construct(private UnitOfMeasure $model)
    {
    }

    public function getAll(array $filters = [], string $sortBy = 'name', string $sortDir = 'asc'): Collection
    {
        $query = $this->model->newQuery()->orderBy($sortBy, $sortDir);

        if (!empty($filters['category'])) {
            $query->where('category', $filters['category']);
        }

        if (array_key_exists('is_active', $filters)) {
            $query->where('is_active', (bool) $filters['is_active']);
        }

        if (array_key_exists('is_base_unit', $filters)) {
            $query->where('is_base_unit', (bool) $filters['is_base_unit']);
        }

        return $query->get();
    }

    public function findById(int $id): ?UnitOfMeasure
    {
        return $this->model->find($id);
    }

    public function create(array $data): UnitOfMeasure
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): UnitOfMeasure
    {
        $unit = $this->model->findOrFail($id);
        $unit->update($data);

        return $unit->fresh();
    }

    public function delete(int $id): bool
    {
        $unit = $this->model->findOrFail($id);

        return (bool) $unit->delete();
    }

    public function search(string $search, int $perPage = 15): LengthAwarePaginator
    {
        return $this->model
            ->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%")
                    ->orWhere('symbol', 'like', "%{$search}%");
            })
            ->orderBy('name')
            ->paginate($perPage);
    }
}
