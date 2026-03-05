<?php

namespace App\Repositories;

use App\Models\BudgetCategory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface BudgetCategoryRepositoryInterface
{
    /**
     * Listar categorías presupuestarias con filtro opcional por estado.
     */
    public function getAll(?bool $onlyActive = null, string $sortBy = 'name', string $sortDir = 'asc'): Collection;

    /**
     * Obtener una categoría por id.
     */
    public function findById(int $id): ?BudgetCategory;

    /**
     * Crear una categoría.
     */
    public function create(array $data): BudgetCategory;

    /**
     * Actualizar una categoría.
     */
    public function update(int $id, array $data): BudgetCategory;

    /**
     * Eliminar una categoría.
     */
    public function delete(int $id): bool;

    /**
     * Buscar categorías por nombre o descripción.
     */
    public function search(string $search, int $perPage = 15, ?bool $onlyActive = null): LengthAwarePaginator;
}
