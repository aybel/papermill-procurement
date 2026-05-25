<?php

namespace App\Repositories;

use App\Models\MaterialCategory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface MaterialCategoryRepositoryInterface
{
    /**
     * Listar categorías (permite filtrar por padre).
     */
    public function getAll(?int $parentId = null, string $sortBy = 'name', string $sortDir = 'asc'): Collection;

    /**
     * Obtener una categoría por id.
     */
    public function findById(int $id, bool $withTrashed = false): ?MaterialCategory;

    /**
     * Crear una categoría.
     */
    public function create(array $data): MaterialCategory;

    /**
     * Actualizar una categoría.
     */
    public function update(int $id, array $data): MaterialCategory;

    /**
     * Eliminar una categoría (soft delete).
     */
    public function delete(int $id): bool;

    /**
     * Buscar categorías por nombre.
     */
    public function search(string $search, int $perPage = 15): LengthAwarePaginator;

    /**
     * Filtrado avanzado con múltiples condiciones.
     */
    public function filter(array $filters = [], ?array $orderBy = null, ?array $pagination = null): LengthAwarePaginator|Collection;
}
