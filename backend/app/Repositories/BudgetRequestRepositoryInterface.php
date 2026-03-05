<?php

namespace App\Repositories;

use App\Models\BudgetRequest;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface BudgetRequestRepositoryInterface
{
    public function getAll(?int $departmentId = null, ?int $statusId = null, ?int $year = null, string $sortBy = 'created_at', string $sortDir = 'desc', ?array $accessibleDepartmentIds = null): Collection;

    public function findById(int $id): ?BudgetRequest;

    public function create(array $data): BudgetRequest;

    public function update(int $id, array $data): BudgetRequest;

    public function delete(int $id): bool;

    public function search(string $search, int $perPage = 15, ?int $departmentId = null, ?int $statusId = null, ?int $year = null, ?array $accessibleDepartmentIds = null): LengthAwarePaginator;
}
