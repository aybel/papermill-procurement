<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;

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

        // Rutas para Roles y Permisos (protegidas)
        Route::middleware('permission:roles.manage')->group(function () {
            Route::get('/permissions', [PermissionController::class, 'index']);
            Route::apiResource('roles', RoleController::class);
        });

        // Asignar roles a usuarios
        Route::post('/users/{user}/roles', [RoleController::class, 'assignRoleToUser'])
            ->middleware('permission:users.manage');
    });
});
