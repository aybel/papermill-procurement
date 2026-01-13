<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SupplierContactRequest;

use App\Repositories\SupplierContactRepositoryInterface;

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
    public function index(Request $request)
    {
        $items = $this->supplierContactRepository->search($request->all());
        return response()->json($items);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SupplierContactRequest $request)
    {
        $item = $this->supplierContactRepository->create($request->validated());
        return response()->json($item, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $item = $this->supplierContactRepository->find($id);
        return response()->json($item);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SupplierContactRequest $request, string $id)
    {
        $item = $this->supplierContactRepository->update($id, $request->validated());
        return response()->json($item);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->supplierContactRepository->delete($id);
        return response()->json(null, 204);
    }
}
