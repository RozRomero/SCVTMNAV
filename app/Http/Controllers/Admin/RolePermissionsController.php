<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Illuminate\Http\Request;
use App\Models\RoleHasPermissions;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class RolePermissionsController extends Controller
{
    public function roleper($id){

        $roles= Role::Find($id);
        $permissions=Permission::orderBy("name","asc")->get();
        $roleperm=array();
        foreach($roles->permissions as $permission){
            
            $roleperm[]=$permission->id;
        }
        
        
        
        return view('admin.user.role-permission',compact('roles','permissions','roleperm'));
    }
    public function rolePermAdd(Request $request){

        $rol= Role::Find($request->rol);

        $rol->givePermissionTo($request->perm);
       

        return json_encode("PERMISO AGREGADO");

    }
    public function rolePermRem(Request $request){

        $rol= Role::Find($request->rol);

        $rol->revokePermissionTo($request->perm);


        return json_encode("PERMISO ELIMINADO");
        
    }
    public function roleList()
    {   $name="Role";
        $data = Role::orderBy('name', 'asc')->get(['id','name']); // Todas las oficinas (Paises)

        return view('admin.user.settings-offices',compact('data','name')); 
    }
    public function role($id)
    {   
        if (is_numeric($id)){
            $data=Role::where('id',$id)->pluck('name')->first();
        }else{
            $data=array();
        }
        $name="Role";
        return view('admin.user.create-offices',compact('data','name','id')); 
    }
    public function rolecreate(Request $request)
    {   
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            ],[
                'name' => 'Name is required',
            ]
        );

        $newRole = new Role();
        if($request->id > 0){
            $newRole = Role::where('id', $request->id)->first();
        }
        $newRole->name= strtoupper($validatedData['name']);
        $newRole->user_id= Auth::user()->id;
        $newRole->guard_name="web";
        $newRole->save();

        if ($request->cloneFrom) {
            // Registro de permisos
            $cloneRolePermision = RoleHasPermissions::where('role_id', $request->cloneFrom)->get();
            foreach ($cloneRolePermision as $roleHasPermission) {
                $roleHasPermissionExist = RoleHasPermissions::where('permission_id', $roleHasPermission->permission_id)
                    ->where('role_id', $newRole->id)->value('permission_id');
                if (!$roleHasPermissionExist) {
                    $newRoleHasPermision = new RoleHasPermissions;
                    $newRoleHasPermision->permission_id = $roleHasPermission->permission_id;
                    $newRoleHasPermision->role_id = $newRole->id;
                    $newRoleHasPermision->save();
                }
            }
        }
        
        if($request->id==0){
            return back()->with('success', 'Rol Creado Exitosamente');

        }else{
            return back()->with('success', 'Rol Actualizado Exitosamente');
        }
    }
    public function permissionList()
    {   $name="Permission";
        $data = Permission::orderBy('name', 'asc')->get(['id','name']); // Todas las oficinas (Paises)

        return view('admin.user.settings-offices',compact('data','name')); 
    }
    public function permission($id)
    {   
        if (is_numeric($id)){
            $data=Permission::where('id',$id)->pluck('name')->first();
        }else{
            $data=array();
        }
        $name="Permission";
        return view('admin.user.create-offices',compact('data','name','id')); 
    }
    public function permissioncreate(Request $request)
    {   
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            ],[
                'name' => 'Name is required',
            ]
        );
        if($request->id==0){

            $data = new Permission();
            $data->name= strtoupper($validatedData['name']);
            $data->guard_name= "web";
            $data->save();

            return back()->with('success', 'Permiso Creado Exitosamente');

        }else{

            $data=Permission::where('id', $request->id)->update(["name" => strtoupper($validatedData['name'])]);
            return back()->with('success', 'Permiso Actualizado Exitosamente');
        }

    }
}
