<x-app-layout>
    @section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-white-800 leading-tight">
            {{ __('Settings Users') }}
        </h2>
    </x-slot>
    <h2 class="text-center text-3xl font-bold p-6 uppercase">Users</h2>

    {{-- Listado de Usuarios --}}
    <div class="p-6 rounded-sm shadow-lg m-2 mb-4 bg-indigo-600 text-white w-fit mx-auto">
        @if (session()->has('success'))
            <span class="bg-blue-200 text-blue-900 rounded-md block text-lg">{{ session()->get('success') }}</span>
        @endif

        <div class="flex flex-col md:flex-row justify-between items-center mb-4 gap-4">
            <a href="{{ route('registrarUsuario', ['create']) }}"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded text-lg">
                New user
            </a>

            <!-- Filtros de ordenación y búsqueda -->
            <form action="{{ route('catalogo_empleados') }}" method="GET" class="flex flex-wrap gap-4 w-full md:w-auto">
                @csrf
                <input type="text" name="search" id="search" placeholder="Search by ID or name..."
                    class="bg-gray-700 border-none rounded p-3 text-lg w-60"
                    value="{{ request('search') }}">
                
                <select name="sort_by" id="sort_by" class="bg-gray-700 border-none rounded p-3 text-lg w-60">
                    <option value="antiguedad" {{ request('sort_by') == 'antiguedad' ? 'selected' : '' }}>Antigüedad</option>
                    <option value="id" {{ request('sort_by') == 'dias_vacaciones' ? 'selected' : '' }}>ID</option>
                </select>
                <select name="order" id="order" class="bg-gray-700 border-none rounded p-3 text-lg w-60">
                    <option value="asc" {{ request('order') == 'asc' ? 'selected' : '' }}>Menor a Mayor</option>
                    <option value="desc" {{ request('order') == 'desc' ? 'selected' : '' }}>Mayor a Menor</option>
                </select>
                <button type="submit"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded text-lg">
                    Filtrar
                </button>
            </form>
        </div>

        {{-- Tabla de usuarios --}}
        <div class="grid grid-cols-5 gap-4 p-4 text-lg">
            <div class="font-bold">ID</div>
            <div class="font-bold">Name</div>
            <div class="font-bold">E-mail</div>
            <div class="font-bold">Antigüedad</div>
            <div class="font-bold">Action</div>
        </div>
        <div class="flex flex-col">
            @foreach ($users as $key => $user)
                <div class="grid grid-cols-5 gap-4 p-4 bg-gray-{{ $key % 2 == 0 ? '700' : '800' }} text-lg">
                    <div>{{ $user->id }}</div>
                    <div class="font-bold">{{ $user->name }}</div>
                    <div>{{ $user->email }}</div>
                    <div>{{ $user->datosEmpleado->antiguedad ?? 'N/A' }}</div>
                    <div class="flex flex-wrap gap-2 justify-center">
                        @if (!empty($user->deleted_at) or empty($user->email_verified_at))
                            <form action="{{-- route('activate.user') --}}" method="post">
                                @csrf
                                <input type="hidden" name="id_user" value="{{ $user->id }}">
                                <input type="hidden" name="current_group_id" value="{{ $user->current_group_id }}">
                                <button
                                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-lg">
                                    Activate
                                </button>
                            </form>
                        @else
                            <form action="{{-- route('cancel.user') --}}" method="post">
                                @csrf
                                <input type="hidden" name="id_user" value="{{ $user->id }}">
                                <button
                                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded text-lg">
                                    Deactivate
                                </button>
                            </form>
                        @endif
                        <a href="{{ route('registrarUsuario', [$user->id]) }}"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-lg">
                            Edit
                        </a>
                        <a href="{{-- route('details.user', ['id' => $user->id]) --}}"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-lg">
                            Details
                        </a>
                        {{-- <a href="route('password.user', ['id' => $user->id])"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-lg">
                            Password
                        </a> --}}
                        {{-- <a href="route('clone.user', ['id' => $user->id])"
                            {{--class="bg-purple-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-lg">
                            Clone This User
                        </a> --}}
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-4 text-lg">
            {{ $users->withQueryString()->links() }}
        </div>
    </div>
@endsection
</x-app-layout>
