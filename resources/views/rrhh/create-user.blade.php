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

            <div class="bg-gray-600 overflow-hidden shadow-xl sm:rounded-lg">
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
                    {{-- <hr> --}}
                    
                    <div>
                        <label for="name" class="block">Nombre</label>
                        <input type="text" name="name" onkeyup="this.value = this.value.toUpperCase();" id="" class="bg-gray-700 border-none rounded p-4 w-full sm:w-80" @if (!empty($user)) value="{{$user->name}}"@else value="{{old('name')}}" @endif required>
                        @if ($errors->has('name'))
                            <p class="bg-red-200 text-red-900 rounded-md w-fit mx-auto block sm:w-80 p-2">{{ $errors->first('name') }}</p>
                        @endif
                    </div>

                    <div>
                        <label for="email" class="block">Email</label>
                        <input type="email" name="email" id="" class="bg-gray-700 border-none rounded p-4 w-full sm:w-80" @if (!empty($user)) value='{{$user->email}}'@else value="{{old('email')}}" @endif required>
                        @if ($errors->has('email'))
                            <p class="bg-red-200 text-red-900 rounded-md block w-fit mx-auto p-2">{{ $errors->first('email') }}</p>
                        @endif
                    </div>
                    @if(empty($user) || $method == 'clone')
                        <div>
                            <label for="password" class="block">Password</label>
                            <input type="password" name="password" id="" class="bg-gray-700 border-none rounded p-4 w-full sm:w-80" required>
                            @if ($errors->has('password'))
                                <p class="bg-red-200 text-red-900 rounded-md block w-fit mx-auto p-2">{{ $errors->first('password') }}</p>
                            @endif
                        </div>
                        <div>
                            <label for="password_confirmation" class="block">Confirm Password</label>
                            <input type="password" name="password_confirmation" id="" class="bg-gray-700 border-none rounded p-4 w-full sm:w-80" required>
                            @if ($errors->has('password_confirmation'))
                                <p class="bg-red-200 text-red-900 rounded-md block w-fit mx-auto p-2">{{ $errors->first('password_confirmation') }}</p>
                            @endif
                        </div>
                    @endif

                    <div>
                        <label for="department" class="block">Department</label>
                        <select name="department" id="department" class="js-example-basic-single bg-gray-700 border-none rounded p-4 w-full sm:w-80 textoSel" required>
                            <option value=""></option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}" 
                                    @if ($user && $user->department_id == $department->id)
                                        selected
                                    @endif    
                                >{{ $department->nombre_departamento }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="role" class="block">Role</label>
                        <select name="role" id="" class="bg-gray-700 border-none rounded p-4 w-full sm:w-80" required>
                            <option value=""></option>
                            @foreach(Auth::user()->allRoles() as $role)
                                @if(empty($user))
                                    <option value="{{$role->id}}" {{ old('role') == $role->id ? 'selected' : ''}}>{{$role->name}}</option>
                                @else
                                    @if($user->roles[0]->id ?? 0 == $role->id)
                                        <option value="{{$role->id}}" selected>{{$role->name}}</option>
                                    @else
                                        <option value="{{$role->id}}">{{$role->name}}</option>
                                    @endif
                                
                                @endif
                            @endforeach
                        </select>
                    </div>


                    <div>
                        <x-button-submit class="capitalize rounded-lg border-none bg-green-600 hover:bg-green-800 cursor-pointer text-center w-fit p-3">
                            @if(empty($user))

                                Register new user
                            @else

                                Update

                            @endif
                            
                        </x-button-submit>
                    </div>
                </form>
            </div>
        </div>
@endsection
</x-app-layout>
