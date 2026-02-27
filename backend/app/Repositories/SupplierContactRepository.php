<?php

namespace App\Repositories;

use App\Models\SupplierContact;
use Illuminate\Database\Eloquent\Collection;

class SupplierContactRepository implements SupplierContactRepositoryInterface
{
    public function __construct(private SupplierContact $model)
    {
    }

    public function getAll(bool $onlyActive = false, string $sortBy = 'name', string $sortDir = 'asc', ?int $supplierId = null, string $query = ''): Collection
    {
        $queryBuilder = $this->model->newQuery()->orderBy($sortBy, $sortDir);

        if ($onlyActive) {
            $queryBuilder->where('is_active', true);
        }

        if ($supplierId) {
            $queryBuilder->where('supplier_id', $supplierId);
        }

        if ($query) {
            $queryBuilder->where(function ($q) use ($query) {
                $q->where('name', 'like', "%$query%")
                  ->orWhere('email', 'like', "%$query%");
            });
        }

        return $queryBuilder->get();
    }

    public function findById(int $id): ?SupplierContact
    {
        return $this->model->find($id);
    }

    public function create(array $data): SupplierContact
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): SupplierContact
    {
        $contact = $this->model->findOrFail($id);
        $contact->update($data);

        return $contact->fresh();
    }

    public function delete(int $id): bool
    {
        $contact = $this->model->findOrFail($id);
        return (bool) $contact->delete();
    }
}
