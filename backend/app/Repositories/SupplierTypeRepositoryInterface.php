<?php

namespace App\Repositories;

use App\Models\SupplierType;
use Illuminate\Database\Eloquent\Collection;

interface SupplierTypeRepositoryInterface
{
    /**
     * Listar tipos de proveedor (opcionalmente solo activos).
     */
    public function getAll(bool $onlyActive = false, string $sortBy = 'name', string $sortDir = 'asc'): Collection;

    /**
     * Obtener un tipo por id.
     */
    public function findById(int $id): ?SupplierType;

    /**
     * Crear un tipo de proveedor.
     */
    public function create(array $data): SupplierType;

    /**
     * Actualizar un tipo de proveedor.
     */
    public function update(int $id, array $data): SupplierType;

    /**
     * Eliminar un tipo de proveedor.
     */
    public function delete(int $id): bool;
}
