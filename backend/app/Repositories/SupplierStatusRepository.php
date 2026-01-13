<?php

namespace App\Repositories;

use App\Models\SupplierStatus;

class SupplierStatusRepository implements SupplierStatusRepositoryInterface
{
    public function all()
    {
        return SupplierStatus::all();
    }

    public function find($id)
    {
        return SupplierStatus::findOrFail($id);
    }

    public function create(array $data)
    {
        return SupplierStatus::create($data);
    }

    public function update($id, array $data)
    {
        $status = SupplierStatus::findOrFail($id);
        $status->update($data);
        return $status;
    }

    public function delete($id)
    {
        $status = SupplierStatus::findOrFail($id);
        $status->delete();
        return true;
    }

    public function search(array $params)
    {
        $query = SupplierStatus::query();
        if (!empty($params['name'])) {
            $query->where('name', 'like', '%' . $params['name'] . '%');
        }
        if (!empty($params['sort_by'])) {
            $query->orderBy($params['sort_by'], $params['sort_dir'] ?? 'asc');
        }
        if (!empty($params['active'])) {
            $query->active();
        }
        return $query->paginate(!empty($params['per_page']) ? $params['per_page'] : 15);
    }
}
