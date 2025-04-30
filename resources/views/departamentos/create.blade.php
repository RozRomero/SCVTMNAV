@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-gray-800 text-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-4 text-center">Crear Nuevo Departamento</h2>

    @if(session('error'))
        <div class="bg-red-500 text-white p-3 mb-4 rounded-md">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('departamentos.store') }}" method="POST">
        @csrf

        <!-- Nombre del Departamento -->
        <div class="mb-4">
            <label class="block text-gray-300">Nombre del Departamento:</label>
            <input type="text" name="nombre_departamento" value="{{ old('nombre_departamento') }}"
                class="w-full px-4 py-2 bg-gray-700 text-white rounded-md border border-gray-600 focus:outline-none focus:border-blue-400">
        </div>

        <!-- Asignar jefes -->
        <div class="mb-4">
            <label class="block text-gray-300">Asignar Jefe(s):</label>
            @if($empleadosDisponibles->isEmpty())
                <p class="text-gray-400 italic">No hay empleados disponibles para asignar como jefes</p>
            @else
            <select name="jefes[]" multiple class="select2 bg-gray-700 border-none rounded p-3 text-lg w-full">
                @foreach ($empleadosDisponibles as $empleado)
                    <option value="{{ $empleado->id }}">
                        {{ $empleado->name }} ({{ $empleado->no_empleado }})
                    </option>
                @endforeach
            </select>
            @endif
        </div>

        <div class="flex justify-end gap-2">
            <a href="{{ route('departamentos.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md">
                Cancelar
            </a>
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">
                Crear Departamento
            </button>
        </div>
    </form>
</div>

<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Seleccione jefe(s)...",
            allowClear: true,
            width: '100%'
        });
    });
</script>
@endsection