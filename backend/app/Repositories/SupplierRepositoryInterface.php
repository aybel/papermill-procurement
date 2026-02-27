<?php

namespace App\Repositories;

use App\Models\Supplier;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface SupplierRepositoryInterface
{
    /**
     * Obtener todos los proveedores paginados
     *
     * @param array $filters
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getAllPaginated(array $filters = [], int $perPage = 15): LengthAwarePaginator;

    /**
     * Obtener todos los proveedores sin paginar
     *
     * @param array $filters
     * @return Collection
     */
    public function getAll(array $filters = []): Collection;

    /**
     * Obtener un proveedor por ID
     *
     * @param int $id
     * @return Supplier|null
     */
    public function findById(int $id): ?Supplier;

    /**
     * Obtener un proveedor por código
     *
     * @param string $code
     * @return Supplier|null
     */
    public function findByCode(string $code): ?Supplier;

    /**
     * Crear un nuevo proveedor
     *
     * @param array $data
     * @return Supplier
     */
    public function create(array $data): Supplier;

    /**
     * Actualizar un proveedor existente
     *
     * @param int $id
     * @param array $data
     * @return Supplier
     */
    public function update(int $id, array $data): Supplier;

    /**
     * Eliminar un proveedor (soft delete)
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;

    /**
     * Restaurar un proveedor eliminado
     *
     * @param int $id
     * @return bool
     */
    public function restore(int $id): bool;

    /**
     * Obtener proveedores activos
     *
     * @return Collection
     */
    public function getActive(): Collection;

    /**
     * Buscar proveedores por término
     *
     * @param string $search
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function search(string $search, int $perPage = 15): LengthAwarePaginator;

    /**
     * Actualizar los scores de desempeño
     *
     * @param int $id
     * @param float $qualityScore
     * @param float $deliveryScore
     * @return Supplier
     */
    public function updateScores(int $id, float $qualityScore, float $deliveryScore): Supplier;

    /**
     * Obtener el siguiente código autogenerado para un proveedor.
     * Formato: SUP-<secuencial>.
     */
    public function getNextCode(): string;
}
