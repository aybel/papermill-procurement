<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetUserMenuRequest;
use App\Http\Resources\MenuCollection;
use App\Repositories\MenuRepositoryInterface;
use Illuminate\Http\JsonResponse;

class MenuController extends Controller
{
    public function __construct(
        protected MenuRepositoryInterface $menuRepository
    ) {}

    public function getUserMenu(GetUserMenuRequest $request): MenuCollection|JsonResponse
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'message' => 'Usuario no autenticado.',
            ], 401);
        }

        return new MenuCollection($this->menuRepository->getUserMenu($user));
    }
}
