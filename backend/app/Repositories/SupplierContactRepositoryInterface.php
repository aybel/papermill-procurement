<?php

namespace App\Repositories;

use App\Models\SupplierContact;
use Illuminate\Database\Eloquent\Collection;

interface SupplierContactRepositoryInterface
{
    public function getAll(bool $onlyActive = false, string $sortBy = 'name', string $sortDir = 'asc', ?int $supplierId = null): Collection;

    public function findById(int $id): ?SupplierContact;

    public function create(array $data): SupplierContact;

    public function update(int $id, array $data): SupplierContact;

    public function delete(int $id): bool;
}
