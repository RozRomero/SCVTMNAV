<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CatalogoDepartamentos;
use App\Models\User;

class DepartamentoController extends Controller
{
    public function index()
    {
        $departamentos = CatalogoDepartamentos::with(['empleados', 'jefes'])->get();
        return view('departamentos.index', compact('departamentos'));
    }

    public function create()
    {
        // Obtener empleados que NO tienen un departamento asignado y NO son jefes en ningún departamento
        $empleadosDisponibles = User::whereDoesntHave('departamentos')
            ->whereDoesntHave('departamentosComoJefe')
            ->get(['id', 'name', 'no_empleado']);
    
        return view('departamentos.create', compact('empleadosDisponibles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_departamento' => 'required|string|max:255|unique:catalogo_departamentos,nombre_departamento',
            'jefes' => 'required|array|min:1',
        ]);

        // Verificar si algún jefe ya es jefe en otro departamento
        $jefesOcupados = User::whereIn('id', $request->jefes)
            ->whereHas('departamentosComoJefe')
            ->get();

        if ($jefesOcupados->count() > 0) {
            $nombres = $jefesOcupados->pluck('name')->join(', ');
            return redirect()->back()
                ->withInput()
                ->with('error', "Los siguientes usuarios ya son jefes en otros departamentos: $nombres");
        }

        // Crear el departamento
        $departamento = CatalogoDepartamentos::create([
            'nombre_departamento' => $request->nombre_departamento
        ]);

        // Asignar jefes
        $departamento->jefes()->sync($request->jefes);

        return redirect()->route('departamentos.index')
            ->with('success', 'Departamento creado correctamente.');
    }

    public function edit($id)
    {
        $departamento = CatalogoDepartamentos::with(['empleados', 'jefes'])->findOrFail($id);
    
        // Empleados disponibles para asignar:
        // 1. Que no sean jefes en ningún departamento
        // 2. Que no estén asignados a otros departamentos O que ya estén en este departamento
        $empleadosDisponibles = User::whereDoesntHave('departamentosComoJefe')
            ->where(function($query) use ($id) {
                $query->whereDoesntHave('departamentos')
                    ->orWhereHas('departamentos', function($q) use ($id) {
                        $q->where('departamento_empleado.departamento_id', $id);
                    });
            })
            ->get(['id', 'name', 'no_empleado']);
    
        // Empleados actualmente asignados al departamento
        $empleadosAsignados = $departamento->empleados->pluck('id')->toArray();
        
        // Jefes actuales del departamento
        $jefesAsignados = $departamento->jefes->pluck('id')->toArray();
    
        return view('departamentos.edit', compact(
            'departamento',
            'empleadosDisponibles',
            'jefesAsignados',
            'empleadosAsignados'
        ));
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'jefes' => 'required|array|min:1',
        'nombre_departamento' => 'required|string|max:255|unique:catalogo_departamentos,nombre_departamento,'.$id,
        'empleados' => 'nullable|array'
    ]);

    $departamento = CatalogoDepartamentos::findOrFail($id);
    
    // Actualizar nombre del departamento
    $departamento->update([
        'nombre_departamento' => $request->nombre_departamento
    ]);

    // Sincronizar jefes (mantener los existentes)
    $departamento->jefes()->sync($request->jefes);

    // Sincronizar empleados - usar syncWithoutDetaching para no eliminar los existentes
    if ($request->has('empleados')) {
        $empleadosParaAsignar = $request->input('empleados', []);
        
        // Verificar que los empleados no estén en otros departamentos
        $empleadosOcupados = User::whereIn('id', $empleadosParaAsignar)
            ->whereHas('departamentos', function($query) use ($id) {
                $query->where('departamento_empleado.departamento_id', '!=', $id);
            })
            ->get();

        if ($empleadosOcupados->count() > 0) {
            $nombres = $empleadosOcupados->pluck('name')->join(', ');
            return redirect()->back()
                ->withInput()
                ->with('error', "Los empleados ($nombres) ya están asignados a otro departamento.");
        }

        // Usar syncWithoutDetaching para agregar sin eliminar los existentes
        $departamento->empleados()->syncWithoutDetaching($empleadosParaAsignar);
    }

    return redirect()->route('departamentos.index')
        ->with('success', 'Departamento actualizado correctamente.');
}

    public function destroy($id)
    {
        $departamento = CatalogoDepartamentos::findOrFail($id);

        // Eliminar relaciones en las tablas pivote
        $departamento->empleados()->detach();
        $departamento->jefes()->detach();

        // Eliminar el departamento
        $departamento->delete();

        return redirect()->route('departamentos.index')
            ->with('success', 'Departamento eliminado correctamente.');
    }

    public function removerEmpleado($departamentoId, $empleadoId)
    {
        $departamento = CatalogoDepartamentos::findOrFail($departamentoId);
        $empleado = User::findOrFail($empleadoId);

        // Verificar si el empleado pertenece al departamento
        if ($departamento->empleados()->where('users.id', $empleadoId)->exists()) {
            $departamento->empleados()->detach($empleadoId);
            return redirect()->back()
                ->with('success', 'Empleado eliminado del departamento correctamente.');
        }

        return redirect()->back()
            ->with('error', 'El empleado no pertenece a este departamento.');
    }
}