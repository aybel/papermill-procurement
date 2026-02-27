<?php

namespace App\Repositories;

use App\Models\PaymentTerm;
use Illuminate\Database\Eloquent\Collection;

interface PaymentTermRepositoryInterface
{
    public function getAll(bool $onlyActive = false, string $sortBy = 'name', string $sortDir = 'asc'): Collection;

    public function findById(int $id): ?PaymentTerm;

    public function create(array $data): PaymentTerm;

    public function update(int $id, array $data): PaymentTerm;

    public function delete(int $id): bool;
}
