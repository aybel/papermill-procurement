<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Permission;
use App\Http\Resources\PermissionCollection;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new PermissionCollection(Permission::all());
    }
}
