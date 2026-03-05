<?php

namespace App\Repositories;

use App\Models\BudgetRequestStatus;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class BudgetRequestStatusRepository implements BudgetRequestStatusRepositoryInterface
{
    public function __construct(private BudgetRequestStatus $model)
    {
    }

    public function getAll(string $sortBy = 'name', string $sortDir = 'asc'): Collection
    {
        return $this->model->newQuery()->orderBy($sortBy, $sortDir)->get();
    }

    public function findById(int $id): ?BudgetRequestStatus
    {
        return $this->model->find($id);
    }

    public function create(array $data): BudgetRequestStatus
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): BudgetRequestStatus
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

    public function search(string $search, int $perPage = 15): LengthAwarePaginator
    {
        return $this->model
            ->where('name', 'like', "%{$search}%")
            ->orWhere('description', 'like', "%{$search}%")
            ->orderBy('name')
            ->paginate($perPage);
    }
}
