<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $role = Role::all();
        return response()->json($role);
    }
    public function store(Request $request)
    {
        $request->validate([
            'role_name' => 'required|string|min:3|max:255|unique:roles,role_name',
            'privilege' => 'required',
        ]);
        $role = new Role();
        $role->role_name = $request['role_name'];
        $role->permissions = $request['privilege'];
        $role->save();
        return response()->json(['message' => 'Role created successfully']);
    }
    public function update(Request $request)
    {
        $request->validate([
            'role_name' => 'required|string',
            'privilege' => 'required',
        ]);

        $role = Role::find($request->id);
        if (!$role) {
            return response()->json(['message' => 'Role not found'], 404);
        }

        $role->role_name = $request['role_name'];
        $role->permissions = $request['privilege'];

        $role->save();

        return response()->json(['message' => 'Role updated successfully']);
    }
    public function delete($id)
    {
        $role = Role::find($id);
        if (!$role) {
            return response()->json(['message' => 'Role not found'], 404);
        }
        $role->delete();
        return response()->json(['message' => 'Role delete successfully']);
    }
}
