<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Listar todos los usuarios con sus relaciones
     */
    public function index(Request $request)
    {
        $query = User::with(['department', 'accessibleDepartments', 'roles', 'permissions']);

        // Filtrar por nombre o email
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filtrar por departamento
        if ($request->has('department_id')) {
            $query->where('department_id', $request->department_id);
        }

        // Filtrar por rol
        if ($request->has('role')) {
            $query->role($request->role);
        }

        $perPage = $request->input('per_page', 15);
        $users = $query->paginate($perPage);

        return response()->json($users);
    }

    /**
     * Crear un nuevo usuario con roles y departamentos
     */
    public function store(StoreUserRequest $request)
    {
        // Crear el usuario
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'department_id' => $request->department_id,
        ]);

        // Asignar roles
        $user->syncRoles($request->roles);

        // Asignar departamentos accesibles si se proporcionan
        if ($request->has('accessible_departments')) {
            $syncData = [];
            foreach ($request->accessible_departments as $dept) {
                $syncData[$dept['department_id']] = ['role' => $dept['role']];
            }
            $user->accessibleDepartments()->sync($syncData);
        }

        return response()->json([
            'message' => 'Usuario creado exitosamente',
            'data' => $user->load(['department', 'accessibleDepartments', 'roles', 'permissions'])
        ], 201);
    }

    /**
     * Mostrar un usuario específico con todas sus relaciones
     */
    public function show($id)
    {
        $user = User::with(['department', 'accessibleDepartments', 'roles', 'permissions'])
            ->findOrFail($id);

        return response()->json([
            'data' => $user
        ]);
    }

    /**
     * Actualizar un usuario
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $user = User::findOrFail($id);

        $data = $request->only(['name', 'email', 'department_id']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return response()->json([
            'message' => 'Usuario actualizado exitosamente',
            'data' => $user->load(['department', 'accessibleDepartments', 'roles'])
        ]);
    }

    /**
     * Asignar roles a un usuario
     */
    public function assignRoles(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'roles' => 'required|array',
            'roles.*' => 'string|exists:roles,name'
        ]);

        $user->syncRoles($request->roles);

        return response()->json([
            'message' => 'Roles asignados exitosamente',
            'data' => [
                'user' => $user,
                'roles' => $user->getRoleNames(),
                'permissions' => $user->getAllPermissions()->pluck('name')
            ]
        ]);
    }

    /**
     * Asignar departamentos accesibles a un usuario
     */
    public function assignDepartments(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'departments' => 'required|array',
            'departments.*.department_id' => 'required|exists:departments,id',
            'departments.*.role' => 'required|in:viewer,manager,approver'
        ]);

        // Preparar datos para el sync con pivot
        $syncData = [];
        foreach ($request->departments as $dept) {
            $syncData[$dept['department_id']] = ['role' => $dept['role']];
        }

        $user->accessibleDepartments()->sync($syncData);

        return response()->json([
            'message' => 'Departamentos accesibles actualizados exitosamente',
            'data' => $user->load('accessibleDepartments')
        ]);
    }

    /**
     * Obtener los roles de un usuario
     */
    public function getRoles($id)
    {
        $user = User::findOrFail($id);

        return response()->json([
            'roles' => $user->getRoleNames(),
            'permissions' => $user->getAllPermissions()->pluck('name')
        ]);
    }

    /**
     * Obtener los departamentos accesibles de un usuario
     */
    public function getAccessibleDepartments($id)
    {
        $user = User::with('accessibleDepartments')->findOrFail($id);

        return response()->json([
            'department_home' => $user->department,
            'accessible_departments' => $user->accessibleDepartments
        ]);
    }
}
