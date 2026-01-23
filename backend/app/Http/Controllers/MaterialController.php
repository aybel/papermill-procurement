<?php

namespace App\Http\Controllers;

use App\Repositories\MaterialRepositoryInterface;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    protected $materials;

    public function __construct(MaterialRepositoryInterface $materials)
    {
        $this->materials = $materials;
    }

    public function index()
    {
        return response()->json($this->materials->all());
    }

    public function show($id)
    {
        return response()->json($this->materials->find($id));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'sku' => 'required|string|max:50|unique:materials,sku',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:material_categories,id',
            'material_type' => 'nullable|string|max:50',
            'unit_of_measure' => 'required|string|max:20',
            'current_stock' => 'numeric',
            'min_stock' => 'numeric',
            'max_stock' => 'numeric',
            'safety_stock' => 'numeric',
            'avg_unit_cost' => 'numeric',
            'last_purchase_price' => 'nullable|numeric',
            'currency_id' => 'required|exists:currencies,id',
            'grammage' => 'nullable|numeric',
            'width' => 'nullable|numeric',
            'length' => 'nullable|numeric',
            'color' => 'nullable|string|max:50',
        ]);
        $material = $this->materials->create($data);
        return response()->json($material, 201);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'sku' => 'sometimes|required|string|max:50|unique:materials,sku,' . $id,
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:material_categories,id',
            'material_type' => 'nullable|string|max:50',
            'unit_of_measure' => 'sometimes|required|string|max:20',
            'current_stock' => 'numeric',
            'min_stock' => 'numeric',
            'max_stock' => 'numeric',
            'safety_stock' => 'numeric',
            'avg_unit_cost' => 'numeric',
            'last_purchase_price' => 'nullable|numeric',
            'currency_id' => 'sometimes|required|exists:currencies,id',
            'grammage' => 'nullable|numeric',
            'width' => 'nullable|numeric',
            'length' => 'nullable|numeric',
            'color' => 'nullable|string|max:50',
        ]);
        $material = $this->materials->update($id, $data);
        return response()->json($material);
    }

    public function destroy($id)
    {
        $this->materials->delete($id);
        return response()->json(null, 204);
    }
}
