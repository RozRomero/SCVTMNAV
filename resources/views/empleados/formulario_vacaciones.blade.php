<x-app-layout>
@section('content')
    <main>
        {{-- MENSAJES DE RESPUESTA --}}
        @if (session('success'))
            <div class="flex justify-center items-center m-4 text-white">
                @foreach (session('success') as $successMessage)
                    <p class="p-2 m-2 rounded uppercase bg-green-700 max-w-screen-sm">{{ $successMessage }}</p>
                @endforeach
            </div>
        @endif

        @if (session('errors'))
            <div class="flex justify-center items-center m-4 text-white">
                @foreach (session('errors') as $errorsMessage)
                    <p class="p-2 m-2 rounded uppercase bg-red-900 max-w-screen-sm">{{ $errorsMessage }}</p>
                @endforeach
            </div>
        @endif

        {{-- CONTENIDO --}}
        @if (is_null($departamento))
        <div class="bg-red-600 text-white p-4 rounded-md text-center">
            <p>Al no tener departamento no es posible registrar una solicitud de vacaciones. Comunícate con tu superior para que se te asigne un departamento en el sistema.</p>
        </div>
        @else
        <section>
            <h2 class="text-center m-4 text-2xl font-bold">SOLICITUD DE VACACIONES {{ $departamento }}</h2>
            <h3 class="text-center w-1/3 mx-auto">Es importante notar que se requiere un mínimo de 5 días de anticipación para solicitar vacaciones y estas requieren de aprobación.</h3>
        </section>
        @endif
        <section class="bg-gray-600 w-fit m-4 mx-auto p-2 rounded text-center">
            <form action="{{ route('enviarSolicitudVacaciones') }}" method="POST">
                @csrf

                <div class="grid grid-cols-2 p-2 m-2 gap-4 overflow-auto text-center">
                    <div>
                        <label for="empleado" class="block font-bold mb-2">NOMBRE DEL EMPLEADO *:</label>

                        <h2 class='bg-gray-700 uppercase font-bold rounded p-2'>{{ Auth::user()->name }}</h2>
                    </div>

                    <div class="grid grid-cols-1">
                        <label for="jefe_directo" class="block font-bold mb-2">JEFE DIRECTO *:</label>
                        <select name="jefe_directo" id="jefe_directo" class="bg-gray-700 border-none uppercase rounded p-2" required>
                            <option value=""></option>
                            @foreach ($jefesDeArea as $jefe)
                                <option class="uppercase" value="{{ $jefe->id }}">{{ $jefe->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="grid grid-cols-1">
                        <label for="dias_solicitados" class="block font-bold mb-2">DIAS A SOLICITAR *:</label>
                        <input type="number" id="dias_solicitados" name="dias_solicitados"
                            class="bg-gray-700 border-none rounded p-2" min="1" required>
                    </div>
                    <div class="grid grid-cols-1">
                        <label for="fecha_inicio" class="block font-bold mb-2">FECHA INICIO DE VACACIONES *:</label>
                        <input type="date" id="fecha_inicio" name="fecha_inicio" min="{{ $fechaInicial }}" class="bg-gray-700 border-none rounded p-2 text-center" required>
                    </div>
                    
                </div>
                <div class="grid grid-cols-1">
                    <label for="nota_contactar" class="block font-bold mb-2">EN MI AUSENCIA CONTACTAR A *: </label>
                    <textarea name="nota_contactar" id="nota_contactar" class="bg-gray-700 border-none rounded p-2 mx-4" required></textarea>
                    {{-- <input type="text" id="nota_contactar" name="nota_contactar"> --}}
                </div>
                <div class="m-2">
                    <p>* Campos Obligatorios</p>
                </div>
                <div class="flex justify-center m-2">
                    <button class="w-fit py-2 px-4 bg-green-600 text-white rounded-md hover:bg-green-500 font-bold" type="submit">SOLICITAR</button>
                </div>
            </form>
        </section>
    </main>

    <script>
        // Obtener el campo de entrada de fecha
        let inputFecha = document.querySelector('#fecha_inicio');

        // Función para verificar si una fecha es día laborable (lunes a viernes)
        function esDiaLaborable(fecha) {
            let diaSemana = fecha.getDay();
            return diaSemana >= 0 && diaSemana <= 4; // De lunes a viernes
        }

        // Manejar eventos de cambio en el campo de fecha
        inputFecha.addEventListener('change', function() {
            let fechaSeleccionada = new Date(inputFecha.value);
            if (!esDiaLaborable(fechaSeleccionada)) {
                alert("Selecciona una fecha válida");
                inputFecha.value = ''; // Limpiar el campo si se selecciona una fecha no válida
            }
        });
    </script>
    @endsection
</x-app-layout>
