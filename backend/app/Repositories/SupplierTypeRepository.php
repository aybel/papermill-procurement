<?php

namespace App\Repositories;

use App\Models\SupplierType;
use Illuminate\Database\Eloquent\Collection;

class SupplierTypeRepository implements SupplierTypeRepositoryInterface
{
    public function __construct(private SupplierType $model)
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

    public function findById(int $id): ?SupplierType
    {
        return $this->model->find($id);
    }

    public function create(array $data): SupplierType
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): SupplierType
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
}
