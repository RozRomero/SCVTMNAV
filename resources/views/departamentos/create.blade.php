<x-app-layout>
    @section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Agregar Departamento') }}
        </h2>
    </x-slot>

    <h2 class="text-center text-3xl font-bold p-6 uppercase">Nuevo Departamento</h2>

    {{-- Formulario de Creación --}}
    <div class="p-6 rounded-sm shadow-lg m-2 mb-4 bg-blue-600 text-white w-fit mx-auto">
        @if (session()->has('success'))
            <span class="bg-blue-200 text-blue-900 rounded-md block text-lg p-2">
                {{ session()->get('success') }}
            </span>
        @endif

        <form action="{{ route('departamentos.store') }}" method="POST" class="flex flex-col gap-4">
            @csrf
            <div class="mb-4">
                <label class="block text-lg font-bold">Nombre del Departamento</label>
                <input type="text" name="nombre_departamento" class="bg-gray-700 border-none rounded p-3 text-lg w-96"
                    required>
                @error('nombre_departamento')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-lg font-bold">Jefe(s) del Departamento</label>
                <select name="jefes[]" multiple required class="bg-gray-700 border-none rounded p-3 text-lg w-96">
                    @foreach ($empleados as $empleado)
                        <option value="{{ $empleado->id }}">{{ $empleado->name }}</option>
                    @endforeach
                </select>
                @error('jefes')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>            

            <div class="flex justify-between">
                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-3 px-6 rounded text-lg">
                    Guardar
                </button>
                <a href="{{ route('departamentos.index') }}"
                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-3 px-6 rounded text-lg">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
    @endsection
</x-app-layout>
