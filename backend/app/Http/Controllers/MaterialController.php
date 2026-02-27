<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMaterialRequest;
use App\Http\Requests\UpdateMaterialRequest;
use App\Repositories\MaterialRepositoryInterface;
use App\Services\SKUGenerator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class MaterialController extends Controller
{
    protected $materialRepository;

    public function __construct(MaterialRepositoryInterface $materialRepository)
    {
        $this->materialRepository = $materialRepository;
    }

    /**
     * Listar materiales paginados.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $filters = [
                'search' => $request->input('search'),
                'category_id' => $request->input('category_id'),
                'material_type_id' => $request->input('material_type_id'),
                'unit_of_measure_id' => $request->input('unit_of_measure_id'),
                'currency_id' => $request->input('currency_id'),
                'sort_by' => $request->input('sort_by', 'name'),
                'sort_order' => $request->input('sort_order', 'asc'),
            ];

            $perPage = $request->input('per_page', 15);
            $materials = $this->materialRepository->getAllPaginated($filters, $perPage);

            return response()->json([
                'success' => true,
                'data' => $materials,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener los materiales',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Mostrar un material.
     */
    public function show(int $id): JsonResponse
    {
        try {
            $material = $this->materialRepository->findById($id);

            if (!$material) {
                return response()->json([
                    'success' => false,
                    'message' => 'Material no encontrado',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $material,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener el material',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Crear un material.
     */
    public function store(StoreMaterialRequest $request): JsonResponse
    {
        try {

            if (!$request->has('sku')) {
                $skuGenerator = new SKUGenerator();
                $request->merge([
                    'sku' => $skuGenerator->generate($request->all())
                ]);
            }

            $material = $this->materialRepository->create($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Material creado exitosamente',
                'data' => $material,
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
                'message' => 'Error al crear el material',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Actualizar un material.
     */
    public function update(UpdateMaterialRequest $request, int $id): JsonResponse
    {
        try {
            $material = $this->materialRepository->update($id, $request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Material actualizado exitosamente',
                'data' => $material,
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
                'message' => 'Error al actualizar el material',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Eliminar un material.
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $this->materialRepository->delete($id);

            return response()->json([
                'success' => true,
                'message' => 'Material eliminado exitosamente',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el material',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Buscar materiales.
     */
    public function search(Request $request): JsonResponse
    {
        try {
            $search = $request->input('q', '');
            $perPage = $request->input('per_page', 15);

            $materials = $this->materialRepository->search($search, $perPage);

            return response()->json([
                'success' => true,
                'data' => $materials,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al buscar materiales',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
