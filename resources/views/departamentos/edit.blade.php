@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-gray-800 text-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-4 text-center">Editar Departamento</h2>

    @if(session('error'))
        <div class="bg-red-500 text-white p-3 mb-4 rounded-md">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('departamentos.update', $departamento->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Nombre del Departamento -->
        <div class="mb-4">
            <label class="block text-gray-300">Nombre del Departamento:</label>
            <input type="text" name="nombre_departamento" value="{{ $departamento->nombre_departamento }}"
                class="w-full px-4 py-2 bg-gray-700 text-white rounded-md border border-gray-600 focus:outline-none focus:border-blue-400">
        </div>

        <!-- Nombre del Jefe del Departamento -->
<div class="mb-4">
    <label class="block text-gray-300">Jefe del Departamento:</label>
    <ul class="bg-gray-700 p-3 rounded-md">
        @foreach($departamento->jefes as $jefe)
            <li class="text-white">
                {{ $jefe->name }}
            </li>
        @endforeach
    </ul>
</div>



        <!-- Selección múltiple de empleados -->
<div class="mb-4">
    <label class="block text-gray-300">Asignar Empleados:</label>

    @if($empleadosDisponibles->isEmpty())
        <p class="text-gray-400 italic">No hay más empleados que asignar.</p>
    @else
        <select name="empleados[]" multiple class="w-full select2 bg-gray-700 text-white border border-gray-600 rounded-md">
            @foreach($empleadosDisponibles as $empleado)
            <option value="{{ $empleado->id }}"
                @if(in_array($empleado->id, $empleadosAsignados)) selected @endif>
                {{ $empleado->name }}
            </option>
            
            @endforeach
        </select>
    @endif
</div>


        <!-- Mostrar empleados actualmente asignados -->
<div class="mb-4">
    <label class="block text-gray-300">Empleados Asignados:</label>
    <ul class="bg-gray-700 p-3 rounded-md">
        @foreach($departamento->empleados as $empleado)
            <li class="flex justify-between items-center">
                {{ $empleado->nombre }}
                <form action="{{ route('departamentos.removerEmpleado', ['departamentoId' => $departamento->id, 'empleadoId' => $empleado->id]) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este empleado del departamento?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded-md text-sm">
                        Eliminar
                    </button>
                </form>
            </li>
        @endforeach
    </ul>
</div>


        <div class="flex justify-end gap-2">
            <a href="{{ route('departamentos.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md">
                Cancelar
            </a>
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">
                Guardar Cambios
            </button>
        </div>
    </form>
</div>

<!-- Script para activar Select2 -->
<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Seleccione empleados...",
            allowClear: true
        });
    });
</script>
@endsection
