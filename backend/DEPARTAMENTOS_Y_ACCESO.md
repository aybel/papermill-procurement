# Sistema de Departamentos y Acceso Funcional

## Estructura Implementada

### 1. **Departamento Home (`users.department_id`)**
El departamento donde trabaja físicamente el usuario.

```php
$user->department_id; // ID del departamento home
$user->department;    // Relación BelongsTo
```

### 2. **Departamentos Funcionales (`user_departments` pivot)**
Departamentos a los que tiene acceso para gestionar compras/presupuestos.

**Roles disponibles:**
- `viewer`: Solo lectura
- `manager`: Gestión completa (crear, editar)
- `approver`: Puede aprobar solicitudes

```php
// Asignar acceso funcional
$user->accessibleDepartments()->attach($departmentId, ['role' => 'manager']);

// Verificar acceso
$user->hasAccessToDepartment($departmentId); // Cualquier rol
$user->hasAccessToDepartment($departmentId, 'manager'); // Rol específico

// Obtener todos los IDs accesibles (home + funcionales)
$user->getAllAccessibleDepartmentIds(); // [1, 3, 5, 7]
```

---

## Uso en Controladores

### Opción A: Con Policy (recomendado)
```php
class BudgetRequestController extends Controller
{
    public function show(int $id): JsonResponse
    {
        $item = $this->repository->findById($id);
        
        // Policy verifica automáticamente acceso por departamento
        $this->authorize('view', $item);
        
        return response()->json([
            'success' => true,
            'data' => new BudgetRequestResource($item),
        ]);
    }
}
```

### Opción B: Con filtros en queries
```php
// En BudgetRequestRepository::getAll()
public function getAll(..., ?array $accessibleDepartmentIds = null): Collection
{
    $query = $this->model->newQuery()
        ->with(['status', 'department', 'items'])
        ->orderBy($sortBy, $sortDir);

    // Si no es admin (accessibleDepartmentIds !== null), filtrar
    if ($accessibleDepartmentIds !== null) {
        $query->whereIn('department_id', $accessibleDepartmentIds);
    }

    // Filtros adicionales...
    if ($departmentId) {
        $query->where('department_id', $departmentId);
    }

    return $query->get();
}
```

---

## Casos de Uso Típicos

### 1. Jefe de Compras (gestiona múltiples departamentos)
```php
$user->department_id = 1; // Compras
$user->accessibleDepartments()->attach([
    2 => ['role' => 'manager'],    // Producción
    3 => ['role' => 'manager'],    // Mantenimiento
    4 => ['role' => 'approver'],   // Logística
]);

// Puede ver/editar solicitudes de departamentos 1, 2, 3, 4
// Puede aprobar en departamento 4
```

### 2. Comprador (solo lectura en varios)
```php
$user->department_id = 1; // Compras
$user->accessibleDepartments()->attach([
    2 => ['role' => 'viewer'],
    3 => ['role' => 'viewer'],
]);

// Solo lectura en 2 y 3, gestión en su home (1)
```

### 3. Jefe de Departamento (solo su área)
```php
$user->department_id = 2; // Producción
// Sin accessibleDepartments adicionales

// Solo ve/gestiona solicitudes de Producción
```

### 4. Admin Global
```php
$user->department_id = null;
$user->assignRole('super-admin');

// Ve todo sin restricciones (policy verifica permiso global)
```

---

## Integración con Spatie Permissions

### Permisos Globales (admins)
```php
'budget_requests.view_any'    // Ver todos los departamentos
'budget_requests.update_any'  // Editar en cualquier departamento
'budget_requests.delete_any'  // Eliminar en cualquier departamento
```

### Permisos Scoped (usuarios normales)
```php
'budget_requests.view'    // Ver solo departamentos accesibles
'budget_requests.create'  // Crear en su departamento
'budget_requests.update'  // Editar en departamentos accesibles con rol manager
'budget_requests.approve' // Aprobar en departamentos con rol approver
```

---

## Migración de Datos Existentes

Si ya tienes usuarios creados:

```php
// Asignar departamento home a usuarios existentes
User::where('email', 'LIKE', '%@compras.com')->update(['department_id' => 1]);

// Asignar accesos funcionales
$jefeCompras = User::find(5);
$jefeCompras->accessibleDepartments()->attach([
    2 => ['role' => 'manager'],
    3 => ['role' => 'manager'],
]);
```

---

## Queries de Consulta Útiles

```php
// Usuarios de un departamento (home)
User::where('department_id', 1)->get();

// Usuarios con acceso funcional a un departamento
User::whereHas('accessibleDepartments', function($q) use ($deptId) {
    $q->where('departments.id', $deptId);
})->get();

// Usuarios con rol específico en un departamento
User::whereHas('accessibleDepartments', function($q) use ($deptId) {
    $q->where('departments.id', $deptId)
      ->wherePivot('role', 'approver');
})->get();
```

---

## Validación en Formularios

```php
// En un FormRequest para crear solicitudes
public function rules(): array
{
    $accessibleDeptIds = auth()->user()->getAllAccessibleDepartmentIds();
    
    return [
        'department_id' => [
            'required',
            'integer',
            Rule::in($accessibleDeptIds), // Solo departamentos accesibles
        ],
        // ...
    ];
}
```

---

## Próximos Pasos Recomendados

1. **Ejecutar migraciones:**
   ```bash
   php artisan migrate
   ```

2. **Registrar políticas en `AuthServiceProvider`:**
   ```php
   protected $policies = [
       BudgetRequest::class => BudgetRequestPolicy::class,
   ];
   ```

3. **Registrar trait en modelos que necesiten filtrado:**
   ```php
   use FiltersByDepartmentAccess;
   
   // En queries:
   BudgetRequest::accessibleByUser()->get();
   ```

4. **Seedear data de prueba:**
   ```bash
   php artisan db:seed --class=UserDepartmentSeeder
   ```
