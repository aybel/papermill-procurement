<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PaymentTermController;
use App\Http\Controllers\SupplierTypeController;
use App\Http\Controllers\SupplierStatusController;
use App\Http\Controllers\SupplierContactController;

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

        // Rutas de proveedores protegidas por permisos
        Route::prefix('suppliers')->group(function () {
            Route::get('/active', [SupplierController::class, 'active'])
                ->middleware('permission:suppliers.view_any');
            Route::get('/search', [SupplierController::class, 'search'])
                ->middleware('permission:suppliers.view_any');
            Route::get('/', [SupplierController::class, 'index'])
                ->middleware('permission:suppliers.view_any');
            Route::get('/{id}', [SupplierController::class, 'show'])
                ->middleware('permission:suppliers.view');
            Route::post('/', [SupplierController::class, 'store'])
                ->middleware('permission:suppliers.create');
            Route::put('/{id}', [SupplierController::class, 'update'])
                ->middleware('permission:suppliers.update');
            Route::delete('/{id}', [SupplierController::class, 'destroy'])
                ->middleware('permission:suppliers.delete');
            Route::post('/{id}/restore', [SupplierController::class, 'restore'])
                ->middleware('permission:suppliers.restore');
            Route::patch('/{id}/scores', [SupplierController::class, 'updateScores'])
                ->middleware('permission:suppliers.update_scores');
        });

        // CRUD para currencies
        Route::prefix('currencies')->group(function () {
            Route::get('/', [CurrencyController::class, 'index'])
                ->middleware('permission:currencies.view_any');
            Route::get('/{id}', [CurrencyController::class, 'show'])
                ->middleware('permission:currencies.view');
            Route::post('/', [CurrencyController::class, 'store'])
                ->middleware('permission:currencies.create');
            Route::put('/{id}', [CurrencyController::class, 'update'])
                ->middleware('permission:currencies.update');
            Route::delete('/{id}', [CurrencyController::class, 'destroy'])
                ->middleware('permission:currencies.delete');
        });

        // CRUD para payment_terms
        Route::prefix('payment_terms')->group(function () {
            Route::get('/', [PaymentTermController::class, 'index'])
                ->middleware('permission:payment_terms.view_any');
            Route::get('/{id}', [PaymentTermController::class, 'show'])
                ->middleware('permission:payment_terms.view');
            Route::post('/', [PaymentTermController::class, 'store'])
                ->middleware('permission:payment_terms.create');
            Route::put('/{id}', [PaymentTermController::class, 'update'])
                ->middleware('permission:payment_terms.update');
            Route::delete('/{id}', [PaymentTermController::class, 'destroy'])
                ->middleware('permission:payment_terms.delete');
        });

        // CRUD para supplier_contacts
        Route::prefix('supplier_contacts')->group(function () {
            Route::get('/', [SupplierContactController::class, 'index'])
                ->middleware('permission:supplier_contacts.view_any');
            Route::get('/{id}', [SupplierContactController::class, 'show'])
                ->middleware('permission:supplier_contacts.view');
            Route::post('/', [SupplierContactController::class, 'store'])
                ->middleware('permission:supplier_contacts.create');
            Route::put('/{id}', [SupplierContactController::class, 'update'])
                ->middleware('permission:supplier_contacts.update');
            Route::delete('/{id}', [SupplierContactController::class, 'destroy'])
                ->middleware('permission:supplier_contacts.delete');
            Route::get('/search', [SupplierContactController::class, 'search']);
        });

        // CRUD para supplier_statuses
        Route::prefix('supplier_statuses')->group(function () {
            Route::get('/', [SupplierStatusController::class, 'index'])
                ->middleware('permission:supplier_statuses.view_any');
            Route::get('/{id}', [SupplierStatusController::class, 'show'])
                ->middleware('permission:supplier_statuses.view');
            Route::post('/', [SupplierStatusController::class, 'store'])
                ->middleware('permission:supplier_statuses.create');
            Route::put('/{id}', [SupplierStatusController::class, 'update'])
                ->middleware('permission:supplier_statuses.update');
            Route::delete('/{id}', [SupplierStatusController::class, 'destroy'])
                ->middleware('permission:supplier_statuses.delete');
        });

        // CRUD para supplier_types
        Route::prefix('supplier_types')->group(function () {
            Route::get('/', [SupplierTypeController::class, 'index'])
                ->middleware('permission:supplier_types.view_any');
            Route::get('/{id}', [SupplierTypeController::class, 'show'])
                ->middleware('permission:supplier_types.view');
            Route::post('/', [SupplierTypeController::class, 'store'])
                ->middleware('permission:supplier_types.create');
            Route::put('/{id}', [SupplierTypeController::class, 'update'])
                ->middleware('permission:supplier_types.update');
            Route::delete('/{id}', [SupplierTypeController::class, 'destroy'])
                ->middleware('permission:supplier_types.delete');
        });
        // Rutas para Roles y Permisos (protegidas)
        Route::middleware('permission:roles.manage')->group(function () {
            Route::get('/permissions', [PermissionController::class, 'index']);
            Route::apiResource('roles', RoleController::class);
        });

        // Endpoint único para exportar reportes
        Route::post('/reports/export', [ReportController::class, 'export'])
            ->middleware('permission:reports.export');

        // Asignar roles a usuarios
        Route::post('/users/{user}/roles', [RoleController::class, 'assignRoleToUser'])
            ->middleware('permission:users.manage');
    });
});
