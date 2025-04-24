<x-app-layout>
    @vite(['resources/js/app.js', 'resources/css/app.css'])
    @section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ver Ticket') }}
        </h2>
    </x-slot>

    <h2 class="text-center text-[18px] font-bold pt-6 uppercase font-sans">Ticket</h2>

    <div class="p-6 rounded shadow-lg my-4 bg-indigo-500 text-white w-full max-w-4xl mx-auto font-sans text-[14px]">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2">
                <label class="block font-bold text-[14px] mb-1">Título</label>
                <div class="bg-red-700 rounded px-3 py-1 w-full text-left ">
                    {{ $ticket->title }}
                </div>
            </div>

            <div>
                <label class="block font-bold text-[14px] mb-1">Categoría</label>
                <div class="bg-gray-700 rounded px-3 py-1 w-full text-left break-words whitespace-pre-wrap">
                    {{ $ticket->category }}
                </div>
            </div>

            <div>
                <label class="block font-bold text-[14px] mb-1">Prioridad</label>
                <div class="bg-gray-700 rounded px-3 py-1 w-full text-left break-words whitespace-pre-wrap">
                    {{ $ticket->priority }}
                </div>
            </div>

            <div class="md:col-span-2">
                <label class="block font-bold text-[14px] mb-1">Descripción</label>
                <div class="bg-gray-700 rounded px-3 py-1 w-full text-left break-words whitespace-pre-wrap min-h-[5rem]">
                    {{ $ticket->description }}
                </div>
            </div>
        </div>

        <div class="flex justify-center mt-6">
            <a href="{{ route('tickets.index') }}" 
               class="bg-red-500 text-white font-bold py-2 px-6 rounded hover:bg-red-700 transition duration-300 ease-in-out text-base">
                Regresar
            </a>
        </div>
    </div>
@endsection
</x-app-layout>
