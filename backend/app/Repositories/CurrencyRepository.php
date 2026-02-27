<?php

namespace App\Repositories;

use App\Models\Currency;
use Illuminate\Database\Eloquent\Collection;

class CurrencyRepository implements CurrencyRepositoryInterface
{
    public function __construct(private Currency $model)
    {
    }

    public function getAll(bool $onlyActive = false, string $sortBy = 'name', string $sortDir = 'asc'): Collection
    {
        $query = $this->model->newQuery()->orderBy($sortBy, $sortDir);

        if ($onlyActive) {
            $query->where('is_active', true);
        }

        return $query->get();
    }

    public function findById(int $id): ?Currency
    {
        return $this->model->find($id);
    }

    public function create(array $data): Currency
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): Currency
    {
        $currency = $this->model->findOrFail($id);
        $currency->update($data);

        return $currency->fresh();
    }

    public function delete(int $id): bool
    {
        $currency = $this->model->findOrFail($id);
        return (bool) $currency->delete();
    }
}
