<?php

namespace App\Http\Controllers;

use App\Repositories\SupplierContactRepositoryInterface;
use App\Http\Requests\StoreSupplierContactRequest;
use App\Http\Requests\UpdateSupplierContactRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SupplierContactController extends Controller
{
    public function __construct(private SupplierContactRepositoryInterface $repository)
    {
    }

    public function index(Request $request): JsonResponse
    {
        return $this->all($request);
    }

    public function search(Request $request): JsonResponse
    {
        return $this->all($request);
    }

    public function all(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'supplier_id' => 'nullable|exists:suppliers,id',
                'active' => 'nullable|boolean',
                'is_active' => 'nullable|boolean',
                'sort_by' => 'nullable|string|in:name,email,created_at,updated_at,is_primary',
                'sort_dir' => 'nullable|string|in:asc,desc',
                'order_by_' => 'nullable|string|max:50',
            ]);

            $onlyActive = $request->boolean('active') || $request->boolean('is_active');
            $sortBy = $validated['sort_by'] ?? 'name';
            $sortDir = $validated['sort_dir'] ?? 'asc';
            $orderByRaw = $validated['order_by_'] ?? null;
            $supplierId = $validated['supplier_id'] ?? null;

            if ($orderByRaw) {
                // Expected format: "column dir" e.g., "is_primary desc"
                [$col, $dir] = array_pad(preg_split('/\s+/', trim($orderByRaw), 2), 2, null);
                $allowed = ['name', 'email', 'created_at', 'updated_at', 'is_primary'];
                if ($col && in_array($col, $allowed, true)) {
                    $sortBy = $col;
                    $sortDir = strtolower($dir) === 'desc' ? 'desc' : 'asc';
                }
            }

            $items = $this->repository->getAll($onlyActive, $sortBy, $sortDir, $supplierId);
            //Log::info('SupplierContactController@all - Items retrieved', ['count' => $items->count(), 'filters' => $validated]);
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
                'message' => 'Error al obtener contactos de proveedor',
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
                    'message' => 'Contacto de proveedor no encontrado',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $item,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener el contacto de proveedor',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(StoreSupplierContactRequest $request): JsonResponse
    {
        try {
            $item = $this->repository->create($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Contacto de proveedor creado exitosamente',
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
                'message' => 'Error al crear el contacto de proveedor',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(UpdateSupplierContactRequest $request, int $id): JsonResponse
    {
        try {
            $item = $this->repository->update($id, $request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Contacto de proveedor actualizado exitosamente',
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
                'message' => 'Error al actualizar el contacto de proveedor',
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
                'message' => 'Contacto de proveedor eliminado exitosamente',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el contacto de proveedor',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
