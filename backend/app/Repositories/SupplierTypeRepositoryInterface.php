<?php

namespace App\Repositories;

use App\Models\SupplierType;

interface SupplierTypeRepositoryInterface
{
    public function all();
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function search(array $params);
}
