<x-app-layout>
    <style>
        .select2 {
            display: inline;
            width: 100% !important;
        }

        .select2-contaier--default .select2-selection--single {
            border: none !important;
            padding: .25rem 1rem;
            height: 100% important;
        }
    </style>

    @if (session()->has('success'))
        <div class="flex justify-center items-center m-4 text-white">
            <div class="bg-green-400 rounded py-2 px-4 font-bold uppercase">
                {{ session()->get('success') }}
            </div>
        </div>
    @endif
    @if (session('error'))
        <div class="flex justify-center items-center m-4 text-white">
            <p class="p-2 m-2 rounded uppercase bg-red-400 max-w-screen-sm">{{ session('error') }}</p>
        </div>
    @endif

    <main class="bg-gray-600 m-4 p-2 roundd text-center">
        <h2 class="text-center text-2xl font-bold">CONSULTA Y APROBACION DE VACACIONES SOLICITADAS</h2>


        <div class="pb-4 w-fit mx-auto">
            {{ $solicitudes->withQueryString()->links() }}
        </div>

        <table class="border border-reen-800 w-full overflow-x-auto">
            <thead class="bg-purple-800 rounded-sm">
                <tr>
                    <th class="border border-purple-900">
                        <p class="p-2 text-center font-bold">ID</p>
                    </th>
                    <th class="border border-purple-900">
                        <p class="p-2 text-center font-bold">EMPLEADO</p>
                    </th>
                    <th class="border border-purple-900">
                        <p class="p-2 text-center font-bold">DIAS SOLICITADOS</p>
                    </th>
                    <th class="border border-purple-900">
                        <p class="p-2 text-center font-bold">DIAS RESTANTES</p>
                    </th>
                    <th class="border border-purple-900">
                        <p class="p-2 text-center font-bold">RANGO DE VACACIONES</p>
                    </th>
                    <th class="border border-purple-900">
                        <p class="p-2 text-center font-bold">JEFE DIRECTO</p>
                    </th>
                    <th class="border border-purple-900">
                        <p class="p-7 text-center font-bold">EN SU AUSENCIA CONTACTAR A</p>
                    </th>
                    <th class="border border-purple-900">
                        <p class="p-7 text-center font-bold">AUTORIZAR/NO AUTORIZAR</p>
                    </th>
                </tr>
            </thead>

            <tbody>
                @php
                    $colorCont = 1;
                    $color = 0;
                @endphp

                @if (count($solicitudes) == 0)
                    <tr class="bg-purple-100 rounded-sm text-black text-sm font-bold">
                        <td colspan="8" class="p-4 font-bold">NO HAY SOLICITUDES</td>
                    </tr>
                @endif

                @foreach ($solicitudes as $solicitud)
                    @php
                        if ($colorCont % 2 == 0) {
                            $color = 100;
                        } else {
                            $color = 200;
                        }
                        $colorCont++;
                    @endphp
                    <tr class="bg-purple-{{ $color }} rounded-sm text-black text-sm font-bold">
                        <td class="border border-purple-{{ $color + 100 }}">
                            <p>{{ $solicitud->id_solicitud }}</p>
                        </td>
                        {{-- Nombre Solicitante --}}
                        <td class="border border-purple-{{ $color + 100 }}">
                            <p>{{ $solicitud->solicitante->name }}</p>
                        </td>
                        {{-- Dias Solicitados --}}
                        <td class="border border-purple-{{ $color + 100 }}">
                            <p class="font-bold text-blue-800">{{ $solicitud->dias_solicitados }}</p>
                        </td>
                        <td class="border border-purple-{{ $color + 100 }}">
                            <p class="font-bold text-blue-800">{{ ($solicitud->solicitante->datosEmpleados->dias_vacaciones ?? 0)-($solicitud->solicitante->datosEmpleados->dias_utilizados ?? 0) ?? "No Hay Datos"}}</p>
                        </td>
                        <td class="border border-purple-{{ $color + 100 }}">
                            <p>{{ $solicitud->fecha_inicio_vacaciones }} - {{ $solicitud->calcularFechaFinalVacaciones() }}{{-- date("Y-m-d",strtotime($solicitud->fecha_inicio_vacaciones. "+ ".($solicitud->dias_solicitados-1)." days")) --}}</p>
                        </td>
                        <td class="border border-purple-{{ $color + 100 }}">
                            <p>{{ $solicitud->jefeDirecto->name }}</p>
                        </td>

                        <td class="border border-purple-{{ $color + 100 }}">
                            <p>{{ $solicitud->nota_de_solicitud }}</p>
                        </td>
                        <td class="border border-purple-{{ $color + 100 }} p-2">
                            <form action="{{ route("enviarRespuesta", $solicitud->id_solicitud) }}" method="POST" class="flex flex-col">
                                @csrf
                                <button 
                                    class="bg-green-500 hover:bg-green-600 text-white rounded m-2 p-2" 
                                    type="submit" name="respuesta" value="aprobada"
                                >AUTORIZAR</button>
                                <button 
                                    class="bg-red-400 hover:bg-red-500 text-white rounded m-2 p-2" 
                                    type="submit" name="respuesta" value="no_aprobada"
                                >NO AUTORIZAR</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-2 w-fit mx-auto">
            {{ $solicitudes->withQueryString()->links() }}
        </div>
    </main>
</x-app-layout>
