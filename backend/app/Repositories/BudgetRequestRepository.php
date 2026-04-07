<?php

namespace App\Repositories;

use App\Models\BudgetRequest;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class BudgetRequestRepository implements BudgetRequestRepositoryInterface
{
    public function __construct(private BudgetRequest $model) {}

    public function getAll(?int $departmentId = null, ?int $statusId = null, ?int $year = null, string $sortBy = 'created_at', string $sortDir = 'desc', ?array $accessibleDepartmentIds = null): Collection
    {
        $query = $this->model->newQuery()->with(['status', 'department', 'items.material', 'submittedBy', 'approvedBy', 'budgetCategory'])->orderBy($sortBy, $sortDir);

        // Control de acceso por departamento (null = sin restricción para admins)
        if ($accessibleDepartmentIds !== null) {
            if (empty($accessibleDepartmentIds)) {
                return collect(); // Sin acceso a ningún departamento
            }
            $query->whereIn('department_id', $accessibleDepartmentIds);
        }

        if ($departmentId) {
            $query->where('department_id', $departmentId);
        }

        if ($statusId) {
            $query->where('budget_request_status_id', $statusId);
        }

        if ($year) {
            $query->where('year', $year);
        }

        return $query->get();
    }

    public function findById(int $id): ?BudgetRequest
    {
        return $this->model->with(['status', 'department', 'items.material', 'submittedBy', 'approvedBy', 'budgetCategory'])->find($id);
    }

    public function create(array $data): BudgetRequest
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): BudgetRequest
    {
        $item = $this->model->findOrFail($id);
        $item->update($data);

        return $item->fresh(['status', 'department', 'items.material', 'submittedBy', 'approvedBy', 'budgetCategory']);
    }

    public function delete(int $id): bool
    {
        $item = $this->model->findOrFail($id);

        return (bool) $item->delete();
    }

    public function search(string $search, int $perPage = 15, ?int $departmentId = null, ?int $statusId = null, ?int $year = null, ?array $accessibleDepartmentIds = null): LengthAwarePaginator
    {
        $query = $this->model
            ->with(['status', 'department', 'items.material', 'submittedBy', 'approvedBy', 'budgetCategory'])
            ->where(function ($q) use ($search) {
                $q->where('request_number', 'like', "%{$search}%")
                    ->orWhereHas('department', function ($dq) use ($search) {
                        $dq->where('name', 'like', "%{$search}%")
                            ->orWhere('code', 'like', "%{$search}%");
                    });
            })
            ->orderBy('created_at', 'desc');

        // Control de acceso por departamento
        if ($accessibleDepartmentIds !== null) {
            if (empty($accessibleDepartmentIds)) {
                $query->whereRaw('1 = 0'); // Sin acceso
            } else {
                $query->whereIn('department_id', $accessibleDepartmentIds);
            }
        }

        if ($departmentId) {
            $query->where('department_id', $departmentId);
        }

        if ($statusId) {
            $query->where('budget_request_status_id', $statusId);
        }

        if ($year) {
            $query->where('year', $year);
        }

        return $query->paginate($perPage);
    }
}
