# Sistema de Filtros Avanzados (Backend)

Guía de implementación del sistema de filtros estructurados para el backend en Laravel.

## Objetivo

Estandarizar un endpoint `POST /filter` por entidad con:

- filtros múltiples
- ordenamiento controlado
- paginación
- validación estricta de campos y operadores

## Estructura de archivos

```text
app/
├── Http/
│   ├── Controllers/
│   │   └── [Entity]Controller.php
│   └── Requests/
│       └── Filter[Entity]Request.php
├── Models/
│   └── [Entity].php
└── Repositories/
    ├── [Entity]Repository.php
    └── [Entity]RepositoryInterface.php

routes/
└── api.php
```

## Implementación paso a paso

### 1) Extender el Repository

Archivo: `app/Repositories/[Entity]Repository.php`

```php
/**
 * Filtrado avanzado con múltiples condiciones.
 */
public function filter(array $filters = [], ?array $orderBy = null, ?array $pagination = null): LengthAwarePaginator
{
    $query = $this->model->newQuery();

    if (!empty($filters)) {
        $query = $this->applyFilters($query, $filters);
    }

    if ($orderBy && isset($orderBy['column'], $orderBy['direction'])) {
        $direction = in_array(strtolower($orderBy['direction']), ['asc', 'desc'])
            ? $orderBy['direction']
            : 'asc';

        $query->orderBy($orderBy['column'], $direction);
    } else {
        $query->orderBy('name', 'asc');
    }

    $perPage = $pagination['limit'] ?? 15;
    $page = $pagination['page'] ?? 1;

    return $query->paginate($perPage, ['*'], 'page', $page);
}

/**
 * Aplica los filtros al query builder.
 */
private function applyFilters($query, array $filters)
{
    $allowedFields = ['id', 'name', 'parent_id', 'created_at', 'updated_at'];

    foreach ($filters as $filter) {
        $field = $filter['field'];
        $operator = $filter['operator'];
        $value = $filter['value'] ?? null;

        if (!in_array($field, $allowedFields)) {
            continue;
        }

        switch ($operator) {
            case 'eq':
                $query->where($field, '=', $value);
                break;
            case 'ne':
                $query->where($field, '!=', $value);
                break;
            case 'gt':
                $query->where($field, '>', $value);
                break;
            case 'gte':
                $query->where($field, '>=', $value);
                break;
            case 'lt':
                $query->where($field, '<', $value);
                break;
            case 'lte':
                $query->where($field, '<=', $value);
                break;
            case 'like':
            case 'ilike':
                $query->where($field, 'LIKE', "%{$value}%");
                break;
            case 'in':
                $query->whereIn($field, (array) $value);
                break;
            case 'nin':
                $query->whereNotIn($field, (array) $value);
                break;
            case 'null':
                $query->whereNull($field);
                break;
            case 'notnull':
                $query->whereNotNull($field);
                break;
            case 'between':
                if (is_array($value) && count($value) === 2) {
                    $query->whereBetween($field, $value);
                }
                break;
            case 'startsWith':
                $query->where($field, 'LIKE', "{$value}%");
                break;
            case 'endsWith':
                $query->where($field, 'LIKE', "%{$value}");
                break;
        }
    }

    return $query;
}
```

### 2) Actualizar la Interface

Archivo: `app/Repositories/[Entity]RepositoryInterface.php`

```php
/**
 * Filtrado avanzado con múltiples condiciones.
 */
public function filter(array $filters = [], ?array $orderBy = null, ?array $pagination = null): LengthAwarePaginator;
```

### 3) Crear FormRequest para validación

Archivo: `app/Http/Requests/Filter[Entity]Request.php`

```php
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Filter[Entity]Request extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'filters' => 'sometimes|array',
            'filters.*.field' => 'required|string|in:id,name,parent_id,created_at,updated_at',
            'filters.*.operator' => 'required|string|in:eq,ne,gt,gte,lt,lte,like,ilike,in,nin,null,notnull,between,startsWith,endsWith',
            'filters.*.value' => 'required_unless:filters.*.operator,null,notnull',

            'order_by' => 'sometimes|array',
            'order_by.column' => 'required_with:order_by|string|in:id,name,parent_id,created_at,updated_at',
            'order_by.direction' => 'required_with:order_by|string|in:asc,desc',

            'pagination' => 'sometimes|array',
            'pagination.page' => 'sometimes|integer|min:1',
            'pagination.limit' => 'sometimes|integer|min:1|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'filters.*.field.in' => 'El campo :input no está permitido para filtrado',
            'filters.*.operator.in' => 'El operador :input no es válido',
            'order_by.column.in' => 'La columna :input no está permitida para ordenamiento',
            'pagination.limit.max' => 'El límite no puede ser mayor a 100',
        ];
    }
}
```

### 4) Agregar método en el Controller

Archivo: `app/Http/Controllers/[Entity]Controller.php`

```php
use App\Http\Requests\Filter[Entity]Request;

/**
 * Filtrado avanzado de registros.
 */
public function filter(Filter[Entity]Request $request): JsonResponse
{
    try {
        $filters = $request->input('filters', []);
        $orderBy = $request->input('order_by');
        $pagination = $request->input('pagination', []);

        $results = $this->repository->filter($filters, $orderBy, $pagination);

        return response()->json([
            'success' => true,
            'data' => $results->items(),
            'meta' => [
                'total' => $results->total(),
                'per_page' => $results->perPage(),
                'current_page' => $results->currentPage(),
                'last_page' => $results->lastPage(),
                'from' => $results->firstItem(),
                'to' => $results->lastItem(),
            ],
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
            'message' => 'Error al filtrar registros',
            'error' => $e->getMessage(),
        ], 500);
    }
}
```

### 5) Registrar ruta

Archivo: `routes/api.php`

```php
Route::prefix('[entity-plural]')->group(function () {
    // Rutas existentes (compatibilidad)
    Route::get('/all', [[Entity]Controller::class, 'all']);
    Route::get('/search', [[Entity]Controller::class, 'search']);

    // Nueva ruta para filtros avanzados
    Route::post('/filter', [[Entity]Controller::class, 'filter']);

    // CRUD
    Route::get('/{id}', [[Entity]Controller::class, 'show']);
    Route::post('/', [[Entity]Controller::class, 'store']);
    Route::put('/{id}', [[Entity]Controller::class, 'update']);
    Route::delete('/{id}', [[Entity]Controller::class, 'destroy']);
});
```

## Operadores soportados

| Operador | Descripcion | Ejemplo |
| --- | --- | --- |
| `eq` | Igual | `{"field":"id","operator":"eq","value":5}` |
| `ne` | No igual | `{"field":"status","operator":"ne","value":"inactive"}` |
| `gt` | Mayor que | `{"field":"price","operator":"gt","value":100}` |
| `gte` | Mayor o igual | `{"field":"created_at","operator":"gte","value":"2024-01-01"}` |
| `lt` | Menor que | `{"field":"age","operator":"lt","value":18}` |
| `lte` | Menor o igual | `{"field":"quantity","operator":"lte","value":10}` |
| `like` | Contiene (case sensitive) | `{"field":"name","operator":"like","value":"categoria"}` |
| `ilike` | Contiene (case insensitive) | `{"field":"name","operator":"ilike","value":"material"}` |
| `in` | En lista | `{"field":"id","operator":"in","value":[1,2,3]}` |
| `nin` | No en lista | `{"field":"status","operator":"nin","value":["deleted","archived"]}` |
| `null` | Es nulo | `{"field":"parent_id","operator":"null"}` |
| `notnull` | No es nulo | `{"field":"parent_id","operator":"notnull"}` |
| `between` | Entre valores | `{"field":"price","operator":"between","value":[10,50]}` |
| `startsWith` | Empieza con | `{"field":"email","operator":"startsWith","value":"admin"}` |
| `endsWith` | Termina con | `{"field":"email","operator":"endsWith","value":"@gmail.com"}` |

## Ejemplo de request

```http
POST /api/material-categories/filter
Content-Type: application/json
```

```json
{
  "filters": [
    { "field": "parent_id", "operator": "notnull" },
    { "field": "name", "operator": "ilike", "value": "material" },
    { "field": "created_at", "operator": "gte", "value": "2024-01-01" }
  ],
  "order_by": {
    "column": "name",
    "direction": "asc"
  },
  "pagination": {
    "page": 1,
    "limit": 20
  }
}
```

## Checklist por entidad

- [ ] Extender repository con metodo `filter()`
- [ ] Agregar metodo privado `applyFilters()`
- [ ] Actualizar interface del repository
- [ ] Crear `Filter[Entity]Request` con campos permitidos
- [ ] Agregar metodo `filter()` en controller
- [ ] Registrar ruta `POST /api/[entity]/filter`
- [ ] Probar con Postman/Insomnia
- [ ] Verificar paginacion y ordenamiento

## Consideraciones

- No eliminar endpoints legacy (`/all`, `/search`) hasta completar la migracion.
- Validar campos permitidos en `applyFilters()` por seguridad.
- Usar indices en base de datos para campos frecuentemente filtrados.
- Limitar `per_page` maximo para evitar sobrecarga.

