<?php

namespace App\Repositories;

use App\Models\Material;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface MaterialRepositoryInterface
{
    /**
     * Obtener materiales paginados con filtros.
     */
    public function getAllPaginated(array $filters = [], int $perPage = 15): LengthAwarePaginator;

    /**
     * Obtener todos los materiales sin paginar.
     */
    public function getAll(array $filters = []): Collection;

    /**
     * Obtener un material por ID.
     */
    public function findById(int $id): ?Material;

    /**
     * Obtener un material por SKU.
     */
    public function findBySku(string $sku): ?Material;

    /**
     * Crear un material.
     */
    public function create(array $data): Material;

    /**
     * Actualizar un material.
     */
    public function update(int $id, array $data): Material;

    /**
     * Eliminar un material.
     */
    public function delete(int $id): bool;

    /**
     * Buscar materiales por término.
     */
    public function search(string $search, int $perPage = 15): LengthAwarePaginator;
}
