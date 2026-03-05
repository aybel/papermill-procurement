<?php

namespace App\Policies;

use App\Models\BudgetRequest;
use App\Models\User;

class BudgetRequestPolicy
{
    /**
     * Determina si el usuario puede ver todas las solicitudes de presupuesto.
     */
    public function viewAny(User $user): bool
    {
        // Super admins o usuarios con permiso global
        return $user->can('budget_requests.view_any');
    }

    /**
     * Determina si el usuario puede ver una solicitud específica.
     */
    public function view(User $user, BudgetRequest $budgetRequest): bool
    {
        // 1. Permiso global
        if ($user->can('budget_requests.view_any')) {
            return true;
        }

        // 2. Es de su departamento home
        if ($user->department_id === $budgetRequest->department_id) {
            return true;
        }

        // 3. Tiene acceso funcional al departamento de la solicitud
        return $user->hasAccessToDepartment($budgetRequest->department_id);
    }

    /**
     * Determina si el usuario puede crear solicitudes.
     */
    public function create(User $user): bool
    {
        // Solo puede crear si tiene departamento asignado o es admin
        return $user->can('budget_requests.create') && 
               ($user->department_id !== null || $user->can('budget_requests.view_any'));
    }

    /**
     * Determina si el usuario puede actualizar la solicitud.
     */
    public function update(User $user, BudgetRequest $budgetRequest): bool
    {
        // 1. Permiso global
        if ($user->can('budget_requests.update_any')) {
            return true;
        }

        // 2. Solo puede actualizar solicitudes de departamentos accesibles
        if (!$user->can('budget_requests.update')) {
            return false;
        }

        return $user->department_id === $budgetRequest->department_id ||
               $user->hasAccessToDepartment($budgetRequest->department_id, 'manager');
    }

    /**
     * Determina si el usuario puede aprobar la solicitud.
     */
    public function approve(User $user, BudgetRequest $budgetRequest): bool
    {
        if (!$user->can('budget_requests.approve')) {
            return false;
        }

        // Solo aprobadores y managers de ese departamento
        return $user->hasAccessToDepartment($budgetRequest->department_id, 'approver') ||
               $user->hasAccessToDepartment($budgetRequest->department_id, 'manager');
    }

    /**
     * Determina si el usuario puede eliminar la solicitud.
     */
    public function delete(User $user, BudgetRequest $budgetRequest): bool
    {
        return $user->can('budget_requests.delete_any') ||
               ($user->can('budget_requests.delete') && 
                $user->hasAccessToDepartment($budgetRequest->department_id, 'manager'));
    }
}
