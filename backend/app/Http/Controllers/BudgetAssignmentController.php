<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBudgetAssignmentRequest;
use App\Http\Requests\UpdateBudgetAssignmentRequest;
use App\Repositories\BudgetAssignmentRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class BudgetAssignmentController extends Controller
{
    public function __construct(private BudgetAssignmentRepositoryInterface $repository) {}

    public function index(Request $request): JsonResponse
    {
        return $this->all($request);
    }

    public function all(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'department_id' => 'nullable|integer|exists:departments,id',
                'budget_category_id' => 'nullable|integer|exists:budget_categories,id',
                'year' => 'nullable|integer|digits:4',
                'sort_by' => 'nullable|string|in:year,assigned_amount,created_at,updated_at',
                'sort_dir' => 'nullable|string|in:asc,desc',
            ]);

            $departmentId = $validated['department_id'] ?? null;
            $categoryId = $validated['budget_category_id'] ?? null;
            $year = $validated['year'] ?? null;
            $sortBy = $validated['sort_by'] ?? 'year';
            $sortDir = $validated['sort_dir'] ?? 'desc';

            $items = $this->repository->getAll($departmentId, $categoryId, $year, $sortBy, $sortDir);

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
                'message' => 'Error al obtener asignaciones de presupuesto',
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
                    'message' => 'Asignación de presupuesto no encontrada',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $item,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener la asignación de presupuesto',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(StoreBudgetAssignmentRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $data['created_by'] = $request->user()->id;

            $item = $this->repository->create($data);
            $item = $this->repository->findById($item->id);
            return response()->json([
                'success' => true,
                'message' => 'Asignación de presupuesto creada exitosamente',
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
                'message' => 'Error al crear la asignación de presupuesto',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(UpdateBudgetAssignmentRequest $request, int $id): JsonResponse
    {
        try {
            $item = $this->repository->update($id, $request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Asignación de presupuesto actualizada exitosamente',
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
                'message' => 'Error al actualizar la asignación de presupuesto',
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
                'message' => 'Asignación de presupuesto eliminada exitosamente',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar la asignación de presupuesto',
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
                'budget_category_id' => 'nullable|integer|exists:budget_categories,id',
                'year' => 'nullable|integer|digits:4',
            ]);

            $search = $validated['q'] ?? '';
            $perPage = (int) ($validated['per_page'] ?? 15);
            $departmentId = $validated['department_id'] ?? null;
            $categoryId = $validated['budget_category_id'] ?? null;
            $year = $validated['year'] ?? null;

            $items = $this->repository->search($search, $perPage, $departmentId, $categoryId, $year);

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
                'message' => 'Error al buscar asignaciones de presupuesto',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
