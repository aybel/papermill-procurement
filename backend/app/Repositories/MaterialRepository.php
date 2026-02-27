<?php

namespace App\Repositories;

use App\Models\Material;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class MaterialRepository implements MaterialRepositoryInterface
{
    protected $model;

    public function __construct(Material $model)
    {
        $this->model = $model;
    }

    public function getAllPaginated(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = $this->model->with(['category', 'currency', 'materialType', 'unitOfMeasure']);

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        if (!empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        if (!empty($filters['material_type_id'])) {
            $query->where('material_type_id', $filters['material_type_id']);
        }

        if (!empty($filters['unit_of_measure_id'])) {
            $query->where('unit_of_measure_id', $filters['unit_of_measure_id']);
        }

        if (!empty($filters['currency_id'])) {
            $query->where('currency_id', $filters['currency_id']);
        }

        $sortBy = $filters['sort_by'] ?? 'name';
        $sortOrder = $filters['sort_order'] ?? 'asc';
        $query->orderBy($sortBy, $sortOrder);

        return $query->paginate($perPage);
    }

    public function getAll(array $filters = []): Collection
    {
        $query = $this->model->with(['category', 'currency', 'materialType', 'unitOfMeasure']);

        if (!empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        if (!empty($filters['material_type_id'])) {
            $query->where('material_type_id', $filters['material_type_id']);
        }

        if (!empty($filters['unit_of_measure_id'])) {
            $query->where('unit_of_measure_id', $filters['unit_of_measure_id']);
        }

        return $query->get();
    }

    public function findById(int $id): ?Material
    {
        return $this->model->with(['category', 'currency', 'materialType', 'unitOfMeasure'])->find($id);
    }

    public function findBySku(string $sku): ?Material
    {
        return $this->model->where('sku', $sku)->first();
    }

    public function create(array $data): Material
    {
        return $this->model->create($data)->fresh(['category', 'currency', 'materialType', 'unitOfMeasure']);
    }

    public function update(int $id, array $data): Material
    {
        $material = $this->model->findOrFail($id);
        $material->update($data);
        return $material->fresh(['category', 'currency', 'materialType', 'unitOfMeasure']);
    }

    public function delete(int $id): bool
    {
        $material = $this->model->findOrFail($id);
        return $material->delete();
    }

    public function search(string $search, int $perPage = 15): LengthAwarePaginator
    {
        return $this->model
            ->with(['category', 'currency', 'materialType', 'unitOfMeasure'])
            ->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%");
            })
            ->paginate($perPage);
    }
}
