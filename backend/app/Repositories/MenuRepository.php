<?php

namespace App\Repositories;

use App\Models\MenuItem;
use App\Models\User;
use App\Repositories\MenuRepositoryInterface;
use Illuminate\Support\Collection;

class MenuRepository implements MenuRepositoryInterface
{
    public function __construct(
        protected MenuItem $model
    ) {}

    public function getUserMenu(User $user): Collection
    {
        return $this->model->with([
                'permission',
                'children' => function ($query) use ($user) {
                    $query->with('permission')->forUser($user)->active();
                },
            ])
            ->root()
            ->forUser($user)
            ->active()
            ->orderBy('order')
            ->get()
            ->map(fn (MenuItem $item) => $this->buildMenuItem($item, $user))
            ->filter()
            ->values();
    }

    private function buildMenuItem(MenuItem $item, User $user): ?array
    {
        if ($item->permission_id && !$user->can($item->permission->name)) {
            return null;
        }

        $menuItem = [
            'id' => $item->id,
            'semantic_key' => $item->semantic_key,
            'type' => $item->semantic_type,
            'name' => $item->display_name,
            'icon' => $item->semantic_icon,
            'permission' => $item->permission?->name,
        ];

        if ($item->route_name && $item->route_name !== '#') {
            try {
                $menuItem['route'] = route($item->route_name, [], false);
            } catch (\Exception $e) {
                $menuItem['route'] = $item->route_name;
            }
        } else {
            $menuItem['route'] = $item->route_name;
        }

        if ($item->children->isNotEmpty()) {
            $children = $item->children
                ->map(fn (MenuItem $child) => $this->buildMenuItem($child, $user))
                ->filter()
                ->values();

            if ($children->isNotEmpty()) {
                $menuItem['children'] = $children;
            }
        }

        return $menuItem;
    }
}
