<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SupplierTypeRequest;

use App\Repositories\SupplierTypeRepositoryInterface;

class SupplierTypeController extends Controller
{
    protected $supplierTypeRepository;

    public function __construct(SupplierTypeRepositoryInterface $supplierTypeRepository)
    {
        $this->supplierTypeRepository = $supplierTypeRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $items = $this->supplierTypeRepository->search($request->all());
        return response()->json($items);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SupplierTypeRequest $request)
    {
        $item = $this->supplierTypeRepository->create($request->validated());
        return response()->json($item, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $item = $this->supplierTypeRepository->find($id);
        return response()->json($item);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SupplierTypeRequest $request, string $id)
    {
        $item = $this->supplierTypeRepository->update($id, $request->validated());
        return response()->json($item);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->supplierTypeRepository->delete($id);
        return response()->json(null, 204);
    }
}
