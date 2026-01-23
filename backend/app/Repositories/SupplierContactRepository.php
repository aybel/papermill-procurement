<?php

namespace App\Repositories;

use App\Models\SupplierContact;
use Illuminate\Support\Facades\Log;

class SupplierContactRepository implements SupplierContactRepositoryInterface
{
    public function all()
    {
        return SupplierContact::all();
    }

    public function find($id)
    {
        return SupplierContact::findOrFail($id);
    }

    public function create(array $data)
    {
        return SupplierContact::create($data);
    }

    public function update($id, array $data)
    {
        $contact = SupplierContact::findOrFail($id);
        $contact->update($data);
        return $contact;
    }

    public function delete($id)
    {
        $contact = SupplierContact::findOrFail($id);
        $contact->delete();
        return true;
    }

    public function search(array $params)
    {
        $query = SupplierContact::query();
        Log::info('Search params: ' . json_encode($params));
        if (!empty($params['supplier_id'])) {
            $query->where('supplier_id', $params['supplier_id']);
        }
        if (!empty($params['name'])) {
            $query->where('name', 'like', '%' . $params['name'] . '%');
        }
        if (!empty($params['email'])) {
            $query->where('email', $params['email']);
        }
        if (!empty($params['sort_by'])) {
            $query->orderBy($params['sort_by'], $params['sort_dir'] ?? 'asc');
        }
        return $query->paginate(!empty($params['per_page']) ? $params['per_page'] : 15);
    }
}
