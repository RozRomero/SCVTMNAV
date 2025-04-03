<x-app-layout>
    
@section('content')
    <h2 class="text-center m-4 text-2xl font-bold">{{ Auth::user()->name }}</h2>

    <section class="bg-gray-600 w-fit m-4 mx-auto p-2 rounded text-center">
        <p class="bg-blue-800 p-4">INFO VACACIONES</p>
        <table>
            <thead>
                <tr class="bg-gray-800">

                    <th class="p-4 border border-gray-600">FECHA DE INGRESO</th>
                    <th class="p-4 border border-gray-600">ANTIGUEDAD</th>
                    <th class="p-4 border border-gray-600">DIAS</th>
                    <th class="p-4 border border-gray-600">DIAS <br> DISPONIBLES</th>
                    <th class="p-4 border border-gray-600">DIAS <br> USADOS</th>
                </tr>
            </thead>
            <tbody>
                <tr class="bg-gray-700">
                    <td class="p-4 border border-gray-600">{{ $user->datosEmpleados->fecha_ingreso ?? "No Hay Datos" }}</td>
                    <td class="p-4 border border-gray-600">{{ $user->datosEmpleados->antiguedad ?? "No Hay Datos" }}</td>
                    <td class="p-4 border border-gray-600">{{ $user->datosEmpleados->dias_vacaciones ?? "No Hay Datos" }}</td>
                    <td class="p-4 border border-gray-600">{{ ($user->datosEmpleados->dias_vacaciones ?? 0)-($user->datosEmpleados->dias_utilizados ?? 0) ?? "No Hay Datos"}}</td>
                    <td class="p-4 border border-gray-600">{{ $user->datosEmpleados->dias_utilizados ?? "No Hay Datos" }}</td>
                </tr>
            </tbody>
        </table>
    </section>

    <section class="w-fit m-4 mx-auto p-2 rounded text-center">
        @if (!empty(($user->datosEmpleados->dias_vacaciones ?? 0)-($user->datosEmpleados->dias_utilizados ?? 0)))
        <nav class="block my-2">
            <a href="{{ route('vistaSolicitudVacaciones') }}" class="bg-blue-500 hover:bg-blue-700 p-4 m-2 font-bold">SOLICITAR VACACIONES</a>
        </nav>
        @endif
    </section>
    @endsection
</x-app-layout>