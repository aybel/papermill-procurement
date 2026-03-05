<?php

namespace App\Repositories;

use App\Models\BudgetAssignment;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class BudgetAssignmentRepository implements BudgetAssignmentRepositoryInterface
{
    public function __construct(private BudgetAssignment $model)
    {
    }

    public function getAll(?int $departmentId = null, ?int $categoryId = null, ?int $year = null, string $sortBy = 'year', string $sortDir = 'desc'): Collection
    {
        $query = $this->model->newQuery()
            ->with(['department', 'category'])
            ->orderBy($sortBy, $sortDir);

        if ($departmentId) {
            $query->where('department_id', $departmentId);
        }

        if ($categoryId) {
            $query->where('budget_category_id', $categoryId);
        }

        if ($year) {
            $query->where('year', $year);
        }

        return $query->get();
    }

    public function findById(int $id): ?BudgetAssignment
    {
        return $this->model->with(['department', 'category'])->find($id);
    }

    public function create(array $data): BudgetAssignment
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): BudgetAssignment
    {
        $item = $this->model->findOrFail($id);
        $item->update($data);

        return $item->fresh(['department', 'category']);
    }

    public function delete(int $id): bool
    {
        $item = $this->model->findOrFail($id);

        return (bool) $item->delete();
    }

    public function search(string $search, int $perPage = 15, ?int $departmentId = null, ?int $categoryId = null, ?int $year = null): LengthAwarePaginator
    {
        $query = $this->model
            ->with(['department', 'category'])
            ->where(function ($q) use ($search) {
                $q->whereHas('department', function ($dq) use ($search) {
                    $dq->where('name', 'like', "%{$search}%")
                        ->orWhere('code', 'like', "%{$search}%");
                })
                ->orWhereHas('category', function ($cq) use ($search) {
                    $cq->where('name', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->orderBy('year', 'desc');

        if ($departmentId) {
            $query->where('department_id', $departmentId);
        }

        if ($categoryId) {
            $query->where('budget_category_id', $categoryId);
        }

        if ($year) {
            $query->where('year', $year);
        }

        return $query->paginate($perPage);
    }
}
