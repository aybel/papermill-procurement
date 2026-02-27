<?php

namespace App\Repositories;

use App\Models\SupplierStatus;
use Illuminate\Database\Eloquent\Collection;

interface SupplierStatusRepositoryInterface
{
    public function getAll(bool $onlyActive = false, string $sortBy = 'name', string $sortDir = 'asc'): Collection;

    public function findById(int $id): ?SupplierStatus;

    public function create(array $data): SupplierStatus;

    public function update(int $id, array $data): SupplierStatus;

    public function delete(int $id): bool;
}
