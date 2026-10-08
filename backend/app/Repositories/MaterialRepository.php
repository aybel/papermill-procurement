<?php

namespace App\Repositories;

use App\Models\Material;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\Concerns\AppliesStructuredFilters;

class MaterialRepository implements MaterialRepositoryInterface
{
    use AppliesStructuredFilters;

    public function __construct(private Material $model)
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
                    ->orWhere('sku', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('last_purchase_price', 'like', "%{$search}%")
                    ->orWhere('current_stock', 'like', "%{$search}%");
            })
            ->paginate($perPage);
    }
    public function filter(array $filters = [], ?array $orderBy = null, ?array $pagination = null): LengthAwarePaginator|Collection
    {
        $query = $this->model->newQuery();

        // Aplicar filtros
        if (!empty($filters)) {
            $query = $this->applyFilters($query, $filters);
        }

        // Aplicar ordenamiento
        if ($orderBy && isset($orderBy['column'], $orderBy['direction'])) {
            $direction = in_array(strtolower($orderBy['direction']), ['asc', 'desc'])
                ? $orderBy['direction']
                : 'asc';
            $query->orderBy($orderBy['column'], $direction);
        } else {
            $query->orderBy('name', 'asc');
        }

        // Caso 1: Sin paginación (traer todos)
        if (is_null($pagination)) {
            return $query->with(['category', 'currency', 'materialType', 'unitOfMeasure'])->get();
        }

        // Caso 2: Paginación con límite personalizado
        $perPage = $pagination['limit'] ?? 15;
        $page = $pagination['page'] ?? 1;

        // Caso especial: Si limit es 0 o null, traer todos
        if ($perPage === 0 || $perPage === null) {
            return $query->with(['category', 'currency', 'materialType', 'unitOfMeasure'])->get();
        }

        return $query->with(['category', 'currency', 'materialType', 'unitOfMeasure'])->paginate($perPage, ['*'], 'page', $page);
    }

    /**
     * Campos permitidos para filtrar en esta entidad.
     */
    protected function getAllowedFilterFields(): array
    {
        return [
            'id',
            'sku',
            'name',
            'description',
            'category_id',
            'category.name',
            'currency.name',
            'materialType.name',
            'unitOfMeasure.name',
            'currency_id',
            'material_type_id',
            'unit_of_measure_id',
            'current_stock',
            'min_stock',
            'max_stock',
            'safety_stock',
            'reorder_point',
            'avg_unit_cost',
            'last_purchase_price',
            'grammage',
            'width',
            'length',
            'color',
            'created_at',
            'updated_at'
        ];
    }
    /**
     * Aplica filtros personalizados para la entidad Material.
     *
     * @param string $field
     * @param string $operator
     * @param mixed $value
     * @return bool
     */
    protected function applyCustomFilter(string $field, string $operator, mixed $value): bool
    {
        $query = $this->model->newQuery();

        switch ($field) {
            case 'category.name':
                if ($operator === 'like') {
                    $query->whereHas('category', function ($categoryQuery) use ($value) {
                        $categoryQuery->where('name', 'LIKE', "%{$value}%");
                    });

                    return true;
                }
                break;
            case 'currency.name':
                if ($operator === 'like') {
                    $query->whereHas('currency', function ($currencyQuery) use ($value) {
                        $currencyQuery->where('name', 'LIKE', "%{$value}%");
                    });

                    return true;
                }
                break;
            case 'materialType.name':
                if ($operator === 'like') {
                    $query->whereHas('material_types', function ($materialTypeQuery) use ($value) {
                        $materialTypeQuery->where('name', 'LIKE', "%{$value}%");
                    });

                    return true;
                }
                break;
            case 'unitOfMeasure.name':
                if ($operator === 'like') {
                    $query->whereHas('units_of_measure', function ($unitOfMeasureQuery) use ($value) {
                        $unitOfMeasureQuery->where('name', 'LIKE', "%{$value}%");
                    });

                    return true;
                }
                break;
        }


        return false;
    }
}
