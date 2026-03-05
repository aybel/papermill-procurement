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
     * Búsqueda con paginación y control de acceso.
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
     * Si tiene permiso global, devuelve null (sin restricción).
     */
    private function getAccessibleDepartmentIds(?User $user): ?array
    {
        if (!$user) {
            return [];
        }

        // Super admins ven todos los departamentos
        if ($user->can('budget_requests.view_any')) {
            return null; // Sin restricción
        }

        // Usuarios normales ven solo sus departamentos accesibles
        return $user->getAllAccessibleDepartmentIds();
    }
}
