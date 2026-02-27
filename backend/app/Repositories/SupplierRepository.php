<?php

namespace App\Repositories;

use App\Models\Supplier;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class SupplierRepository implements SupplierRepositoryInterface
{
    protected $model;

    public function __construct(Supplier $model)
    {
        $this->model = $model;
    }

    /**
     * Obtener todos los proveedores paginados
     */
    public function getAllPaginated(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = $this->model->with([
            'supplierType',
            'supplierStatus',
            'primaryContact',
            'paymentTerms',
            'currency'
        ]);

        // Aplicar filtros
        if (isset($filters['search'])) {
            $query->search($filters['search']);
        }

        if (isset($filters['supplier_type_id'])) {
            $query->ofType($filters['supplier_type_id']);
        }

        if (isset($filters['supplier_status_id'])) {
            $query->where('supplier_status_id', $filters['supplier_status_id']);
        }

        if (isset($filters['active']) && $filters['active']) {
            $query->active();
        }

        // Ordenamiento
        $sortBy = $filters['sort_by'] ?? 'name';
        $sortOrder = $filters['sort_order'] ?? 'asc';
        $query->orderBy($sortBy, $sortOrder);

        return $query->paginate($perPage);
    }

    /**
     * Obtener todos los proveedores sin paginar
     */
    public function getAll(array $filters = []): Collection
    {
        $query = $this->model->with([
            'supplierType',
            'supplierStatus',
            'currency'
        ]);

        if (isset($filters['active']) && $filters['active']) {
            $query->active();
        }

        return $query->get();
    }

    /**
     * Obtener un proveedor por ID
     */
    public function findById(int $id): ?Supplier
    {
        return $this->model->with([
            'supplierType',
            'supplierStatus',
            'primaryContact',
            'contacts' => function ($query) {
                $query->where('is_active', true)->orderBy('is_primary', 'desc');
            },
            'paymentTerms',
            'currency'
        ])->find($id);
    }

    /**
     * Obtener un proveedor por código
     */
    public function findByCode(string $code): ?Supplier
    {
        return $this->model->where('code', $code)->first();
    }

    /**
     * Crear un nuevo proveedor
     */
    public function create(array $data): Supplier
    {
        return $this->model->create($data);
    }

    /**
     * Actualizar un proveedor existente
     */
    public function update(int $id, array $data): Supplier
    {
        $supplier = $this->model->findOrFail($id);
        $supplier->update($data);
        return $supplier->fresh();
    }

    /**
     * Eliminar un proveedor (soft delete)
     */
    public function delete(int $id): bool
    {
        $supplier = $this->model->findOrFail($id);
        return $supplier->delete();
    }

    /**
     * Restaurar un proveedor eliminado
     */
    public function restore(int $id): bool
    {
        $supplier = $this->model->withTrashed()->findOrFail($id);
        return $supplier->restore();
    }

    /**
     * Obtener proveedores activos
     */
    public function getActive(): Collection
    {
        return $this->model->active()
            ->with(['supplierType', 'currency'])
            ->orderBy('name')
            ->get();
    }

    /**
     * Buscar proveedores por término
     */
    public function search(string $search, int $perPage = 15): LengthAwarePaginator
    {
        return $this->model->search($search)
            ->with([
                'supplierType',
                'supplierStatus',
                'currency'
            ])
            ->paginate($perPage);
    }

    /**
     * Actualizar los scores de desempeño
     */
    public function updateScores(int $id, float $qualityScore, float $deliveryScore): Supplier
    {
        $supplier = $this->model->findOrFail($id);
        $supplier->update([
            'quality_score' => $qualityScore,
            'delivery_score' => $deliveryScore,
        ]);
        return $supplier->fresh();
    }

    /**
     * Obtener el siguiente código autogenerado.
     * Formato: SUP-<secuencial> basado en el máximo actual (incluye soft deletes).
     */
    public function getNextCode(): string
    {
        $maxNumericCode = $this->model
            ->withTrashed()
            ->where('code', 'like', 'SUP-%')
            ->selectRaw("MAX(CAST(SUBSTRING(code, 5) AS UNSIGNED)) as max_code")
            ->value('max_code');

        $next = ((int) $maxNumericCode) + 1;

        return 'SUP-' . $next;
    }
}
