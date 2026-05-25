<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMaterialTypeRequest;
use App\Http\Requests\UpdateMaterialTypeRequest;
use App\Http\Requests\FilterMaterialTypeRequest;
use App\Repositories\MaterialTypeRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Http\Responses\FilterResponse;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class MaterialTypeController extends Controller
{
    public function __construct(private MaterialTypeRepositoryInterface $repository) {}

    public function index(Request $request): JsonResponse
    {
        return $this->all($request);
    }

    /**
     * Listado con filtros básicos: activo, sort_by, sort_dir.
     */
    public function all(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'is_active' => 'nullable|numeric|in:0,1',
                'sort_by' => 'nullable|string|in:name,code,sort_order,created_at,updated_at',
                'sort_dir' => 'nullable|string|in:asc,desc',
            ]);

            $onlyActive = (bool) ($validated['is_active'] ?? 1);
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
                'message' => 'Error al obtener tipos de material',
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
                    'message' => 'Tipo de material no encontrado',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $type,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener el tipo de material',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(StoreMaterialTypeRequest $request): JsonResponse
    {
        try {
            $type = $this->repository->create($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Tipo de material creado exitosamente',
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
                'message' => 'Error al crear el tipo de material',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(UpdateMaterialTypeRequest $request, int $id): JsonResponse
    {
        try {
            $type = $this->repository->update($id, $request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Tipo de material actualizado exitosamente',
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
                'message' => 'Error al actualizar el tipo de material',
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
                'message' => 'Tipo de material eliminado exitosamente',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el tipo de material',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function search(Request $request): JsonResponse
    {
        try {
            $search = $request->input('q', '');
            $perPage = (int) $request->input('per_page', 15);

            $types = $this->repository->search($search, $perPage);

            return response()->json([
                'success' => true,
                'data' => $types,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al buscar tipos de material',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function filter(FilterMaterialTypeRequest $request): JsonResponse
    {
        try {
            $filters = $request->input('filters', []);
            $orderBy = $request->input('order_by');
            $pagination = $request->input('pagination', null);

            $result = $this->repository->filter($filters, $orderBy, $pagination);

            $response = $result instanceof LengthAwarePaginator
                ? FilterResponse::fromPaginator($result)
                : FilterResponse::fromCollection($result);
            return response()->json($response->toResponse());
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Errores de validación',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al filtrar tipos de material',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
