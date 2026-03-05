<?php

namespace App\Repositories;

use App\Models\BudgetCategory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class BudgetCategoryRepository implements BudgetCategoryRepositoryInterface
{
    public function __construct(private BudgetCategory $model)
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

    public function findById(int $id): ?BudgetCategory
    {
        return $this->model->find($id);
    }

    public function create(array $data): BudgetCategory
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): BudgetCategory
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

    public function search(string $search, int $perPage = 15, ?bool $onlyActive = null): LengthAwarePaginator
    {
        $query = $this->model
            ->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
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
