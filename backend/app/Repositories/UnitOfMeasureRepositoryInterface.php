<?php

namespace App\Repositories;

use App\Models\UnitOfMeasure;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface UnitOfMeasureRepositoryInterface
{
    /**
     * Listar unidades de medida (permite filtrar por categoría y activo).
     */
    public function getAll(array $filters = [], string $sortBy = 'name', string $sortDir = 'asc'): Collection;

    /**
     * Obtener una unidad por id.
     */
    public function findById(int $id): ?UnitOfMeasure;

    /**
     * Crear una unidad de medida.
     */
    public function create(array $data): UnitOfMeasure;

    /**
     * Actualizar una unidad de medida.
     */
    public function update(int $id, array $data): UnitOfMeasure;

    /**
     * Eliminar una unidad de medida.
     */
    public function delete(int $id): bool;

    /**
     * Buscar unidades por nombre o código.
     */
    public function search(string $search, int $perPage = 15): LengthAwarePaginator;
}
