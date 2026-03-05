<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SupplierTypeController;
use App\Http\Controllers\SupplierStatusController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\PaymentTermController;
use App\Http\Controllers\SupplierContactController;
use App\Http\Controllers\MaterialTypeController;
use App\Http\Controllers\MaterialCategoryController;
use App\Http\Controllers\UnitOfMeasureController;
use App\Http\Controllers\BudgetCategoryController;
use App\Http\Controllers\BudgetAssignmentController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\BudgetRequestStatusController;
use App\Http\Controllers\BudgetRequestController;
use App\Http\Controllers\BudgetRequestItemController;

Route::prefix('v1')->group(function () {
    Route::post('auth/register', [AuthController::class, 'register']);
    Route::post('auth/login', [AuthController::class, 'login'])->name('login');

    Route::middleware('auth:api')->group(function () {
        Route::post('auth/logout', [AuthController::class, 'logout']);
        Route::post('auth/refresh', [AuthController::class, 'refresh']);
        Route::get('auth/me', [AuthController::class, 'me']);

        Route::get('/user', function (Request $request) {
            return $request->user();
        });

        // Rutas de proveedores (protegidas)
        Route::prefix('suppliers')->group(function () {
            Route::get('/active', [SupplierController::class, 'active'])->middleware('permission:suppliers.view_any');
            Route::get('/search', [SupplierController::class, 'search'])->middleware('permission:suppliers.view_any');
            Route::get('/', [SupplierController::class, 'index'])->middleware('permission:suppliers.view_any');
            Route::get('/{id}', [SupplierController::class, 'show'])->middleware('permission:suppliers.view');
            Route::post('/', [SupplierController::class, 'store'])->middleware('permission:suppliers.create');
            Route::put('/{id}', [SupplierController::class, 'update'])->middleware('permission:suppliers.update');
            Route::delete('/{id}', [SupplierController::class, 'destroy'])->middleware('permission:suppliers.delete');
            Route::post('/{id}/restore', [SupplierController::class, 'restore'])->middleware('permission:suppliers.restore');
            Route::patch('/{id}/scores', [SupplierController::class, 'updateScores'])->middleware('permission:suppliers.update_scores');
        });

        // Rutas de materiales (protegidas)
        Route::prefix('materials')->group(function () {
            Route::get('/search', [MaterialController::class, 'search'])->middleware('permission:materials.view_any');
            Route::get('/', [MaterialController::class, 'index'])->middleware('permission:materials.view_any');
            Route::get('/{id}', [MaterialController::class, 'show'])->middleware('permission:materials.view');
            Route::post('/', [MaterialController::class, 'store'])->middleware('permission:materials.create');
            Route::put('/{id}', [MaterialController::class, 'update'])->middleware('permission:materials.update');
            Route::delete('/{id}', [MaterialController::class, 'destroy'])->middleware('permission:materials.delete');
        });

        // Tipos de proveedores
        Route::prefix('supplier-types')->group(function () {
            Route::get('/', [SupplierTypeController::class, 'index'])->middleware('permission:supplier_types.view_any');
            Route::get('/{id}', [SupplierTypeController::class, 'show'])->middleware('permission:supplier_types.view');
            Route::post('/', [SupplierTypeController::class, 'store'])->middleware('permission:supplier_types.create');
            Route::put('/{id}', [SupplierTypeController::class, 'update'])->middleware('permission:supplier_types.update');
            Route::delete('/{id}', [SupplierTypeController::class, 'destroy'])->middleware('permission:supplier_types.delete');
        });

        // Estados de proveedor
        Route::prefix('supplier-statuses')->group(function () {
            Route::get('/', [SupplierStatusController::class, 'index'])->middleware('permission:supplier_statuses.view_any');
            Route::get('/{id}', [SupplierStatusController::class, 'show'])->middleware('permission:supplier_statuses.view');
            Route::post('/', [SupplierStatusController::class, 'store'])->middleware('permission:supplier_statuses.create');
            Route::put('/{id}', [SupplierStatusController::class, 'update'])->middleware('permission:supplier_statuses.update');
            Route::delete('/{id}', [SupplierStatusController::class, 'destroy'])->middleware('permission:supplier_statuses.delete');
        });

        // Departamentos
        Route::prefix('departments')->group(function () {
            Route::get('/search', [DepartmentController::class, 'search'])->middleware('permission:departments.view_any');
            Route::get('/', [DepartmentController::class, 'index'])->middleware('permission:departments.view_any');
            Route::get('/{id}', [DepartmentController::class, 'show'])->middleware('permission:departments.view');
            Route::post('/', [DepartmentController::class, 'store'])->middleware('permission:departments.create');
            Route::put('/{id}', [DepartmentController::class, 'update'])->middleware('permission:departments.update');
            Route::delete('/{id}', [DepartmentController::class, 'destroy'])->middleware('permission:departments.delete');
        });

        // Monedas
        Route::prefix('currencies')->group(function () {
            Route::get('/', [CurrencyController::class, 'index'])->middleware('permission:currencies.view_any');
            Route::get('/{id}', [CurrencyController::class, 'show'])->middleware('permission:currencies.view');
            Route::post('/', [CurrencyController::class, 'store'])->middleware('permission:currencies.create');
            Route::put('/{id}', [CurrencyController::class, 'update'])->middleware('permission:currencies.update');
            Route::delete('/{id}', [CurrencyController::class, 'destroy'])->middleware('permission:currencies.delete');
        });

        // Términos de pago
        Route::prefix('payment-terms')->group(function () {
            Route::get('/', [PaymentTermController::class, 'index'])->middleware('permission:payment_terms.view_any');
            Route::get('/{id}', [PaymentTermController::class, 'show'])->middleware('permission:payment_terms.view');
            Route::post('/', [PaymentTermController::class, 'store'])->middleware('permission:payment_terms.create');
            Route::put('/{id}', [PaymentTermController::class, 'update'])->middleware('permission:payment_terms.update');
            Route::delete('/{id}', [PaymentTermController::class, 'destroy'])->middleware('permission:payment_terms.delete');
        });

        // Contactos de proveedor
        Route::prefix('supplier-contacts')->group(function () {
            Route::get('/', [SupplierContactController::class, 'index'])->middleware('permission:supplier_contacts.view_any');
            Route::get('/search', [SupplierContactController::class, 'search'])->middleware('permission:supplier_contacts.view_any');
            Route::get('/{id}', [SupplierContactController::class, 'show'])->middleware('permission:supplier_contacts.view');
            Route::post('/', [SupplierContactController::class, 'store'])->middleware('permission:supplier_contacts.create');
            Route::put('/{id}', [SupplierContactController::class, 'update'])->middleware('permission:supplier_contacts.update');
            Route::delete('/{id}', [SupplierContactController::class, 'destroy'])->middleware('permission:supplier_contacts.delete');
        });

        // Tipos de materiales
        Route::prefix('material-types')->group(function () {
            Route::get('/search', [MaterialTypeController::class, 'search'])->middleware('permission:material_types.view_any');
            Route::get('/', [MaterialTypeController::class, 'index'])->middleware('permission:material_types.view_any');
            Route::get('/{id}', [MaterialTypeController::class, 'show'])->middleware('permission:material_types.view');
            Route::post('/', [MaterialTypeController::class, 'store'])->middleware('permission:material_types.create');
            Route::put('/{id}', [MaterialTypeController::class, 'update'])->middleware('permission:material_types.update');
            Route::delete('/{id}', [MaterialTypeController::class, 'destroy'])->middleware('permission:material_types.delete');
        });

        // Categorías de materiales
        Route::prefix('material-categories')->group(function () {
            Route::get('/search', [MaterialCategoryController::class, 'search'])->middleware('permission:material_categories.view_any');
            Route::get('/', [MaterialCategoryController::class, 'index'])->middleware('permission:material_categories.view_any');
            Route::get('/{id}', [MaterialCategoryController::class, 'show'])->middleware('permission:material_categories.view');
            Route::post('/', [MaterialCategoryController::class, 'store'])->middleware('permission:material_categories.create');
            Route::put('/{id}', [MaterialCategoryController::class, 'update'])->middleware('permission:material_categories.update');
            Route::delete('/{id}', [MaterialCategoryController::class, 'destroy'])->middleware('permission:material_categories.delete');
        });

        // Categorías presupuestarias
        Route::prefix('budget-categories')->group(function () {
            Route::get('/search', [BudgetCategoryController::class, 'search'])->middleware('permission:budget_categories.view_any');
            Route::get('/', [BudgetCategoryController::class, 'index'])->middleware('permission:budget_categories.view_any');
            Route::get('/{id}', [BudgetCategoryController::class, 'show'])->middleware('permission:budget_categories.view');
            Route::post('/', [BudgetCategoryController::class, 'store'])->middleware('permission:budget_categories.create');
            Route::put('/{id}', [BudgetCategoryController::class, 'update'])->middleware('permission:budget_categories.update');
            Route::delete('/{id}', [BudgetCategoryController::class, 'destroy'])->middleware('permission:budget_categories.delete');
        });

        // Asignaciones de presupuesto
        Route::prefix('budget-assignments')->group(function () {
            Route::get('/search', [BudgetAssignmentController::class, 'search'])->middleware('permission:budget_assignments.view_any');
            Route::get('/', [BudgetAssignmentController::class, 'index'])->middleware('permission:budget_assignments.view_any');
            Route::get('/{id}', [BudgetAssignmentController::class, 'show'])->middleware('permission:budget_assignments.view');
            Route::post('/', [BudgetAssignmentController::class, 'store'])->middleware('permission:budget_assignments.create');
            Route::put('/{id}', [BudgetAssignmentController::class, 'update'])->middleware('permission:budget_assignments.update');
            Route::delete('/{id}', [BudgetAssignmentController::class, 'destroy'])->middleware('permission:budget_assignments.delete');
        });

        // Estados de solicitudes de presupuesto
        Route::prefix('budget-request-statuses')->group(function () {
            Route::get('/search', [BudgetRequestStatusController::class, 'search'])->middleware('permission:budget_request_statuses.view_any');
            Route::get('/', [BudgetRequestStatusController::class, 'index'])->middleware('permission:budget_request_statuses.view_any');
            Route::get('/{id}', [BudgetRequestStatusController::class, 'show'])->middleware('permission:budget_request_statuses.view');
            Route::post('/', [BudgetRequestStatusController::class, 'store'])->middleware('permission:budget_request_statuses.create');
            Route::put('/{id}', [BudgetRequestStatusController::class, 'update'])->middleware('permission:budget_request_statuses.update');
            Route::delete('/{id}', [BudgetRequestStatusController::class, 'destroy'])->middleware('permission:budget_request_statuses.delete');
        });

        // Solicitudes de presupuesto
        Route::prefix('budget-requests')->group(function () {
            Route::get('/search', [BudgetRequestController::class, 'search'])->middleware('permission:budget_requests.view_any');
            Route::get('/', [BudgetRequestController::class, 'index'])->middleware('permission:budget_requests.view_any');
            Route::get('/{id}', [BudgetRequestController::class, 'show'])->middleware('permission:budget_requests.view');
            Route::post('/', [BudgetRequestController::class, 'store'])->middleware('permission:budget_requests.create');
            Route::put('/{id}', [BudgetRequestController::class, 'update'])->middleware('permission:budget_requests.update');
            Route::delete('/{id}', [BudgetRequestController::class, 'destroy'])->middleware('permission:budget_requests.delete');

        });

        // Ítems de solicitudes de presupuesto
        Route::prefix('budget-request-items')->group(function () {
            Route::get('/search', [BudgetRequestItemController::class, 'search'])->middleware('permission:budget_request_items.view_any');
            Route::get('/', [BudgetRequestItemController::class, 'index'])->middleware('permission:budget_request_items.view_any');
            Route::get('/{id}', [BudgetRequestItemController::class, 'show'])->middleware('permission:budget_request_items.view');
            Route::post('/', [BudgetRequestItemController::class, 'store'])->middleware('permission:budget_request_items.create');
            Route::put('/{id}', [BudgetRequestItemController::class, 'update'])->middleware('permission:budget_request_items.update');
            Route::delete('/{id}', [BudgetRequestItemController::class, 'destroy'])->middleware('permission:budget_request_items.delete');
        });

        // Unidades de medida
        Route::prefix('units-of-measure')->group(function () {
            Route::get('/search', [UnitOfMeasureController::class, 'search'])->middleware('permission:units_of_measure.view_any');
            Route::get('/', [UnitOfMeasureController::class, 'index'])->middleware('permission:units_of_measure.view_any');
            Route::get('/{id}', [UnitOfMeasureController::class, 'show'])->middleware('permission:units_of_measure.view');
            Route::post('/', [UnitOfMeasureController::class, 'store'])->middleware('permission:units_of_measure.create');
            Route::put('/{id}', [UnitOfMeasureController::class, 'update'])->middleware('permission:units_of_measure.update');
            Route::delete('/{id}', [UnitOfMeasureController::class, 'destroy'])->middleware('permission:units_of_measure.delete');
        });

        // Rutas para Roles y Permisos (protegidas)
        Route::middleware('permission:roles.manage')->group(function () {
            Route::get('/permissions', [PermissionController::class, 'index']);
            Route::apiResource('roles', RoleController::class);

            // Asignar/revocar permisos a roles
            Route::post('/roles/{role}/permissions', [RoleController::class, 'assignPermissions']);
            Route::delete('/roles/{role}/permissions', [RoleController::class, 'revokePermission']);
        });

        // Rutas para gestión de usuarios
        Route::middleware('permission:users.manage')->prefix('users')->group(function () {
            Route::get('/', [UserController::class, 'index']);
            Route::get('/{id}', [UserController::class, 'show']);
            Route::put('/{id}', [UserController::class, 'update']);

            // Asignar roles a usuarios
            Route::post('/{id}/roles', [UserController::class, 'assignRoles']);
            Route::get('/{id}/roles', [UserController::class, 'getRoles']);

            // Asignar departamentos accesibles
            Route::post('/{id}/departments', [UserController::class, 'assignDepartments']);
            Route::get('/{id}/departments', [UserController::class, 'getAccessibleDepartments']);
        });
    });
});
