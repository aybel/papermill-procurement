<?php

namespace App\Repositories;

use App\Models\PaymentTerm;
use Illuminate\Database\Eloquent\Collection;

class PaymentTermRepository implements PaymentTermRepositoryInterface
{
    public function __construct(private PaymentTerm $model)
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

    public function findById(int $id): ?PaymentTerm
    {
        return $this->model->find($id);
    }

    public function create(array $data): PaymentTerm
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): PaymentTerm
    {
        $term = $this->model->findOrFail($id);
        $term->update($data);

        return $term->fresh();
    }

    public function delete(int $id): bool
    {
        $term = $this->model->findOrFail($id);
        return (bool) $term->delete();
    }
}
