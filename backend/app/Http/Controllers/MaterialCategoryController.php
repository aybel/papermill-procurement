<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilterMaterialCategoryRequest;
use App\Http\Requests\StoreMaterialCategoryRequest;
use App\Http\Requests\UpdateMaterialCategoryRequest;
use App\Repositories\MaterialCategoryRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class MaterialCategoryController extends Controller
{
    public function __construct(private MaterialCategoryRepositoryInterface $repository) {}

    public function index(Request $request): JsonResponse
    {
        return $this->all($request);
    }

    /**
     * Listado con filtro por categoría padre.
     */
    public function all(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'parent_id' => 'nullable|integer|exists:material_categories,id',
                'sort_by' => 'nullable|string|in:name,created_at,updated_at',
                'sort_dir' => 'nullable|string|in:asc,desc',
            ]);

            $parentId = $validated['parent_id'] ?? null;
            $sortBy = $validated['sort_by'] ?? 'name';
            $sortDir = $validated['sort_dir'] ?? 'asc';

            $categories = $this->repository->getAll($parentId, $sortBy, $sortDir);

            return response()->json([
                'success' => true,
                'data' => $categories,
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
                'message' => 'Error al obtener categorías de material',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show(int $id): JsonResponse
    {
        try {
            $category = $this->repository->findById($id);

            if (! $category) {
                return response()->json([
                    'success' => false,
                    'message' => 'Categoría de material no encontrada',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $category,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener la categoría de material',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(StoreMaterialCategoryRequest $request): JsonResponse
    {
        try {
            $category = $this->repository->create($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Categoría de material creada exitosamente',
                'data' => $category,
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
                'message' => 'Error al crear la categoría de material',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(UpdateMaterialCategoryRequest $request, int $id): JsonResponse
    {
        try {
            $category = $this->repository->update($id, $request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Categoría de material actualizada exitosamente',
                'data' => $category,
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
                'message' => 'Error al actualizar la categoría de material',
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
                'message' => 'Categoría de material eliminada exitosamente',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar la categoría de material',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function search(Request $request): JsonResponse
    {
        try {
            $search = $request->input('q', '');

            $perPage = (int) $request->input('per_page', 15);

            $categories = $this->repository->search($search, $perPage);

            return response()->json([
                'success' => true,
                'data' => $categories,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al buscar categorías de material',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function filter(FilterMaterialCategoryRequest $request): JsonResponse
    {
        try {
            $filters = $request->input('filters', []);
            $orderBy = $request->input('order_by');
            $pagination = $request->input('pagination', []);

            $categories = $this->repository->filter($filters, $orderBy, $pagination);

            return response()->json([
                'success' => true,
                'data' => $categories->items(),
                'meta' => [
                    'total' => $categories->total(),
                    'per_page' => $categories->perPage(),
                    'current_page' => $categories->currentPage(),
                    'last_page' => $categories->lastPage(),
                    'from' => $categories->firstItem(),
                    'to' => $categories->lastItem(),
                ]
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
                'message' => 'Error al filtrar categorías de material',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
