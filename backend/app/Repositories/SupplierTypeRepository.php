<?php

namespace App\Repositories;

use App\Models\SupplierType;

class SupplierTypeRepository implements SupplierTypeRepositoryInterface
{
    public function all()
    {
        return SupplierType::all();
    }

    public function find($id)
    {
        return SupplierType::findOrFail($id);
    }

    public function create(array $data)
    {
        return SupplierType::create($data);
    }

    public function update($id, array $data)
    {
        $type = SupplierType::findOrFail($id);
        $type->update($data);
        return $type;
    }

    public function delete($id)
    {
        $type = SupplierType::findOrFail($id);
        $type->delete();
        return true;
    }

    public function search(array $params)
    {
        $query = SupplierType::query();
        if (!empty($params['name'])) {
            $query->where('name', 'like', '%' . $params['name'] . '%');
        }
        if (!empty($params['sort_by'])) {
            $query->orderBy($params['sort_by'], $params['sort_dir'] ?? 'asc');
        }
        return $query->paginate(!empty($params['per_page']) ? $params['per_page'] : 15);
    }
}
