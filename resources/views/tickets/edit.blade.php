<x-app-layout>
    @section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Ticket') }}
        </h2>
    </x-slot>
    <h2 class="text-center text-xl font-bold p-6 uppercase">Editar Ticket</h2>

    <div class="p-6 rounded-sm shadow-lg m-2 mb-4 bg-gray-600 text-white w-fit mx-auto">
        <form action="{{ route('tickets.update', $ticket->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 gap-4">
                <div>
                    <label for="title" class="block font-bold mb-2">Título</label>
                    <input type="text" name="title" id="title" class="bg-gray-700 border-none rounded p-4 w-full"
                        value="{{ $ticket->title }}" required>
                </div>
                <div>
                    <label for="category" class="block font-bold mb-2">Categoría</label>
                    <input type="text" name="category" id="category" class="bg-gray-700 border-none rounded p-4 w-full"
                        value="{{ $ticket->category }}" required>
                </div>
                <div>
                    <label for="priority" class="block font-bold mb-2">Prioridad</label>
                    <select name="priority" id="priority" class="bg-gray-700 border-none rounded p-4 w-full" required>
                        <option value="Alta" {{ $ticket->priority == 'Alta' ? 'selected' : '' }}>Alta</option>
                        <option value="Media" {{ $ticket->priority == 'Media' ? 'selected' : '' }}>Media</option>
                        <option value="Baja" {{ $ticket->priority == 'Baja' ? 'selected' : '' }}>Baja</option>
                    </select>
                </div>
                <div>
                    <label for="description" class="block font-bold mb-2">Descripción</label>
                    <textarea name="description" id="description" class="bg-gray-700 border-none rounded p-4 w-full"
                        rows="4" required>{{ $ticket->description }}</textarea>
                </div>
                <div>
                    <button type="submit"
                        class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        Actualizar Ticket
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
</x-app-layout>