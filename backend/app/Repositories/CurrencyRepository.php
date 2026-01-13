<?php

namespace App\Repositories;

use App\Models\Currency;

class CurrencyRepository implements CurrencyRepositoryInterface
{
    public function all()
    {
        return Currency::all();
    }

    public function find($id)
    {
        return Currency::findOrFail($id);
    }

    public function create(array $data)
    {
        return Currency::create($data);
    }

    public function update($id, array $data)
    {
        $currency = Currency::findOrFail($id);
        $currency->update($data);
        return $currency;
    }

    public function delete($id)
    {
        $currency = Currency::findOrFail($id);
        $currency->delete();
        return true;
    }

    public function search(array $params)
    {
        $query = Currency::query(); // Eloquent Builder

        // Filtros usando Eloquent
        if (!empty($params['name'])) {
            $query->where('name', 'like', '%' . $params['name'] . '%');
        }
        if (!empty($params['code'])) {
            $query->where('code', $params['code']);
        }

        if (!empty($params['active'])) {
            $query->active();
        }

        if (!empty($params['sort_by'])) {
            $query->orderBy($params['sort_by'], $params['sort_dir'] ?? 'asc');
        }

        return $query->paginate(!empty($params['per_page']) ? $params['per_page'] : 15);
    }
}
