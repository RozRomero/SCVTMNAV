<x-app-layout>
    @section('content')
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Upload Users') }}
            </h2>
        </x-slot>
    
        <div class="max-w-7xl mx-auto my-4 sm:px-6 lg:px-8">
    
            @if (session()->has('success'))
                <p class="w-fit p-4 my-2 mx-auto bg-green-200 text-green-900 rounded-md block">{{ session()->get('success') }}</p>
            @endif
    
            <div class="bg-indigo-600 overflow-hidden shadow-xl sm:rounded-lg">
                <form action="{{ route('crearUsuario') }}" method="post" class="grid gap-6 mb-6 md:grid-cols-1 text-center">
                    @csrf
    
                    @if(isset($method) && $method == 'clone')
                        <h1 class="text-center text-xl font-bold pt-6 uppercase">Clone User</h1>
                        <input type="hidden" name="id_user" value="{{$user->id}}">
                        <input type="hidden" name="method" value="{{$method}}">
                    @elseif(!empty($user))
                        <h1 class="text-center text-xl font-bold pt-6 uppercase">Edit user</h1>
                        <input type="hidden" name="id_user" value="{{$user->id}}">
                    @else
                        <h1 class="text-center text-xl font-bold pt-6 uppercase">Register new user</h1>
                    @endif
    
                    <div>
                        <label for="name" class="block">Nombre</label>
                        <input type="text" name="name" onkeyup="this.value = this.value.toUpperCase();" class="bg-gray-700 border-none rounded p-4 w-full sm:w-80"
                            value="{{ old('name', $user->name ?? '') }}" required>
                        @error('name')
                            <p class="bg-red-200 text-red-900 rounded-md w-fit mx-auto block sm:w-80 p-2">{{ $message }}</p>
                        @enderror
                    </div>
    
                    <div>
                        <label for="email" class="block">Email</label>
                        <input type="email" name="email" class="bg-gray-700 border-none rounded p-4 w-full sm:w-80"
                            value="{{ old('email', $user->email ?? '') }}" required>
                        @error('email')
                            <p class="bg-red-200 text-red-900 rounded-md block w-fit mx-auto p-2">{{ $message }}</p>
                        @enderror
                    </div>
    
                    @if(empty($user) || $method == 'clone')
                        <div>
                            <label for="password" class="block">Password</label>
                            <input type="password" name="password" class="bg-gray-700 border-none rounded p-4 w-full sm:w-80" required>
                            @error('password')
                                <p class="bg-red-200 text-red-900 rounded-md block w-fit mx-auto p-2">{{ $message }}</p>
                            @enderror
                        </div>
    
                        <div>
                            <label for="password_confirmation" class="block">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="bg-gray-700 border-none rounded p-4 w-full sm:w-80" required>
                            @error('password_confirmation')
                                <p class="bg-red-200 text-red-900 rounded-md block w-fit mx-auto p-2">{{ $message }}</p>
                            @enderror
                        </div>
                    @endif
    
                    <div>
                        <label for="department" class="block">Department</label>
                        <select name="department" id="department" class="js-example-basic-single bg-gray-700 border-none rounded p-4 w-full sm:w-80 textoSel" required>
                            <option value=""></option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}"
                                    @if ($user && $user->department_id == $department->id) selected @endif>
                                    {{ $department->nombre_departamento }}
                                </option>
                            @endforeach
                        </select>
                    </div>
    
                    <div>
                        <label for="role" class="block">Role</label>
                        <select name="role" class="bg-gray-700 border-none rounded p-4 w-full sm:w-80" required>
                            <option value=""></option>
                            @foreach(Auth::user()->allRoles() as $role)
                                <option value="{{ $role->id }}"
                                    {{ (isset($user) && $user->roles[0]->id ?? '' == $role->id) || old('role') == $role->id ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
    
                    <div>
                        <x-button-submit class="capitalize rounded-lg border-none bg-blue-600 hover:bg-blue-800 cursor-pointer text-center w-fit p-3">
                            @if(empty($user))
                                Register new user
                            @else
                                Update
                            @endif
                        </x-button-submit>
                    </div>
    
                    <!-- 🔙 Botón BACK -->
                    <div>
                        <a href="{{ url()->previous() }}" class="capitalize rounded-lg border-none bg-blue-600 hover:bg-blue-800 text-white text-center w-fit p-3 inline-block">
                            Back
                        </a>
                    </div>
                </form>
            </div>
        </div>
    @endsection
    </x-app-layout>
    