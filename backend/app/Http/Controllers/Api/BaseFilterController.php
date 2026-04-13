<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\FilterRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;

abstract class BaseFilterController extends Controller
{
    protected $model;
    protected $resource;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Endpoint para filtros estructurados
     */
    public function filter(FilterRequest $request): JsonResponse
    {
        try {
            $query = $this->model->newQuery();

            // Aplicar filtros
            if ($request->has('filters')) {
                $query->filter($request->input('filters'));
            }

            // Aplicar ordenamiento
            if ($request->has('order_by')) {
                $query->applyOrderBy($request->input('order_by'));
            }

            // Aplicar paginación
            $perPage = $request->input('pagination.limit', 15);
            $results = $query->paginate($perPage);

            // Transformar con recurso si existe
            if ($this->resource) {
                $data = $this->resource::collection($results);
            } else {
                $data = $results;
            }

            return response()->json([
                'success' => true,
                'data' => $data,
                'meta' => [
                    'total' => $results->total(),
                    'per_page' => $results->perPage(),
                    'current_page' => $results->currentPage(),
                    'last_page' => $results->lastPage(),
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al aplicar filtros',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Búsqueda simple (compatibilidad)
     */
    public function search(FilterRequest $request): JsonResponse
    {
        try {
            $query = $this->model->newQuery();
            $searchTerm = $request->input('q');

            if ($searchTerm) {
                $searchableFields = $this->getSearchableFields();

                if (!empty($searchableFields)) {
                    $query->where(function ($q) use ($searchTerm, $searchableFields) {
                        foreach ($searchableFields as $field) {
                            $q->orWhere($field, 'LIKE', "%{$searchTerm}%");
                        }
                    });
                }
            }

            // Aplicar ordenamiento
            if ($request->has('order_by')) {
                $query->applyOrderBy($request->input('order_by'));
            }

            $perPage = $request->input('per_page', 15);
            $results = $query->paginate($perPage);

            return response()->json([
                'success' => true,
                'data' => $results,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al buscar',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Campos por los que se puede buscar con 'q'
     */
    protected function getSearchableFields(): array
    {
        return ['name', 'description', 'title'];
    }
}
