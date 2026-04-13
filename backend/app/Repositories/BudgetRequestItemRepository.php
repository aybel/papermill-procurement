<?php

namespace App\Repositories;

use App\Models\BudgetRequestItem;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class BudgetRequestItemRepository implements BudgetRequestItemRepositoryInterface
{
    public function __construct(private BudgetRequestItem $model)
    {
    }

    public function getAll(?int $budgetRequestId = null, ?int $materialId = null, string $sortBy = 'created_at', string $sortDir = 'desc'): Collection
    {
        $query = $this->model->newQuery()->with(['request', 'material'])->orderBy($sortBy, $sortDir);

        if ($budgetRequestId) {
            $query->where('budget_request_id', $budgetRequestId);
        }

        if ($materialId) {
            $query->where('material_id', $materialId);
        }

        return $query->get();
    }

    public function findById(int $id): ?BudgetRequestItem
    {
        return $this->model->with(['request', 'material'])->find($id);
    }

    public function create(array $data): BudgetRequestItem
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): BudgetRequestItem
    {
        $item = $this->model->findOrFail($id);
        $item->update($data);

        return $item->fresh(['request', 'material']);
    }

    public function delete(int $id): bool
    {
        $item = $this->model->findOrFail($id);

        return (bool) $item->delete();
    }

    public function search(string $search, int $perPage = 15, ?int $budgetRequestId = null): LengthAwarePaginator
    {
        $query = $this->model
            ->with(['request', 'material'])
            ->whereHas('material', function ($mq) use ($search) {
                $mq->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'desc');

        if ($budgetRequestId) {
            $query->where('budget_request_id', $budgetRequestId);
        }

        return $query->paginate($perPage);
    }

    public function deleteByBudgetRequestId(int $budgetRequestId): int
    {
        return $this->model->where('budget_request_id', $budgetRequestId)->delete();
    }
}
