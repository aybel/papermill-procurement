<?php

namespace App\Repositories;

use App\Models\BudgetRequestStatus;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface BudgetRequestStatusRepositoryInterface
{
    public function getAll(string $sortBy = 'name', string $sortDir = 'asc'): Collection;

    public function findById(int $id): ?BudgetRequestStatus;

    public function create(array $data): BudgetRequestStatus;

    public function update(int $id, array $data): BudgetRequestStatus;

    public function delete(int $id): bool;

    public function search(string $search, int $perPage = 15): LengthAwarePaginator;
}
