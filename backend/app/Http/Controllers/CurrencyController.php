<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CurrencyRequest;

use App\Repositories\CurrencyRepositoryInterface;

class CurrencyController extends Controller
{
    protected $currencyRepository;

    public function __construct(CurrencyRepositoryInterface $currencyRepository)
    {
        $this->currencyRepository = $currencyRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $currencies = $this->currencyRepository->search($request->all());
        return response()->json($currencies);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CurrencyRequest $request)
    {
        $currency = $this->currencyRepository->create($request->validated());
        return response()->json($currency, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $currency = $this->currencyRepository->find($id);
        return response()->json($currency);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CurrencyRequest $request, string $id)
    {
        $currency = $this->currencyRepository->update($id, $request->validated());
        return response()->json($currency);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->currencyRepository->delete($id);
        return response()->json(null, 204);
    }
}
