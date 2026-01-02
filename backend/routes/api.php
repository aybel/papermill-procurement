<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\AuthController;

Route::post('auth/register', [AuthController::class, 'register']);
Route::post('auth/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::post('auth/logout', [AuthController::class, 'logout']);
    Route::post('auth/refresh', [AuthController::class, 'refresh']);
    Route::get('auth/me', [AuthController::class, 'me']);

    Route::get('/user', function (Request $request) {
        return $request->user();
    })->middleware('auth:sanctum');

    // Rutas de proveedores
    Route::prefix('suppliers')->group(function () {
        // Listar proveedores activos para selects
        Route::get('/active', [SupplierController::class, 'active']);

        // Buscar proveedores
        Route::get('/search', [SupplierController::class, 'search']);

        // CRUD de proveedores
        Route::get('/', [SupplierController::class, 'index']);
        Route::get('/{id}', [SupplierController::class, 'show']);
        Route::post('/', [SupplierController::class, 'store']);
        Route::put('/{id}', [SupplierController::class, 'update']);
        Route::delete('/{id}', [SupplierController::class, 'destroy']);

        // Restaurar proveedor eliminado
        Route::post('/{id}/restore', [SupplierController::class, 'restore']);

        // Actualizar scores de desempeño
        Route::patch('/{id}/scores', [SupplierController::class, 'updateScores']);
    });
});
