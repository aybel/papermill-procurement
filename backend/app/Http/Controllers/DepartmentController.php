<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Repositories\DepartmentRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class DepartmentController extends Controller
{
    public function __construct(private DepartmentRepositoryInterface $repository)
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
                'active' => 'nullable|boolean',
                'sort_by' => 'nullable|string|in:name,code,created_at,updated_at',
                'sort_dir' => 'nullable|string|in:asc,desc',
            ]);

            $onlyActive = array_key_exists('active', $validated) ? (bool) $validated['active'] : null;
            $sortBy = $validated['sort_by'] ?? 'name';
            $sortDir = $validated['sort_dir'] ?? 'asc';

            $items = $this->repository->getAll($onlyActive, $sortBy, $sortDir);

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
                'message' => 'Error al obtener departamentos',
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
                    'message' => 'Departamento no encontrado',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $item,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener el departamento',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(StoreDepartmentRequest $request): JsonResponse
    {
        try {
            $item = $this->repository->create($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Departamento creado exitosamente',
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
                'message' => 'Error al crear el departamento',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(UpdateDepartmentRequest $request, int $id): JsonResponse
    {
        try {
            $item = $this->repository->update($id, $request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Departamento actualizado exitosamente',
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
                'message' => 'Error al actualizar el departamento',
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
                'message' => 'Departamento eliminado exitosamente',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el departamento',
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
                'active' => 'nullable|boolean',
            ]);

            $search = $validated['q'] ?? '';
            $perPage = (int) ($validated['per_page'] ?? 15);
            $onlyActive = array_key_exists('active', $validated) ? (bool) $validated['active'] : null;

            $items = $this->repository->search($search, $perPage, $onlyActive);

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
                'message' => 'Error al buscar departamentos',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
