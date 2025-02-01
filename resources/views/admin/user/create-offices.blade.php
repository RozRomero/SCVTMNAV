<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin ') }}{{ $name }}s
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-600 overflow-hidden shadow-xl sm:rounded-lg">
                <form method="post"
                    @if ($name == 'Office')
                        action="{{ route('createsave.office') }}"
                    @elseif($name == 'Role')
                        action="{{ route('createsave.role') }}"
                    @elseif($name == 'Permission')
                        action="{{ route('createsave.permission') }}"
                    @elseif($name == 'Group')
                        action="{{ route('createsave.team') }}"
                    @endif
                    class="grid gap-6 mb-6 md:grid-cols-1 text-center"
                >

                    @if (session()->has('success'))
                        <span class="bg-blue-200 text-blue-900 rounded-md block">{{ session()->get('success') }}</span>
                    @endif

                    @if (!empty($data))
                        <h1 class="text-lg">Edit {{ $name }}</h1>
                        <input type="hidden" name="id" value="{{ $id }}">
                    @else
                        <h1 class="text-lg">Register {{ $name }}</h1>
                    @endif
                    <hr>
                    @csrf
                    <div>
                        <label for="name" class="block">Name</label>
                        <input type="text" name="name" id=""
                            class=" bg-gray-700 border-none rounded p-4 w-full sm:w-80"
                            @if (!empty($data)) value="{{ $data }}"@else value="{{ old('name') }}" @endif>
                        @if ($errors->has('name'))
                            <span class="bg-red-200 text-red-900 rounded-md w-full sm:w-80">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                    @if ($name == 'Role')
                        <div>
                            <label for="cloneFrom" class="block">Clone From</label>
                            <select name="cloneFrom" id="cloneFrom" class="bg-gray-700 border-none rounded p-4 w-full sm:w-80">
                                <option value=""></option>
                                @foreach (Auth::user()->allRoles() as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    <div>
                        <x-button-submit color="blue">
                            @if (empty($data))
                                Register new {{ $name }}
                            @else
                                Update
                            @endif

                        </x-button-submit>
                        @if ($name == 'Office')
                            <a href="{{ route('settings.office') }}"
                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded'">Back</a>
                        @elseif($name == 'Role')
                            <a href="{{ route('settings.role') }}"
                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded'">Back</a>
                        @elseif($name == 'Permission')
                            <a href="{{ route('settings.permission') }}"
                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded'">Back</a>
                        @elseif($name == 'Group')
                            <a href="{{ route('settings.team') }}"
                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded'">Back</a>
                        @endif
                    </div>

                </form>


            </div>
        </div>
    </div>
</x-app-layout>
