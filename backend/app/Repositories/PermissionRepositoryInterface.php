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
     * Buscar permisos por nombre y filtros adicionales.
     * Filtros soportados:
     *   - resource: valor exacto, o la cadena "NOT NULL" para whereNotNull.
     * @param array $orderBy  Ej: ['column' => 'name', 'direction' => 'asc']
     */
    public function search(string $search, array $filters = [], array $orderBy = []): Collection;
}
