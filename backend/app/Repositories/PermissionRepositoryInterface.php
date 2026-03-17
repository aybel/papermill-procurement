<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;

interface PermissionRepositoryInterface
{
    /**
     * Obtener todos los permisos.
     */
    public function getAll(): Collection;

    /**
     * Buscar permisos por nombre.
     * @param array $orderBy  Ej: ['column' => 'name', 'direction' => 'asc']
     */
    public function search(string $search, array $filters = [], array $orderBy = []): Collection;
}
