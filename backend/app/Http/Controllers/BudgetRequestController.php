<?php

namespace App\Http\Controllers;

use App\DTOs\Input\BudgetRequest\BudgetRequestSearchDTO;
use App\Http\Requests\StoreBudgetRequestRequest;
use App\Http\Requests\UpdateBudgetRequestRequest;
use App\Http\Resources\BudgetRequest\BudgetRequestCollection;
use App\Http\Resources\BudgetRequest\BudgetRequestResource;
use App\Repositories\BudgetRequestRepositoryInterface;
use App\Services\BudgetRequest\BudgetRequestQueryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class BudgetRequestController extends Controller
{
    public function __construct(
        private BudgetRequestRepositoryInterface $repository,
        private BudgetRequestQueryService $queryService,
    ) {}

    public function index(Request $request): JsonResponse
    {
        return $this->all($request);
    }

    public function all(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'department_id' => 'nullable|integer|exists:departments,id',
                'status_id' => 'nullable|integer|exists:budget_request_statuses,id',
                'year' => 'nullable|integer|digits:4',
                'sort_by' => 'nullable|string|in:created_at,year',
                'sort_dir' => 'nullable|string|in:asc,desc',
            ]);

            $filters = BudgetRequestSearchDTO::fromValidated($validated);
            $data = $this->queryService->getAll($filters);

            return response()->json([
                'success' => true,
                'data' => (new BudgetRequestCollection($data))->resolve(),
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Errores de validación',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener solicitudes de presupuesto',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show(int $id): JsonResponse
    {
        try {
            $item = $this->repository->findById($id);

            if (! $item) {
                return response()->json([
                    'success' => false,
                    'message' => 'Solicitud de presupuesto no encontrada',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => (new BudgetRequestResource($item))->resolve(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener la solicitud de presupuesto',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(StoreBudgetRequestRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            if (! ($data['submitted_by'] ?? false) && $request->user()) {
                $data['submitted_by'] = $request->user()->id;
            }

            $item = $this->repository->create($data);
            $item = $this->repository->findById($item->id) ?? $item;

            return response()->json([
                'success' => true,
                'message' => 'Solicitud de presupuesto creada exitosamente',
                'data' => (new BudgetRequestResource($item))->resolve(),
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Errores de validación',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear la solicitud de presupuesto',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(UpdateBudgetRequestRequest $request, int $id): JsonResponse
    {
        try {
            $item = $this->repository->update($id, $request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Solicitud de presupuesto actualizada exitosamente',
                'data' => (new BudgetRequestResource($item))->resolve(),
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Errores de validación',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar la solicitud de presupuesto',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $this->repository->delete($id);

            return response()->json([
                'success' => true,
                'message' => 'Solicitud de presupuesto eliminada exitosamente',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar la solicitud de presupuesto',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function search(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'q' => 'nullable|string',
                'per_page' => 'nullable|integer|min:1|max:100',
                'department_id' => 'nullable|integer|exists:departments,id',
                'status_id' => 'nullable|integer|exists:budget_request_statuses,id',
                'year' => 'nullable|integer|digits:4',
                'sort_by' => 'nullable|string|in:created_at,year',
                'sort_dir' => 'nullable|string|in:asc,desc',
            ]);

            $filters = BudgetRequestSearchDTO::fromValidated($validated);
            $data = $this->queryService->search($filters);

            return response()->json([
                'success' => true,
                'data' => (new BudgetRequestCollection($data))->resolve(),
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Errores de validación',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al buscar solicitudes de presupuesto',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
