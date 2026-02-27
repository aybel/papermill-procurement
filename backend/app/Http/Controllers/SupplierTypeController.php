<?php

namespace App\Http\Controllers;

use App\Repositories\SupplierTypeRepositoryInterface;
use App\Http\Requests\StoreSupplierTypeRequest;
use App\Http\Requests\UpdateSupplierTypeRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SupplierTypeController extends Controller
{
    public function __construct(private SupplierTypeRepositoryInterface $repository)
    {
    }

    public function index(Request $request): JsonResponse
    {
        return $this->all($request);
    }

    /**
     * Listado con soporte de filtros básicos: activo, sort_by, sort_dir.
     */
    public function all(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'active' => 'nullable|boolean',
                'sort_by' => 'nullable|string|in:name,code,created_at,updated_at',
                'sort_dir' => 'nullable|string|in:asc,desc',
            ]);

            $onlyActive = (bool) ($validated['active'] ?? false);
            $sortBy = $validated['sort_by'] ?? 'name';
            $sortDir = $validated['sort_dir'] ?? 'asc';

            $types = $this->repository->getAll($onlyActive, $sortBy, $sortDir);

            return response()->json([
                'success' => true,
                'data' => $types,
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
                'message' => 'Error al obtener tipos de proveedor',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show(int $id): JsonResponse
    {
        try {
            $type = $this->repository->findById($id);

            if (! $type) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tipo de proveedor no encontrado',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $type,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener el tipo de proveedor',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(StoreSupplierTypeRequest $request): JsonResponse
    {
        try {
            $type = $this->repository->create($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Tipo de proveedor creado exitosamente',
                'data' => $type,
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
                'message' => 'Error al crear el tipo de proveedor',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(UpdateSupplierTypeRequest $request, int $id): JsonResponse
    {
        try {
            $type = $this->repository->update($id, $request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Tipo de proveedor actualizado exitosamente',
                'data' => $type,
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
                'message' => 'Error al actualizar el tipo de proveedor',
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
                'message' => 'Tipo de proveedor eliminado exitosamente',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el tipo de proveedor',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
