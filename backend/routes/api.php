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

        // Rutas de proveedores (ahora públicas temporalmente)
        Route::prefix('suppliers')->group(function () {
            Route::get('/active', [SupplierController::class, 'active']);
            Route::get('/search', [SupplierController::class, 'search']);
            Route::get('/', [SupplierController::class, 'index']);
            Route::get('/{id}', [SupplierController::class, 'show']);
            Route::post('/', [SupplierController::class, 'store']);
            Route::put('/{id}', [SupplierController::class, 'update']);
            Route::delete('/{id}', [SupplierController::class, 'destroy']);
            Route::post('/{id}/restore', [SupplierController::class, 'restore']);
            Route::patch('/{id}/scores', [SupplierController::class, 'updateScores']);
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
