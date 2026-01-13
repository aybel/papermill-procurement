<?php

namespace App\Repositories;

use App\Models\PaymentTerm;

class PaymentTermRepository implements PaymentTermRepositoryInterface
{
    public function all()
    {
        return PaymentTerm::all();
    }

    public function find($id)
    {
        return PaymentTerm::findOrFail($id);
    }

    public function create(array $data)
    {
        return PaymentTerm::create($data);
    }

    public function update($id, array $data)
    {
        $paymentTerm = PaymentTerm::findOrFail($id);
        $paymentTerm->update($data);
        return $paymentTerm;
    }

    public function delete($id)
    {
        $paymentTerm = PaymentTerm::findOrFail($id);
        $paymentTerm->delete();
        return true;
    }

    public function search(array $params)
    {
        $query = PaymentTerm::query();
        if (!empty($params['name'])) {
            $query->where('name', 'like', '%' . $params['name'] . '%');
        }
        if (!empty($params['code'])) {
            $query->where('code', $params['code']);
        }
        if (!empty($params['sort_by'])) {
            $query->orderBy($params['sort_by'], $params['sort_dir'] ?? 'asc');
        }
        return $query->paginate(!empty($params['per_page']) ? $params['per_page'] : 15);
    }
}
