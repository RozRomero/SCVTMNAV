<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\ModelHasRoles;
use App\Models\DatosEmpleados;
use App\Http\Controllers\Controller;
use App\Models\CatalogoDepartamentos;

class UserController extends Controller
{
    public function verPerfil() {
        $user = User::find(Auth::user()->id);

        return view('profile.perfil', compact("user"));
    }

    public function catalogo_usuarios(Request $request) {
        $users = User::withTrashed();
        if ($request->nombre) {
            $users = $users->where('name', 'like','%'.$request->nombre.'%');
        }
        $users = $users->orderBy('name', 'asc')->paginate(10);
        
        return view('rrhh.catalogo_empleados',compact('users'));
    }

    public function registro_usuario(Request $request) {
        $id = $request->id;

        $method = $request->query('method') ?? "";
        //  && $request->query('method') != 'clone'
        if (is_numeric($id)){
            // Se agrega withTrashed para poder consultar usuario "eliminados"
            $user=User::withTrashed()->find($id)?? [];
        }else{
            $user=array();
        }

        $currentteam=User::where('id', $id)->pluck('current_team_id')->first();
        $departments = CatalogoDepartamentos::all();
        // $countrys=CatCountry::orderBy("country","asc")->get();
        // $groups=Group::groupsAvailable();
        // $userGroups = UsersGroups::allGroupsByUser($id)->pluck('group_id')->toArray();
        
        if($currentteam==null){
            $currentteam=0;
        }
        
        return view('rrhh.create-user',compact('id', 'user','currentteam', 'method', 'departments'));

    }

    public function crear_usuario(Request $request) {

        if($request->id_user == null || $request->id_user == 0 || $request->method == 'clone'){
            $validatedData = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                // 'lastName' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'min:8'],
                'password_confirmation' => ['required','same:password','min:8'],
                ],[
                    'name' => 'El Nombre es requerido',
                    // 'lastName' => 'Last Name is required',
                    'email' => 'El Email es requerido',
                    'password' => 'La Contraseña es requerida'
                ]
            );

            // Registro de Usuario 
            $validatedData['password'] = bcrypt($validatedData['password']);
            $user = new User();
            $user->name = strtoupper($validatedData['name']);
            $user->email = $validatedData['email'];
            $user->password = $validatedData['password'];
            $user->department_id = $request->department ?? null;
            $user->save();


            $roleModel= new ModelHasRoles();
            $roleModel->role_id=$request->role;
            $roleModel->model_id=$user->id;
            $roleModel->model_type="App\Models\User";
            $roleModel->save();

            return back()->with('success', 'El Empleado Fue Agregado Correctamente');
        } else {
            // Actualizacion de usuario
            $validatedData = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255'],
                ],[
                    'name' => 'El name es requerido',
                    'email' => 'El Email es requerido',
                ]
            );

            User::where('id', $request->id_user)
            ->update([
                "name" => strtoupper($validatedData['name']),
                "email"=>$validatedData['email'],
                "department_id" => $request->department ?? null,
            ]);

            $roleModel=ModelHasRoles::where('model_id', $request->id_user)->update(["role_id" => $request->role]);

            return back()->with('success', 'El Empleado Fue Actualizado Correctamente');
        }
    }   
}
