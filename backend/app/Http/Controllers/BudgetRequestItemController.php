<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBudgetRequestItemRequest;
use App\Http\Requests\UpdateBudgetRequestItemRequest;
use App\Repositories\BudgetRequestItemRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class BudgetRequestItemController extends Controller
{
    public function __construct(private BudgetRequestItemRepositoryInterface $repository)
    {
    }

    public function index(Request $request): JsonResponse
    {
        return $this->all($request);
    }

    public function all(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'budget_request_id' => 'nullable|integer|exists:budget_requests,id',
                'material_id' => 'nullable|integer|exists:materials,id',
                'sort_by' => 'nullable|string|in:created_at,quantity,estimated_unit_price',
                'sort_dir' => 'nullable|string|in:asc,desc',
            ]);

            $budgetRequestId = $validated['budget_request_id'] ?? null;
            $materialId = $validated['material_id'] ?? null;
            $sortBy = $validated['sort_by'] ?? 'created_at';
            $sortDir = $validated['sort_dir'] ?? 'desc';

            $items = $this->repository->getAll($budgetRequestId, $materialId, $sortBy, $sortDir);

            return response()->json([
                'success' => true,
                'data' => $items,
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
                'message' => 'Error al obtener ítems de solicitudes',
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
                    'message' => 'Ítem de solicitud no encontrado',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $item,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener el ítem de solicitud',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(StoreBudgetRequestItemRequest $request): JsonResponse
    {
        try {
            $item = $this->repository->create($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Ítem de solicitud creado exitosamente',
                'data' => $item,
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
                'message' => 'Error al crear el ítem de solicitud',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(UpdateBudgetRequestItemRequest $request, int $id): JsonResponse
    {
        try {
            $item = $this->repository->update($id, $request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Ítem de solicitud actualizado exitosamente',
                'data' => $item,
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
                'message' => 'Error al actualizar el ítem de solicitud',
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
                'message' => 'Ítem de solicitud eliminado exitosamente',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el ítem de solicitud',
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
                'budget_request_id' => 'nullable|integer|exists:budget_requests,id',
            ]);

            $search = $validated['q'] ?? '';
            $perPage = (int) ($validated['per_page'] ?? 15);
            $budgetRequestId = $validated['budget_request_id'] ?? null;

            $items = $this->repository->search($search, $perPage, $budgetRequestId);

            return response()->json([
                'success' => true,
                'data' => $items,
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
                'message' => 'Error al buscar ítems de solicitudes',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
