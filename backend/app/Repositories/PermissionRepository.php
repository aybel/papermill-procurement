<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Permission;

class PermissionRepository implements PermissionRepositoryInterface
{
    protected $model;

    public function __construct(Permission $model)
    {
        $this->model = $model;
    }

    public function getAll(): Collection
    {
        return $this->model->all();
    }

    public function search(string $search, array $filters = [], array $orderBy = []): Collection
    {
        $query = $this->model->newQuery();

        if ($search !== '') {
            $query->where('name', 'like', "%{$search}%");
        }

        if (isset($filters['resource'])) {
            if (strtoupper($filters['resource']) === 'NOT NULL') {
                $query->whereNotNull('resource');
            } else {
                $query->where('resource', $filters['resource']);
            }
        }

        $allowedColumns = ['name', 'resource', 'action', 'category', 'created_at'];
        $column    = in_array($orderBy['column'] ?? null, $allowedColumns, true)
            ? $orderBy['column']
            : 'name';
        $direction = strtolower($orderBy['direction'] ?? 'asc') === 'desc' ? 'desc' : 'asc';
        $query->orderBy($column, $direction);

        return $query->get();
    }
}
