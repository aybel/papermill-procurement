<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBudgetRequestStatusRequest;
use App\Http\Requests\UpdateBudgetRequestStatusRequest;
use App\Repositories\BudgetRequestStatusRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class BudgetRequestStatusController extends Controller
{
    public function __construct(private BudgetRequestStatusRepositoryInterface $repository)
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
                'sort_by' => 'nullable|string|in:name,created_at,updated_at',
                'sort_dir' => 'nullable|string|in:asc,desc',
            ]);

            $sortBy = $validated['sort_by'] ?? 'name';
            $sortDir = $validated['sort_dir'] ?? 'asc';

            $items = $this->repository->getAll($sortBy, $sortDir);

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
                'message' => 'Error al obtener estados de solicitudes',
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
                    'message' => 'Estado de solicitud no encontrado',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $item,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener el estado de solicitud',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(StoreBudgetRequestStatusRequest $request): JsonResponse
    {
        try {
            $item = $this->repository->create($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Estado de solicitud creado exitosamente',
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
                'message' => 'Error al crear el estado de solicitud',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(UpdateBudgetRequestStatusRequest $request, int $id): JsonResponse
    {
        try {
            $item = $this->repository->update($id, $request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Estado de solicitud actualizado exitosamente',
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
                'message' => 'Error al actualizar el estado de solicitud',
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
                'message' => 'Estado de solicitud eliminado exitosamente',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el estado de solicitud',
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
            ]);

            $search = $validated['q'] ?? '';
            $perPage = (int) ($validated['per_page'] ?? 15);

            $items = $this->repository->search($search, $perPage);

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
                'message' => 'Error al buscar estados de solicitudes',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
