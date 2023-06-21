<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Requests\Admin\RolesAndPermissionRequest;
use App\Traits\AuthorizeCheacked;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\Admin\RolesAndPermissionUpdateRequest;
class RolesAndPermissionController extends Controller
{
    use AuthorizeCheacked;
    public function index()
    {
        $this->authorizeCheacked('message edit');
        $role = Role::all();
        return response()->json(['success'=>true , 'data'=>$role],200);
    }
    public function store(RolesAndPermissionRequest $request)
    {
        $data = $request->validated();

        $role = Role::create(['name' => $request->role, 'guard_name' => 'web']);
        $role->syncPermissions($request->permissions);

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        return response()->json(['success' => true, 'data' => $role], 200);
    }
    public function create()
    {        
        $this->authorizeCheacked('message view');
        $permission = Permission::all();
        return response()->json(['success' => true, 'data' => $permission], 200);
    }

    public function edit($lang, $id)
    {        
        $this->authorizeCheacked('message edit'); // Call the authorizeChecked method with the required permission
        $role = Role::find($id);
        $role_permissions = $role->permissions;
        return response()->json(['success' => true, 'role' => $role , 'role_permissions'=>$role_permissions], 200);
    }
    


    public function update($lang, $id, RolesAndPermissionUpdateRequest $request)
    {
        $this->authorizeCheacked('message edit');
        
        $role = Role::findOrFail($id);
        
        // Check if the requested role name is different from the existing role name
        if ($role->name !== $request->role) {
            // Check if a role with the requested name already exists
            $existingRole = Role::where('name', $request->role)->first();
            if ($existingRole) {
                return response()->json(['success' => false, 'error' => 'The role name is already taken.'], 422);
            }
            
            // Update the role's name
            $role->name = $request->role;
            $role->save();
        }
        
        $permissions = Permission::whereIn('name', $request->permissions)->get();
        $role->syncPermissions($permissions);
        
        return response()->json(['success' => true, 'data' => $role], 200);
    }

    








    public function destroy($lang, $id)
    {
        try {
            $role = Role::findOrFail($id);
            $role->syncPermissions([]);
            $role->delete();
    
            return response()->json(['success' => true, 'data' => 'Deleted role with name: '.$role->name], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return response()->json(['success' => false, 'data' => 'Role not found with ID: '.$id], 404);
        }
    }
    
    
}
