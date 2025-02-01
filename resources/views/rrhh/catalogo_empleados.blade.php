<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Settings Users') }}
        </h2>
    </x-slot>
    <h2 class="text-center text-xl font-bold p-6 uppercase">Users</h2>

    {{--  Listado de Usuarios --}}
    <div class="p-6 rounded-sm shadow-lg m-2 mb-4 bg-gray-600 text-white w-fit mx-auto">
        @if (session()->has('success'))
            <span class="bg-blue-200 text-blue-900 rounded-md block">{{ session()->get('success') }}</span>
        @endif

        <div class="grid grid-cols-2">
            <a href="{{ route('registrarUsuario', ['create']) }}"
                class="w-fit h-fit m-auto bg-green-500 hover:bg-green-700 text-white font-bold align-middle text-center py-2 px-4 rounded">New user</a>
    
            <form class="flex flex-row gap-4 my-4" method="POST">
                @csrf
                <input type="text" name="nombre" class="bg-gray-700 border-none rounded p-4 w-full sm:w-80"
                    placeholder="Nombre">
                <button type="submit"
                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Search</button>
            </form>
        </div>
        {{-- @endrole --}}
        <div class="grid grid-cols-3 gap-4 p-4">
            <div class="font-bold text-lg">Name</div>
            <div class="font-bold text-lg">E-mail</div>
            <div class="font-bold text-lg">Action</div>
        </div>
        <div class="flex flex-col">
            <input type="hidden" name="id" value="">
            @foreach ($users as $key => $user)
                {{-- @role('SUPER ADMIN|ADMIN') --}}
                <div class="grid grid-cols-3 gap-4 p-4 bg-gray-{{ $key % 2 == 0 ? '700' : '800' }}">
                    <div class="font-bold text-lg mb-2">{{ $user->name }}</div>
                    <div>{{ $user->email }}</div>
                    <div class="grid grid-cols-2 gap-2">
                        <a href="{{ route('registrarUsuario', [$user->id]) }}"
                            class=" text-center w-full h-fit bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Edit
                        </a>
                        <a href="{{-- route('password.user', ['id' => $user->id]) --}}"
                            class="text-center w-full h-fit bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Password
                        </a>
                        {{-- <a href="{{ route('user.permission', ['id' => $user->id]) }}"
                                    class="text-center w-full h-fit bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Permissions
                                </a> --}}
                        <a href="{{-- route('registrarUsuario', [$user->id, 'method' => "clone"]) --}} "
                            class="text-center w-full h-fit bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                            Clone This User
                        </a>
                        @if (!empty($user->deleted_at) or empty($user->email_verified_at))
                            <form action="{{-- route('activate.user') --}}" method="post">
                                @csrf
                                <input type="hidden" name="id_user" value="{{ $user->id }}">
                                <input type="hidden" name="current_group_id" value="{{ $user->current_group_id }}">
                                <button
                                    class="text-center w-full bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                    Activate
                                </button>
                            </form>
                        @else
                            <form action="{{-- route('cancel.user') --}}" method="post">
                                @csrf
                                <input type="hidden" name="id_user" value="{{ $user->id }}">
                                <button
                                    class="text-center w-full bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                    Cancel
                                </button>
                            </form>
                        @endif

                    </div>

                </div>

                {{-- @endrole --}}
            @endforeach
        </div>
        <div class="mt-2">
            {{ $users->withQueryString()->links() }}
        </div>
    </div>
</x-app-layout>
