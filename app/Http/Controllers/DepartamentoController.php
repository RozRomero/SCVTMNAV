<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CatalogoDepartamentos;
use App\Models\User;

class DepartamentoController extends Controller
{
    public function index()
    {
        $departamentos = CatalogoDepartamentos::with('empleados')->get();
        return view('departamentos.index', compact('departamentos'));
    }

    public function create()
    {
        // Obtener empleados que NO tienen un departamento asignado
        $empleados = User::whereDoesntHave('departamentos')->get();
        return view('departamentos.create', compact('empleados'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_departamento' => 'required|string|max:255|unique:catalogo_departamentos,nombre_departamento',
            'jefes' => 'required|array|min:1',
        ]);
    
        // Crear el departamento
        $departamento = CatalogoDepartamentos::create([
            'nombre_departamento' => $request->nombre_departamento
        ]);
        // Asignar jefes
        $departamento->jefes()->sync($request->jefes);
        // Asignar empleados al departamento
        if ($request->has('empleados')) {
            $departamento->empleados()->sync($request->empleados);
        }
    
        return redirect()->route('departamentos.index')->with('success', 'Departamento agregado correctamente.');
    }
    

    public function edit($id)
{
    $departamento = CatalogoDepartamentos::findOrFail($id);

    // Obtener todos los empleados
    $empleados = User::all();

    // Obtener IDs de empleados ya asignados como jefes en otros departamentos
    $empleadosJefes = CatalogoDepartamentos::where('id', '!=', $id)
        ->with('jefes')
        ->get()
        ->pluck('jefes')
        ->flatten()
        ->pluck('id')
        ->unique()
        ->toArray();

    // Filtrar empleados disponibles (que no sean jefes en otro departamento)
    $empleadosDisponibles = $empleados->reject(function ($empleado) use ($empleadosJefes) {
        return in_array($empleado->id, $empleadosJefes);
    });

    // Si no hay empleados disponibles, pasamos una colección vacía
    if ($empleadosDisponibles->isEmpty()) {
        $empleadosDisponibles = collect();
    }

    $empleadosAsignados = $departamento->empleados->pluck('id')->toArray();
    $jefesAsignados = $departamento->jefes->pluck('id')->toArray();

    return view('departamentos.edit', compact('departamento', 'empleadosDisponibles', 'jefesAsignados', 'empleadosAsignados'));
}




    public function update(Request $request, $id)
{
    $request->validate([
        'jefes' => 'required|array|min:1',
    ]);
    $departamento = CatalogoDepartamentos::findOrFail($id);

    $empleadosSeleccionados = $request->input('empleados', []);

    // Buscar si algún empleado ya pertenece a otro departamento
    $empleadosOcupados = User::whereIn('id', $empleadosSeleccionados)
        ->whereHas('departamento', function ($query) use ($id) {
            $query->where('catalogo_departamentos.id', '!=', $id);
        })
        ->get();

    if ($empleadosOcupados->count() > 0) {
        $nombres = $empleadosOcupados->pluck('name')->join(', ');
        return redirect()->back()->with('error', "Los empleados ($nombres) ya están asignados a otro departamento. Elimínalos primero.");
    }

    // Actualizar empleados en la tabla pivote
    $departamento->empleados()->sync($empleadosSeleccionados);

    $departamento->jefes()->sync($request->jefes);

    return redirect()->route('departamentos.index')->with('success', 'Departamento actualizado correctamente.');
}


public function destroy($id)
{
    $departamento = CatalogoDepartamentos::findOrFail($id);

    // Eliminar relaciones en la tabla pivote
    $departamento->empleados()->detach();

    // Eliminar el departamento
    $departamento->delete();

    return redirect()->route('departamentos.index')->with('success', 'Departamento eliminado correctamente.');
}



public function removerEmpleado($departamentoId, $empleadoId)
{
    $departamento = CatalogoDepartamentos::findOrFail($departamentoId);
    $empleado = User::findOrFail($empleadoId);

    // Verificar si el empleado pertenece al departamento antes de eliminarlo
    if ($departamento->empleados()->where('id', $empleadoId)->exists()) {
        $departamento->empleados()->detach($empleadoId);
        return redirect()->back()->with('success', 'Empleado eliminado del departamento.');
    }

    return redirect()->back()->with('error', 'El empleado no pertenece a este departamento.');
}

public function users()
{
    return $this->belongsToMany(User::class, 'departamento_empleado', 'departamento_id', 'user_id');
}

}
