<?php

namespace App\Http\Controllers;

use App\Http\Resources\PermissionCollection;
use App\Repositories\PermissionRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PermissionController extends Controller
{
    public function __construct(
        protected PermissionRepositoryInterface $permissionRepository
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new PermissionCollection($this->permissionRepository->getAll());
    }

    /**
     * Search permissions by name.
     */
    public function search(Request $request): JsonResponse
    {
        try {
            $search = $request->input('q', '');

            $orderBy = $request->input('order_by', []);
            if (is_string($orderBy)) {
                $orderBy = json_decode($orderBy, true) ?? [];
            }

            $permissions = $this->permissionRepository->search($search, [], $orderBy);

            return response()->json([
                'success' => true,
                'data' => $permissions,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al buscar permisos',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
