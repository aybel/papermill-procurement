<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Collection;

interface MenuRepositoryInterface
{
    /**
     * Obtiene el menú permitido para el usuario autenticado.
     */
    public function getUserMenu(User $user): Collection;
}
