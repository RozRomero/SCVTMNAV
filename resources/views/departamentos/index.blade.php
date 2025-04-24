@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto bg-blue-800 text-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-4 text-center">Lista de Departamentos</h2>

    <!-- Botón para agregar -->
    <div class="flex justify-end mb-4">
        <a href="{{ route('departamentos.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">
            + Agregar Departamento
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-500 text-white p-3 mb-4 rounded-md">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full border border-gray-700 bg-gray-900 text-gray-200 rounded-lg">
            <thead class="bg-gray-700 text-white">
                <tr>
                    <th class="border border-gray-600 px-4 py-2">ID</th>
                    <th class="border border-gray-600 px-4 py-2">Nombre</th>
                    <th class="border border-gray-600 px-4 py-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($departamentos as $departamento)
                    <tr class="hover:bg-gray-700">
                        <td class="border border-gray-600 px-4 py-2 text-center">{{ $departamento->id }}</td>
                        <td class="border border-gray-600 px-4 py-2 text-center">{{ $departamento->nombre_departamento }}</td>
                        <td class="border border-gray-600 px-4 py-2 flex justify-center gap-2">
                            <a href="{{ route('departamentos.edit', $departamento->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-md">
                                Editar
                            </a>
                            <form action="{{ route('departamentos.destroy', $departamento->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md"
                                    onclick="return confirm('¿Estás seguro de eliminar este departamento?')">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
