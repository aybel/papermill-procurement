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
│   ├── Requests/
│   │   └── Filter[Entity]Request.php
│   └── Responses/
│       └── FilterResponse.php          ← clase compartida para todos los controllers
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

La paginación es **opcional**. Si no se envía `pagination`, se retorna una `Collection` con todos los registros. Si se envía, se retorna un `LengthAwarePaginator`.

```php
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Filtrado avanzado con múltiples condiciones.
 * Retorna Collection si no hay paginación, LengthAwarePaginator si la hay.
 */
public function filter(array $filters = [], ?array $orderBy = null, ?array $pagination = null): LengthAwarePaginator|Collection
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

    // Caso 1: Sin paginación → traer todos los registros
    if (is_null($pagination)) {
        return $query->get();
    }

    // Caso 2: Paginación con límite personalizado
    $perPage = $pagination['limit'] ?? 15;
    $page    = $pagination['page'] ?? 1;

    // Caso especial: limit 0 o null → traer todos
    if ($perPage === 0 || $perPage === null) {
        return $query->get();
    }

    return $query->paginate($perPage, ['*'], 'page', $page);
}

/**
 * Aplica los filtros al query builder.
 * Valida campos permitidos mediante isValidField().
 */
private function applyFilters($query, array $filters)
{
    foreach ($filters as $filter) {
        if (!isset($filter['field'], $filter['operator'])) {
            continue;
        }

        $field    = $filter['field'];
        $operator = $filter['operator'];
        $value    = $filter['value'] ?? null;

        if (!$this->isValidField($field)) {
            continue;
        }

        switch ($operator) {
            case 'eq':         $query->where($field, '=', $value); break;
            case 'ne':         $query->where($field, '!=', $value); break;
            case 'gt':         $query->where($field, '>', $value); break;
            case 'gte':        $query->where($field, '>=', $value); break;
            case 'lt':         $query->where($field, '<', $value); break;
            case 'lte':        $query->where($field, '<=', $value); break;
            case 'like':       $query->where($field, 'LIKE', "%{$value}%"); break;
            case 'ilike':      $query->where($field, 'ILIKE', "%{$value}%"); break;
            case 'in':         $query->whereIn($field, (array) $value); break;
            case 'nin':        $query->whereNotIn($field, (array) $value); break;
            case 'null':       $query->whereNull($field); break;
            case 'notnull':    $query->whereNotNull($field); break;
            case 'between':
                if (is_array($value) && count($value) === 2) {
                    $query->whereBetween($field, $value);
                }
                break;
            case 'startsWith': $query->where($field, 'LIKE', "{$value}%"); break;
            case 'endsWith':   $query->where($field, 'LIKE', "%{$value}"); break;
        }
    }

    return $query;
}

/**
 * Valida si el campo existe en la tabla (definir por entidad).
 */
private function isValidField(string $field): bool
{
    $allowedFields = ['id', 'name', 'created_at', 'updated_at']; // extender por entidad

    return in_array($field, $allowedFields);
}
```

### 2) Actualizar la Interface

Archivo: `app/Repositories/[Entity]RepositoryInterface.php`

```php
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Filtrado avanzado con múltiples condiciones.
 */
public function filter(array $filters = [], ?array $orderBy = null, ?array $pagination = null): LengthAwarePaginator|Collection;
```

### 3) Crear FormRequest para validación

Archivo: `app/Http/Requests/Filter[Entity]Request.php`

La clave `pagination` es **opcional y nullable**. Si no se envía, el repository devuelve todos los registros sin paginar. Incluye el helper `shouldPaginate()` para uso conveniente desde el controller.

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
            'filters'            => 'sometimes|array',
            'filters.*.field'    => 'required|string|in:id,name,...',   // campos permitidos por entidad
            'filters.*.operator' => 'required|string|in:eq,ne,gt,gte,lt,lte,like,ilike,in,nin,null,notnull,between,startsWith,endsWith',
            'filters.*.value'    => 'required_unless:filters.*.operator,null,notnull',

            'order_by'           => 'sometimes|array',
            'order_by.column'    => 'required_with:order_by|string|in:id,name,...', // columnas permitidas por entidad
            'order_by.direction' => 'required_with:order_by|string|in:asc,desc',

            'pagination'         => 'sometimes|array|nullable',  // nullable = sin paginación → todos
            'pagination.page'    => 'sometimes|integer|min:1',
            'pagination.limit'   => 'sometimes|integer|min:1|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'filters.*.field.in'             => 'El campo :input no está permitido para filtrado',
            'filters.*.operator.in'          => 'El operador :input no es válido',
            'filters.*.value.required_unless' => 'El valor es requerido para este operador',
            'order_by.column.in'             => 'La columna :input no está permitida para ordenamiento',
            'pagination.limit.max'           => 'El límite no puede ser mayor a 100 registros',
        ];
    }

    /**
     * Helper: indica si la request debe paginar resultados.
     */
    public function shouldPaginate(): bool
    {
        if (!$this->has('pagination') || is_null($this->input('pagination'))) {
            return false;
        }

        $limit = $this->input('pagination.limit');

        return !is_null($limit) && $limit > 0;
    }
}
```

### 4) Crear la clase FilterResponse esta clase ya no es necesario crearla

Archivo: `app/Http/Responses/FilterResponse.php`

Centraliza el formato de respuesta para resultados paginados y no paginados.

```php
<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class FilterResponse
{
    public function __construct(
        public readonly array $data,
        public readonly array $meta
    ) {}

    public static function fromPaginator(LengthAwarePaginator $paginator): self
    {
        return new self(
            data: $paginator->items(),
            meta: [
                'total'        => $paginator->total(),
                'per_page'     => $paginator->perPage(),
                'current_page' => $paginator->currentPage(),
                'last_page'    => $paginator->lastPage(),
                'from'         => $paginator->firstItem(),
                'to'           => $paginator->lastItem(),
                'is_paginated' => true,
            ]
        );
    }

    public static function fromCollection(Collection $collection): self
    {
        return new self(
            data: $collection->values()->toArray(),
            meta: [
                'total'        => $collection->count(),
                'is_paginated' => false,
            ]
        );
    }

    public function toResponse(): array
    {
        return [
            'success' => true,
            'data'    => $this->data,
            'meta'    => $this->meta,
        ];
    }
}
```

### 5) Agregar método en el Controller

Archivo: `app/Http/Controllers/[Entity]Controller.php`

```php
use App\Http\Requests\Filter[Entity]Request;
use App\Http\Responses\FilterResponse;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Filtrado avanzado de registros.
 */
public function filter(Filter[Entity]Request $request): JsonResponse
{
    try {
        $filters    = $request->input('filters', []);
        $orderBy    = $request->input('order_by');
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
            'errors'  => $e->errors(),
        ], 422);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error al filtrar registros',
            'error'   => $e->getMessage(),
        ], 500);
    }
}
```

### 6) Registrar ruta

Archivo: `routes/api.php`

Se registran tanto `GET` como `POST` para `/filter`, **antes** de la ruta `/{id}` para evitar que Laravel resuelva `filter` como un ID.

```php
Route::prefix('[entity-plural]')->group(function () {
    Route::get('/search', [[Entity]Controller::class, 'search']);

    // Rutas de filtro avanzado (deben ir antes de /{id})
    Route::get('/filter',  [[Entity]Controller::class, 'filter']);
    Route::post('/filter', [[Entity]Controller::class, 'filter']);

    // CRUD
    Route::get('/',        [[Entity]Controller::class, 'index']);
    Route::get('/{id}',   [[Entity]Controller::class, 'show']);
    Route::post('/',       [[Entity]Controller::class, 'store']);
    Route::put('/{id}',   [[Entity]Controller::class, 'update']);
    Route::delete('/{id}',[Entity]Controller::class, 'destroy']);
});
```

> **Importante:** Laravel evalúa rutas en orden de definición. Si `GET /{id}` se declara antes que `GET /filter`, la ruta `/filter` será capturada por `show` con `id = "filter"`.

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

### Con paginación

```http
POST /api/v1/material-categories/filter
Content-Type: application/json
```

```json
{
  "filters": [
    { "field": "parent_id", "operator": "notnull" },
    { "field": "name", "operator": "ilike", "value": "material" }
  ],
  "order_by": { "column": "name", "direction": "asc" },
  "pagination": { "page": 1, "limit": 20 }
}
```

Respuesta `meta` incluye: `total`, `per_page`, `current_page`, `last_page`, `from`, `to`, `is_paginated: true`.

### Sin paginación (todos los registros)

```http
GET /api/v1/material-categories/filter?filters[0][field]=parent_id&filters[0][operator]=notnull&order_by[column]=name&order_by[direction]=asc
```

O vía POST omitiendo la clave `pagination`:

```json
{
  "filters": [{ "field": "parent_id", "operator": "notnull" }],
  "order_by": { "column": "name", "direction": "asc" }
}
```

Respuesta `meta` incluye solo: `total`, `is_paginated: false`.

## Checklist por entidad

### MaterialCategory ✅
- [x] Repository `filter()` con retorno `LengthAwarePaginator|Collection`
- [x] Helper `isValidField()` (campos: `id`, `name`, `parent_id`, `created_at`, `updated_at`)
- [x] Interface actualizada con tipo de retorno `LengthAwarePaginator|Collection`
- [x] `FilterMaterialCategoryRequest` con `pagination` nullable y `shouldPaginate()`
- [x] Controller usa `FilterResponse::fromPaginator()` / `FilterResponse::fromCollection()`
- [x] Rutas `GET /filter` y `POST /filter` registradas antes de `GET /{id}`

### MaterialType ✅
- [x] Repository `filter()` con retorno `LengthAwarePaginator|Collection`
- [x] Helper `isValidField()` (campos: `id`, `name`, `code`, `is_active`, `created_at`, `updated_at`)
- [x] Interface actualizada con tipo de retorno `LengthAwarePaginator|Collection`
- [x] `FilterMaterialTypeRequest` con `pagination` nullable y `shouldPaginate()`
- [x] Controller usa `FilterResponse::fromPaginator()` / `FilterResponse::fromCollection()`
- [x] Rutas `GET /filter` y `POST /filter` registradas antes de `GET /{id}`

### Template para nuevas entidades
- [ ] Repository `filter()` con retorno `LengthAwarePaginator|Collection`
- [ ] Helper privado `isValidField()` con campos de la tabla
- [ ] Interface actualizada con tipo de retorno `LengthAwarePaginator|Collection`
- [ ] `Filter[Entity]Request` con `pagination` nullable y `shouldPaginate()`
- [ ] Controller usa `FilterResponse` (importar `App\Http\Responses\FilterResponse`)
- [ ] Rutas `GET /filter` y `POST /filter` **antes** de `GET /{id}` en `api.php`
- [ ] Probar sin `pagination` (debe retornar todos)
- [ ] Probar con `pagination` (debe paginar)
- [ ] Verificar que `GET /filter?...` no sea capturado por `show`

## Consideraciones

- No eliminar endpoints legacy (`/all`, `/search`) hasta completar la migración.
- Validar campos permitidos mediante `isValidField()` en `applyFilters()` (seguridad contra inyección de columnas).
- Usar índices en base de datos para campos frecuentemente filtrados.
- Limitar `per_page` máximo (actualmente 100) para evitar sobrecarga.
- La paginación es **opcional**: si no se envía `pagination`, el repository retorna todos los registros como `Collection`.
- Las rutas `GET /filter` y `POST /filter` **deben declararse antes** de `GET /{id}` en `api.php`, de lo contrario Laravel interpreta `filter` como un ID y redirige a `show`.
- La clase `FilterResponse` (`app/Http/Responses/FilterResponse.php`) es compartida por todas las entidades — no duplicar la lógica de respuesta en cada controller.

