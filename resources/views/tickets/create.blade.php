<x-app-layout>
    
@section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crear Nuevo Ticket') }}
        </h2>
    </x-slot>
    <h2 class="text-center text-xl font-bold p-6 uppercase">Nuevo Ticket</h2>

    <div class="p-6 rounded-sm shadow-lg m-2 mb-4 bg-gray-600 text-white w-fit mx-auto">
        <form action="{{ route('tickets.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 gap-4">
                <div>
                    <label for="title" class="block font-bold mb-2">Título</label>
                    <input type="text" name="title" id="title" class="bg-gray-700 border-none rounded p-4 w-full"
                        placeholder="Título del ticket" required>
                </div>
                <div>
                    <label for="category" class="block font-bold mb-2">Categoría</label>
                    <input type="text" name="category" id="category" class="bg-gray-700 border-none rounded p-4 w-full"
                        placeholder="Categoría del ticket" required>
                </div>
                <div>
                    <label for="priority" class="block font-bold mb-2">Prioridad</label>
                    <select name="priority" id="priority" class="bg-gray-700 border-none rounded p-4 w-full" required>
                        <option value="Alta">Alta</option>
                        <option value="Media">Media</option>
                        <option value="Baja">Baja</option>
                    </select>
                </div>
                <div>
                    <label for="description" class="block font-bold mb-2">Descripción</label>
                    <textarea name="description" id="description" class="bg-gray-700 border-none rounded p-4 w-full"
                        placeholder="Descripción del ticket" rows="4" required></textarea>
                </div>
                <div>
                    <button type="submit"
                        class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        Crear Ticket
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
</x-app-layout>