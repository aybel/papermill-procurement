<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUnitOfMeasureRequest;
use App\Http\Requests\UpdateUnitOfMeasureRequest;
use App\Repositories\UnitOfMeasureRepositoryInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UnitOfMeasureController extends Controller
{
    public function __construct(private UnitOfMeasureRepositoryInterface $repository)
    {
    }

    public function index(Request $request): JsonResponse
    {
        return $this->all($request);
    }

    /**
     * Listado con filtros por categoría y estado.
     */
    public function all(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'category' => 'nullable|string|max:50',
                'is_active' => 'nullable|boolean',
                'is_base_unit' => 'nullable|boolean',
                'sort_by' => 'nullable|string|in:name,code,category,created_at,updated_at',
                'sort_dir' => 'nullable|string|in:asc,desc',
            ]);

            $filters = [
                'category' => $validated['category'] ?? null,
                'is_active' => $validated['is_active'] ?? 1,
                'is_base_unit' => $validated['is_base_unit'] ?? null,
            ];

            $sortBy = $validated['sort_by'] ?? 'name';
            $sortDir = $validated['sort_dir'] ?? 'asc';

            $units = $this->repository->getAll($filters, $sortBy, $sortDir);

            Log::info('Unidades de medida obtenidas', ['filters' => $filters, 'sort_by' => $sortBy, 'sort_dir' => $sortDir]);

            return response()->json([
                'success' => true,
                'data' => $units,
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
                'message' => 'Error al obtener unidades de medida',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show(int $id): JsonResponse
    {
        try {
            $unit = $this->repository->findById($id);

            if (! $unit) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unidad de medida no encontrada',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $unit,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener la unidad de medida',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(StoreUnitOfMeasureRequest $request): JsonResponse
    {
        try {
            $unit = $this->repository->create($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Unidad de medida creada exitosamente',
                'data' => $unit,
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
                'message' => 'Error al crear la unidad de medida',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(UpdateUnitOfMeasureRequest $request, int $id): JsonResponse
    {
        try {
            $unit = $this->repository->update($id, $request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Unidad de medida actualizada exitosamente',
                'data' => $unit,
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
                'message' => 'Error al actualizar la unidad de medida',
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
                'message' => 'Unidad de medida eliminada exitosamente',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar la unidad de medida',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function search(Request $request): JsonResponse
    {
        try {
            $search = $request->input('q', '');
            $perPage = (int) $request->input('per_page', 15);

            $units = $this->repository->search($search, $perPage);

            return response()->json([
                'success' => true,
                'data' => $units,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al buscar unidades de medida',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function filter(Request $request): JsonResponse
    {
        try {
            $filters = $request->input('filters', []);
            $orderBy = $request->input('order_by', null);
            $pagination = $request->input('pagination', null);

            Log::info('Filtro de unidades de medida', ['filters' => $filters, 'order_by' => $orderBy, 'pagination' => $pagination]);

            $units = $this->repository->filter($filters, $orderBy, $pagination);

            return response()->json([
                'success' => true,
                'data' => $units,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al filtrar unidades de medida',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
