<?php

namespace App\Services\BudgetRequest;

use App\DTOs\Input\BudgetRequest\BudgetRequestSearchDTO;
use App\DTOs\Read\BudgetRequest\BudgetRequestListItemDTO;
use App\Models\User;
use App\Repositories\BudgetRequestRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class BudgetRequestQueryService
{
    public function __construct(private BudgetRequestRepositoryInterface $repository)
    {
    }

    /**
     * Obtiene todas las solicitudes con filtros y control de acceso por departamento.
     * Si no se pasa usuario, usa el autenticado actual.
     */
    public function getAll(BudgetRequestSearchDTO $filters, ?User $user = null): Collection
    {
        $user = $user ?? auth()->user();

        $items = $this->repository->getAll(
            departmentId: $filters->departmentId,
            statusId: $filters->statusId,
            year: $filters->year,
            sortBy: $filters->sortBy,
            sortDir: $filters->sortDir,
            accessibleDepartmentIds: $this->getAccessibleDepartmentIds($user),
        );

        return $items->map(fn ($item) => BudgetRequestListItemDTO::fromModel($item));
    }

    /**
     * Búsqueda con paginación y control de acceso por departamento.
     */
    public function search(BudgetRequestSearchDTO $filters, ?User $user = null): LengthAwarePaginator
    {
        $user = $user ?? auth()->user();

        $items = $this->repository->search(
            search: (string) ($filters->search ?? ''),
            perPage: $filters->perPage,
            departmentId: $filters->departmentId,
            statusId: $filters->statusId,
            year: $filters->year,
            accessibleDepartmentIds: $this->getAccessibleDepartmentIds($user),
        );

        $items->setCollection(
            $items->getCollection()->map(fn ($item) => BudgetRequestListItemDTO::fromModel($item))
        );

        return $items;
    }

    /**
     * Obtiene los IDs de departamentos accesibles para el usuario.
     * - Si tiene permiso global, devuelve null (sin restricción).
     * - Si no tiene permisos, devuelve array vacío (sin acceso).
     * - Si tiene departamentos asignados, devuelve esos IDs.
     */
    private function getAccessibleDepartmentIds(?User $user): ?array
    {
        if (!$user) {
            return []; // Sin autenticación = sin acceso
        }

        // Super admins ven todos los departamentos (sin restricción)
        if ($user->can('budget_requests.view_any')) {
            return null;
        }

        // Usuarios normales ven solo sus departamentos accesibles
        return $user->getAllAccessibleDepartmentIds();
    }
}
