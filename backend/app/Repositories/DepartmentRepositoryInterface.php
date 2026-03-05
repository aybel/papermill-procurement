<?php

namespace App\Repositories;

use App\Models\Department;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface DepartmentRepositoryInterface
{
    /**
     * Listar departamentos con filtro opcional por estado.
     */
    public function getAll(?bool $onlyActive = null, string $sortBy = 'name', string $sortDir = 'asc'): Collection;

    /**
     * Obtener un departamento por id.
     */
    public function findById(int $id): ?Department;

    /**
     * Crear un departamento.
     */
    public function create(array $data): Department;

    /**
     * Actualizar un departamento.
     */
    public function update(int $id, array $data): Department;

    /**
     * Eliminar un departamento.
     */
    public function delete(int $id): bool;

    /**
     * Buscar por nombre o código.
     */
    public function search(string $search, int $perPage = 15, ?bool $onlyActive = null): LengthAwarePaginator;
}
