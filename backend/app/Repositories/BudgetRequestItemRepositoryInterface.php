<?php

namespace App\Repositories;

use App\Models\BudgetRequestItem;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface BudgetRequestItemRepositoryInterface
{
    public function getAll(?int $budgetRequestId = null, ?int $materialId = null, string $sortBy = 'created_at', string $sortDir = 'desc'): Collection;

    public function findById(int $id): ?BudgetRequestItem;

    public function create(array $data): BudgetRequestItem;

    public function update(int $id, array $data): BudgetRequestItem;

    public function delete(int $id): bool;

    public function search(string $search, int $perPage = 15, ?int $budgetRequestId = null): LengthAwarePaginator;
}
