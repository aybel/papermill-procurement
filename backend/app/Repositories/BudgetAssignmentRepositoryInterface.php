<?php

namespace App\Repositories;

use App\Models\BudgetAssignment;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface BudgetAssignmentRepositoryInterface
{
    /**
     * Listar asignaciones con filtros opcionales.
     */
    public function getAll(?int $departmentId = null, ?int $categoryId = null, ?int $year = null, string $sortBy = 'year', string $sortDir = 'desc'): Collection;

    /**
     * Obtener una asignación por id.
     */
    public function findById(int $id): ?BudgetAssignment;

    /**
     * Crear una asignación.
     */
    public function create(array $data): BudgetAssignment;

    /**
     * Actualizar una asignación.
     */
    public function update(int $id, array $data): BudgetAssignment;

    /**
     * Eliminar una asignación.
     */
    public function delete(int $id): bool;

    /**
     * Buscar asignaciones por categoría o departamento (texto) con paginación.
     */
    public function search(string $search, int $perPage = 15, ?int $departmentId = null, ?int $categoryId = null, ?int $year = null): LengthAwarePaginator;
}
