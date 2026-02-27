<?php

namespace App\Repositories;

use App\Models\SupplierStatus;
use Illuminate\Database\Eloquent\Collection;

class SupplierStatusRepository implements SupplierStatusRepositoryInterface
{
    public function __construct(private SupplierStatus $model)
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

    public function findById(int $id): ?SupplierStatus
    {
        return $this->model->find($id);
    }

    public function create(array $data): SupplierStatus
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): SupplierStatus
    {
        $status = $this->model->findOrFail($id);
        $status->update($data);

        return $status->fresh();
    }

    public function delete(int $id): bool
    {
        $status = $this->model->findOrFail($id);
        return (bool) $status->delete();
    }
}
