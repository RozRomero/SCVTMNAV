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

    public function catalogo_empleados(Request $request) {
        // Obtener el campo por el cual ordenar
        $sortBy = $request->input('sort_by', 'antiguedad'); // Por defecto, ordenar por antigüedad
        $order = $request->input('order', 'asc'); // Por defecto, orden ascendente

        // Validar los campos de ordenación
        $validSortFields = ['antiguedad', 'dias_vacaciones', 'dias_utilizados'];
        if (!in_array($sortBy, $validSortFields)) {
            $sortBy = 'antiguedad'; // Si el campo no es válido, usar antigüedad
        }

        // Obtener los usuarios con sus datos de empleado
        $users = User::with(['datosEmpleados', 'departamentos'])
            ->join('datos_empleados', 'users.id', '=', 'datos_empleados.user_id')
            ->orderBy($sortBy, $order)
            ->select('users.*'); // Seleccionar solo las columnas de users

        // Filtrar por nombre si se proporciona
        if ($request->nombre) {
            $users = $users->where('name', 'like', '%' . $request->nombre . '%');
        }

        // Paginar los resultados
        $users = $users->paginate(10);

        // Calcular días disponibles
        $users->each(function ($user) {
            $user->datosEmpleados->dias_disponibles = 
                ($user->datosEmpleados->dias_vacaciones ?? 0) - ($user->datosEmpleados->dias_utilizados ?? 0);
        });

        return view('rrhh.catalogo_empleados', compact('users'));
    }

    public function registro_usuario(Request $request) {
        $id = $request->id;

        $method = $request->query('method') ?? "";
        if (is_numeric($id)) {
            // Se agrega withTrashed para poder consultar usuario "eliminados"
            $user = User::withTrashed()->find($id) ?? [];
        } else {
            $user = [];
        }

        $currentteam = User::where('id', $id)->pluck('current_team_id')->first();
        $departments = CatalogoDepartamentos::all();

        if ($currentteam == null) {
            $currentteam = 0;
        }

        return view('rrhh.create-user', compact('id', 'user', 'currentteam', 'method', 'departments'));
    }

    public function crear_usuario(Request $request) {
        if ($request->id_user == null || $request->id_user == 0 || $request->method == 'clone') {
            $validatedData = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'min:8'],
                'password_confirmation' => ['required', 'same:password', 'min:8'],
            ], [
                'name' => 'El Nombre es requerido',
                'email' => 'El Email es requerido',
                'password' => 'La Contraseña es requerida'
            ]);

            // Registro de Usuario 
            $validatedData['password'] = bcrypt($validatedData['password']);
            $user = new User();
            $user->name = strtoupper($validatedData['name']);
            $user->email = $validatedData['email'];
            $user->password = $validatedData['password'];
            $user->department_id = $request->department ?? null;
            $user->save();

            $roleModel = new ModelHasRoles();
            $roleModel->role_id = $request->role;
            $roleModel->model_id = $user->id;
            $roleModel->model_type = "App\Models\User";
            $roleModel->save();

            return back()->with('success', 'El Empleado Fue Agregado Correctamente');
        } else {
            // Actualización de usuario
            $validatedData = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255'],
            ], [
                'name' => 'El name es requerido',
                'email' => 'El Email es requerido',
            ]);

            User::where('id', $request->id_user)
                ->update([
                    "name" => strtoupper($validatedData['name']),
                    "email" => $validatedData['email'],
                    "department_id" => $request->department ?? null,
                ]);

            $roleModel = ModelHasRoles::where('model_id', $request->id_user)
                ->update(["role_id" => $request->role]);

            return back()->with('success', 'El Empleado Fue Actualizado Correctamente');
        }
    }
}