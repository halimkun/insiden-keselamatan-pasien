<?php

namespace App\Http\Controllers;

use App\Helpers\TelegramHelper;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles       = Role::all();
        $permissions = Permission::all();

        return view('role-permission.index', compact('roles', 'permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->except('_token');
        try {
            $roles_name = array_keys($data);
        
            foreach ($roles_name as $name) {
                $role = Role::findByName($name);
                
                if (!$role) {
                    throw new \Exception("Role not found");
                }

                $role->syncPermissions($data[$name]);
            }

            TelegramHelper::sendMessage("✅", "ROLE AND PERMISSIONS UPDATED", [
                "Roles"       => $roles_name,
                "Permissions" => $data
            ]);

            return redirect()->route('roles.index')->with('success', 'Role and Permission updated successfully');
        } catch (\Throwable $th) {

            TelegramHelper::sendMessage("❌", "ROLE AND PERMISSIONS UPDATED FAILED", [
                "Roles"       => $roles_name,
                "Permissions" => $data,
                "Error"       => $th->getMessage()
            ]);
            
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
