<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SupplierController;

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
