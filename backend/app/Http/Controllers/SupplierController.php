<?php

namespace App\Http\Controllers;

use App\Repositories\SupplierRepositoryInterface;
use Illuminate\Container\Attributes\Log;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class SupplierController extends Controller
{
    protected $supplierRepository;

    public function __construct(SupplierRepositoryInterface $supplierRepository)
    {
        $this->supplierRepository = $supplierRepository;
    }

    /**
     * Listar todos los proveedores
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $filters = [
                'search' => $request->input('search'),
                'supplier_type_id' => $request->input('supplier_type_id'),
                'supplier_status_id' => $request->input('supplier_status_id'),
                'active' => $request->boolean('active'),
                'sort_by' => $request->input('sort_by', 'name'),
                'sort_order' => $request->input('sort_order', 'asc'),
            ];

            $perPage = $request->input('per_page', 15);
            $suppliers = $this->supplierRepository->getAllPaginated($filters, $perPage);
            //Log::info('Suppliers fetched', ['count' => count($suppliers->items())]);
            return response()->json([
                'success' => true,
                'data' => $suppliers,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener los proveedores',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Obtener proveedores activos para select
     *
     * @return JsonResponse
     */
    public function active(): JsonResponse
    {
        try {
            $suppliers = $this->supplierRepository->getActive();

            return response()->json([
                'success' => true,
                'data' => $suppliers,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener proveedores activos',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Mostrar un proveedor específico
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $supplier = $this->supplierRepository->findById($id);

            if (!$supplier) {
                return response()->json([
                    'success' => false,
                    'message' => 'Proveedor no encontrado',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $supplier,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener el proveedor',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Crear un nuevo proveedor
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'code' => 'required|string|max:20|unique:suppliers,code',
                'name' => 'required|string|max:255',
                'tax_id' => 'nullable|string|max:20',
                'supplier_type_id' => 'nullable|exists:supplier_types,id',
                'supplier_status_id' => 'required|exists:supplier_statuses,id',
                'primary_contact_id' => 'nullable|exists:supplier_contacts,id',
                'quality_score' => 'nullable|numeric|min:0|max:1',
                'delivery_score' => 'nullable|numeric|min:0|max:1',
                'payment_terms_id' => 'required|exists:payment_terms,id',
                'currency_id' => 'required|exists:currencies,id',
                'credit_limit' => 'nullable|numeric|min:0',
                'notes' => 'nullable|string|max:500',
            ]);

            $supplier = $this->supplierRepository->create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Proveedor creado exitosamente',
                'data' => $supplier,
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
                'message' => 'Error al crear el proveedor',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Actualizar un proveedor existente
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $validated = $request->validate([
                'code' => 'sometimes|required|string|max:20|unique:suppliers,code,' . $id,
                'name' => 'sometimes|required|string|max:255',
                'tax_id' => 'nullable|string|max:20',
                'supplier_type_id' => 'nullable|exists:supplier_types,id',
                'supplier_status_id' => 'sometimes|required|exists:supplier_statuses,id',
                'primary_contact_id' => 'nullable|exists:supplier_contacts,id',
                'quality_score' => 'nullable|numeric|min:0|max:1',
                'delivery_score' => 'nullable|numeric|min:0|max:1',
                'payment_terms_id' => 'sometimes|required|exists:payment_terms,id',
                'currency_id' => 'sometimes|required|exists:currencies,id',
                'credit_limit' => 'nullable|numeric|min:0',
                'notes' => 'nullable|string|max:500',
            ]);

            $supplier = $this->supplierRepository->update($id, $validated);

            return response()->json([
                'success' => true,
                'message' => 'Proveedor actualizado exitosamente',
                'data' => $supplier,
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
                'message' => 'Error al actualizar el proveedor',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Eliminar un proveedor (soft delete)
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $this->supplierRepository->delete($id);

            return response()->json([
                'success' => true,
                'message' => 'Proveedor eliminado exitosamente',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el proveedor',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Restaurar un proveedor eliminado
     *
     * @param int $id
     * @return JsonResponse
     */
    public function restore(int $id): JsonResponse
    {
        try {
            $this->supplierRepository->restore($id);

            return response()->json([
                'success' => true,
                'message' => 'Proveedor restaurado exitosamente',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al restaurar el proveedor',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Buscar proveedores
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function search(Request $request): JsonResponse
    {
        try {
            $search = $request->input('q', '');
            $perPage = $request->input('per_page', 15);

            $suppliers = $this->supplierRepository->search($search, $perPage);

            return response()->json([
                'success' => true,
                'data' => $suppliers,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al buscar proveedores',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Actualizar scores de desempeño
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function updateScores(Request $request, int $id): JsonResponse
    {
        try {
            $validated = $request->validate([
                'quality_score' => 'required|numeric|min:0|max:1',
                'delivery_score' => 'required|numeric|min:0|max:1',
            ]);

            $supplier = $this->supplierRepository->updateScores(
                $id,
                $validated['quality_score'],
                $validated['delivery_score']
            );

            return response()->json([
                'success' => true,
                'message' => 'Scores actualizados exitosamente',
                'data' => $supplier,
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
                'message' => 'Error al actualizar scores',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
