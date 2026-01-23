<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SupplierContactRequest;
use Illuminate\Http\JsonResponse;
use App\Repositories\SupplierContactRepositoryInterface;
use Illuminate\Support\Facades\Log;

class SupplierContactController extends Controller
{
    protected $supplierContactRepository;

    public function __construct(SupplierContactRepositoryInterface $supplierContactRepository)
    {
        $this->supplierContactRepository = $supplierContactRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $items = $this->supplierContactRepository->search($request->all());
        return response()->json($items);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SupplierContactRequest $request): JsonResponse
    {
        $item = $this->supplierContactRepository->create($request->validated());
        return response()->json($item, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $item = $this->supplierContactRepository->find($id);
        return response()->json($item);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SupplierContactRequest $request, string $id): JsonResponse
    {
        $item = $this->supplierContactRepository->update($id, $request->validated());
        return response()->json($item);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $this->supplierContactRepository->delete($id);
        return response()->json(null, 204);
    }

    /**
     * Buscar contactos de proveedores por id de proveedor
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function search(Request $request): JsonResponse
    {
        try {
            Log::info('Supplier contacts search');
            $supplierContacts = $this->supplierContactRepository->search($request->all());
            return response()->json([
                'success' => true,
                'data' => $supplierContacts,
            ]);
        } catch (\Exception $e) {
            Log::info('Supplier contacts search caught exception: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'No se encontraron contactos para el proveedor solicitado o hubo un error.',
                'error' => $e->getMessage(),
                'data' => [],
            ], 200);
        }
    }
}
