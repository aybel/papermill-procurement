<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PaymentTermRequest;

use App\Repositories\PaymentTermRepositoryInterface;

class PaymentTermController extends Controller
{
    protected $paymentTermRepository;

    public function __construct(PaymentTermRepositoryInterface $paymentTermRepository)
    {
        $this->paymentTermRepository = $paymentTermRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $items = $this->paymentTermRepository->search($request->all());
        return response()->json($items);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PaymentTermRequest $request)
    {
        $item = $this->paymentTermRepository->create($request->validated());
        return response()->json($item, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $item = $this->paymentTermRepository->find($id);
        return response()->json($item);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PaymentTermRequest $request, string $id)
    {
        $item = $this->paymentTermRepository->update($id, $request->validated());
        return response()->json($item);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->paymentTermRepository->delete($id);
        return response()->json(null, 204);
    }
}
