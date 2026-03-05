<?php

namespace App\Http\Traits;

use Illuminate\Database\Eloquent\Builder;

trait FiltersByDepartmentAccess
{
    /**
     * Aplica filtro de departamentos según el acceso del usuario autenticado.
     * 
     * @param Builder $query
     * @param string $departmentColumn Nombre de la columna de departamento (ej: 'department_id')
     * @return Builder
     */
    public function scopeAccessibleByUser(Builder $query, string $departmentColumn = 'department_id'): Builder
    {
        $user = auth()->user();

        if (!$user) {
            return $query->whereRaw('1 = 0'); // Sin acceso si no autenticado
        }

        // Super admins ven todo
        if ($user->can('budget_requests.view_any')) {
            return $query;
        }

        // Obtener IDs de departamentos accesibles
        $accessibleDepartmentIds = $user->getAllAccessibleDepartmentIds();

        if (empty($accessibleDepartmentIds)) {
            return $query->whereRaw('1 = 0'); // Sin acceso
        }

        return $query->whereIn($departmentColumn, $accessibleDepartmentIds);
    }
}
