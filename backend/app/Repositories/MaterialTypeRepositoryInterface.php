<?php

namespace App\Repositories;

use App\Models\MaterialType;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface MaterialTypeRepositoryInterface
{
    /**
     * Listar tipos de material (opcionalmente solo activos).
     */
    public function getAll(bool $onlyActive = false, string $sortBy = 'name', string $sortDir = 'asc'): Collection;

    /**
     * Obtener un tipo de material por id.
     */
    public function findById(int $id): ?MaterialType;

    /**
     * Crear un tipo de material.
     */
    public function create(array $data): MaterialType;

    /**
     * Actualizar un tipo de material.
     */
    public function update(int $id, array $data): MaterialType;

    /**
     * Eliminar un tipo de material.
     */
    public function delete(int $id): bool;

    /**
     * Buscar tipos de material paginados.
     */
    public function search(string $search, int $perPage = 15): LengthAwarePaginator;
     /**
     * Filtrado avanzado con múltiples condiciones.
     */
    public function filter(array $filters = [], ?array $orderBy = null, ?array $pagination = null): LengthAwarePaginator|Collection;
}
