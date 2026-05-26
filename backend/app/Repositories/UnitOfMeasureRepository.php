<?php

namespace App\Repositories;

use App\Models\UnitOfMeasure;
use App\Repositories\Concerns\AppliesStructuredFilters;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UnitOfMeasureRepository implements UnitOfMeasureRepositoryInterface
{
    use AppliesStructuredFilters;

    public function __construct(private UnitOfMeasure $model) {}

    public function getAll(array $filters = [], string $sortBy = 'name', string $sortDir = 'asc'): Collection
    {
        $query = $this->model->newQuery()->orderBy($sortBy, $sortDir);

        if (!empty($filters['category'])) {
            $query->where('category', $filters['category']);
        }

        if (array_key_exists('is_active', $filters)) {
            $query->where('is_active', (bool) $filters['is_active']);
        }

        if (array_key_exists('is_base_unit', $filters)) {
            $query->where('is_base_unit', (bool) $filters['is_base_unit']);
        }

        return $query->get();
    }

    public function findById(int $id): ?UnitOfMeasure
    {
        return $this->model->find($id);
    }

    public function create(array $data): UnitOfMeasure
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): UnitOfMeasure
    {
        $unit = $this->model->findOrFail($id);
        $unit->update($data);

        return $unit->fresh();
    }

    public function delete(int $id): bool
    {
        $unit = $this->model->findOrFail($id);

        return (bool) $unit->delete();
    }

    public function search(string $search, int $perPage = 15): LengthAwarePaginator
    {
        return $this->model
            ->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%")
                    ->orWhere('symbol', 'like', "%{$search}%");
            })
            ->orderBy('name')
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

        // Query log para diagnosticar filtros sin resultados.
        DB::flushQueryLog();
        DB::enableQueryLog();

        // Caso 1: Sin paginación (traer todos)
        if (is_null($pagination)) {
            $result = $query->get();

            Log::info('UnitOfMeasure filter query', [
                'mode' => 'without_pagination',
                'filters' => $filters,
                'order_by' => $orderBy,
                'pagination' => $pagination,
                'result_count' => $result->count(),
                'queries' => DB::getQueryLog(),
            ]);

            return $result;
        }

        // Caso 2: Paginación con límite personalizado
        $perPage = $pagination['limit'] ?? 15;
        $page = $pagination['page'] ?? 1;

        // Caso especial: Si limit es 0 o null, traer todos
        if ($perPage === 0 || $perPage === null) {
            $result = $query->get();

            Log::info('UnitOfMeasure filter query', [
                'mode' => 'all_records_by_limit',
                'filters' => $filters,
                'order_by' => $orderBy,
                'pagination' => $pagination,
                'result_count' => $result->count(),
                'queries' => DB::getQueryLog(),
            ]);

            return $result;
        }

        $result = $query->paginate($perPage, ['*'], 'page', $page);

        Log::info('UnitOfMeasure filter query', [
            'mode' => 'with_pagination',
            'filters' => $filters,
            'order_by' => $orderBy,
            'pagination' => $pagination,
            'result_count' => count($result->items()),
            'total' => $result->total(),
            'current_page' => $result->currentPage(),
            'last_page' => $result->lastPage(),
            'queries' => DB::getQueryLog(),
        ]);

        return $result;
    }

    protected function getAllowedFilterFields(): array
    {
        return [
            'id',
            'code',
            'name',
            'symbol',
            'category',
            'is_active',
            'is_base_unit',
            'description',
            'created_at',
            'updated_at'
        ];
    }

    protected function getBooleanFilterFields(): array
    {
        return [
            'is_active',
            'is_base_unit',
        ];
    }
}
