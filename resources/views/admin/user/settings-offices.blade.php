<x-app-layout>
    @section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Settings') }} {{ $name }}s
        </h2>
    </x-slot>

    <div class="grid grid-cols-1">
        <div class="flex justify-center text-center">
            @if (session()->has('success'))
                <span class="bg-blue-200 text-blue-900 rounded-md block py-4 w-1/4 ">{{ session()->get('success') }}</span>
            @endif
            @if (session()->has('error'))
                <span class="bg-red-200 text-red-900 rounded-md block py-4 w-1/4 ">{{ session()->get('error') }}</span>
            @endif
        </div>
        {{-- Teams --}}
        <h2 class="text-center text-xl font-bold p-6 uppercase">{{ $name }}s</h2>

        <div class="p-6 rounded-sm shadow-lg m-2 mb-4 bg-gray-600 text-white w-fit mx-auto">
            
            @if ($name == 'Office')
                <a href="{{ route('create.office', ['id' => 'create']) }}"
                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">New
                    {{ $name }}</a>
            @elseif($name == 'Role')
                <a href="{{ route('create.role', ['id' => 'create']) }}"
                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">New
                    {{ $name }}</a>
            @elseif($name == 'Permission')
                <a href="{{ route('create.permission', ['id' => 'create']) }}"
                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">New
                    {{ $name }}</a>
            @elseif($name == 'Group')
                <a href="{{ route('create.team', ['id' => 'create']) }}"
                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">New
                    {{ $name }}</a>
            @endif

            <div class="grid grid-cols-3 gap-4 p-6">
                <div class="font-bold text-lg">Id</div>
                <div class="font-bold text-lg">Name</div>
                <div class="font-bold text-lg">Action</div>
            </div>
            <div class="flex flex-col">
                @foreach ($data as $key => $dat)
                    <div class="grid grid-cols-3 gap-4 p-6 bg-gray-{{ $key % 2 == 0 ? "700" : "800" }}">
                        <div class="font-bold text-lg mb-2">{{ $dat->id }}</div>
                        <div>{{ $dat->name }}</div>
                        <div>
                            @if ($name == 'Office')
                                <a href="{{ route('create.office', ['id' => $dat->id]) }}"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Edit</a>
                            @elseif($name == 'Role')
                                <a href="{{ route('create.role', ['id' => $dat->id]) }}"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Edit</a>
                                <a href="{{ route('roleper', ['id' => $dat->id]) }}"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"> Assign
                                    permissions</a>
                            @elseif($name == 'Permission')
                                <a href="{{ route('create.permission', ['id' => $dat->id]) }}"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Edit</a>
                            @elseif($name == 'Team')
                                <a href="{{ route('create.team', ['id' => $dat->id]) }}"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Edit</a>
                            @elseif($name == 'Group')
                                <form action="{{ route('activate.team') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="idGroup" value="{{ $dat->id }}">
                                    <input type="hidden" name="flag" value="{{ $dat->flag_tracker }}">
                                    @if ($dat->flag_tracker == 0)
                                        <button
                                            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                            Activate</button>
                                    @else
                                        <button
                                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                            Cancel</button>
                                    @endif
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div>
@endsection
</x-app-layout>
