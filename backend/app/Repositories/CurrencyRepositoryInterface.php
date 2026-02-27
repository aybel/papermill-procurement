<?php

namespace App\Repositories;

use App\Models\Currency;
use Illuminate\Database\Eloquent\Collection;

interface CurrencyRepositoryInterface
{
    public function getAll(bool $onlyActive = false, string $sortBy = 'name', string $sortDir = 'asc'): Collection;

    public function findById(int $id): ?Currency;

    public function create(array $data): Currency;

    public function update(int $id, array $data): Currency;

    public function delete(int $id): bool;
}
