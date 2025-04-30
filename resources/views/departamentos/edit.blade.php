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

        <!-- Jefes del Departamento (oculto pero necesario para el sync) -->
        @foreach($jefesAsignados as $jefeId)
            <input type="hidden" name="jefes[]" value="{{ $jefeId }}">
        @endforeach

        <!-- Mostrar jefes actuales -->
        <div class="mb-4">
            <label class="block text-gray-300">Jefe(s) del Departamento:</label>
            <ul class="bg-gray-700 p-3 rounded-md">
                @forelse($departamento->jefes as $jefe)
                    <li class="text-white">{{ $jefe->name }} ({{ $jefe->no_empleado }})</li>
                @empty
                    <li class="text-gray-400 italic">No hay jefes asignados</li>
                @endforelse
            </ul>
        </div>

        <!-- Asignar empleados -->
        <div class="mb-4">
            <label class="block text-gray-300">Asignar Empleados:</label>
            @if($empleadosDisponibles->isEmpty())
                <p class="text-gray-400 italic">No hay empleados disponibles para asignar</p>
            @else
            <select name="empleados[]" multiple class="select2 bg-gray-700 border-none rounded p-3 text-lg w-full">
                @foreach ($empleadosDisponibles as $empleado)
                    <option value="{{ $empleado->id }}" @if(in_array($empleado->id, $empleadosAsignados)) selected @endif>
                        {{ $empleado->name }} ({{ $empleado->no_empleado }})
                    </option>
                @endforeach
            </select>
            @endif
        </div>

        <!-- Empleados actualmente asignados -->
        <div class="mb-4">
            <label class="block text-gray-300">Empleados Asignados:</label>
            <ul class="bg-gray-700 p-3 rounded-md">
                @forelse($departamento->empleados as $empleado)
                    <li class="flex justify-between items-center py-1">
                        <span>{{ $empleado->name }} ({{ $empleado->no_empleado }})</span>
                        <form action="{{ route('departamentos.removerEmpleado', ['departamento' => $departamento->id, 'empleado' => $empleado->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded text-xs">
                                Eliminar
                            </button>
                        </form>
                    </li>
                @empty
                    <li class="text-gray-400 italic">No hay empleados asignados</li>
                @endforelse
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

<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Seleccione empleados...",
            allowClear: true,
            width: '100%'
        });
    });
</script>
@endsection