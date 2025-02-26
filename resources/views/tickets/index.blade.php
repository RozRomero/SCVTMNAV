<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Sistema de Tickets') }}
        </h2>
    </x-slot>
    <h2 class="text-center text-xl font-bold p-6 uppercase">Tickets</h2>

    {{-- Listado de Tickets --}}
    <div class="p-6 rounded-sm shadow-lg m-2 mb-4 bg-gray-600 text-white w-fit mx-auto">
        @if (session()->has('success'))
            <span class="bg-blue-200 text-blue-900 rounded-md block">{{ session()->get('success') }}</span>
        @endif

        <div class="grid grid-cols-2">
            <a href="{{ route('tickets.create') }}"
                class="w-fit h-fit m-auto bg-green-500 hover:bg-green-700 text-white font-bold align-middle text-center py-2 px-4 rounded">Nuevo Ticket</a>
    
            <form class="flex flex-row gap-4 my-4" method="POST">
                @csrf
                <input type="text" name="search" class="bg-gray-700 border-none rounded p-4 w-full sm:w-80"
                    placeholder="Buscar por título">
                <button type="submit"
                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Buscar</button>
            </form>
        </div>

        <div class="grid grid-cols-5 gap-4 p-4">
            <div class="font-bold text-lg">Título</div>
            <div class="font-bold text-lg">Categoría</div>
            <div class="font-bold text-lg">Prioridad</div>
            <div class="font-bold text-lg">Estado</div>
            <div class="font-bold text-lg">Acciones</div>
        </div>

        <div class="flex flex-col">
            @foreach ($tickets as $key => $ticket)
                <div class="grid grid-cols-5 gap-4 p-4 bg-gray-{{ $key % 2 == 0 ? '700' : '800' }}">
                    <div class="font-bold text-lg mb-2">{{ $ticket->title }}</div>
                    <div>{{ $ticket->category }}</div>
                    <div>{{ $ticket->priority }}</div>
                    <div>{{ $ticket->status }}</div>
                    <div class="grid grid-cols-3 gap-2">
                        <a href="{{ route('tickets.show', $ticket->id) }}"
                            class="text-center w-full h-fit bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Ver
                        </a>
                        <a href="{{ route('tickets.edit', $ticket->id) }}"
                            class="text-center w-full h-fit bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            Editar
                        </a>
                        <form action="{{ route('tickets.destroy', $ticket->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="text-center w-full h-fit bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                Eliminar
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-2">
            {{ $tickets->withQueryString()->links() }}
        </div>
    </div>
</x-app-layout>