<x-app-layout>
    @section('content')
    <x-slot name="header">

    </x-slot>
    
    <div class="py-12 text-center">
        <a href="{{route('settings.role')}}" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Back</a>
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Permissions of  ') }} {{ $roles->name }}
        </h2>
        <form id="form_perms" method="post"
            class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid lg:grid-cols-3 gap-2 sm:grid-cols-1 md:grid-cols-2">

            @php
                $div = true;
                $tmpTitulo = '';
            @endphp

            <input type="hidden" name="idUser" value="{{ $roles->id }}">
            @csrf
            @foreach ($permissions as $permission)
                @php
                    $titulo = substr($permission->name, 0, strpos($permission->name, '.'));
                    $tituloPerm = trim(substr($permission->name, strpos($permission->name, '.') + 1));
                    if ($tmpTitulo != $titulo) {
                        if ($div == false) {
                            echo '</div>';
                            $div = true;
                        }
                        echo "<div class='grid grid-cols-1 mx-2 my-2 py-2 px-2 bg-gray-600 rounded-lg gap-2 h-fit'><div class='text-center font-bold'>[$titulo]</div>";
                    }
                    $div = false;
                    
                    $tmpTitulo = $titulo;
                @endphp
                <div class="rounded-lg bg-gray-700 py-4 px-2 h-14">
                    @if (in_array($permission->id, $roleperm))
                        <input type="checkbox" name="permission[]" id="{{ $permission->id }}"
                            value="{{ $permission->id }}" checked><label for="permission"> {{ $tituloPerm }}</label>
                    @else
                        <input type="checkbox" name="permission[]" id="{{ $permission->id }}"
                            value="{{ $permission->id }}"><label for="permission"> {{ $tituloPerm }}</label>
                    @endif

                </div>
            @endforeach


        </form>
    </div>
    @endsection
</x-app-layout>
<script>
    const formPerms = document.querySelector('#form_perms')
    formPerms.addEventListener('click', obtenerDatos)
    window.CSRF_TOKEN = '{{ csrf_token() }}';
    //console.log(window.CSRF_TOKEN);
    function obtenerDatos(e) {
        if (e.target.id > 0) {
            console.log(e.target.checked);
            console.log(e.target.id);
            if (e.target.checked) {
                const url = "{{ route('addperm.role') }}";

                fetch(url, {
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json, text-plain, */*",
                            "X-Requested-With": "XMLHttpRequest",
                            "X-CSRF-TOKEN": window.CSRF_TOKEN
                        },
                        method: 'post',
                        credentials: "same-origin",
                        body: JSON.stringify({
                            rol: {{ $roles->id }},
                            perm: e.target.id,
                            
                        })
                    })
                    .then(response => {
                        return response.json();
                    }).then(text => {
                        //return console.log(text);
                    }).catch(error => console.error(error));
            } else {
                const url = "{{ route('removeperm.role') }}";
                fetch(url, {
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json, text-plain, */*",
                            "X-Requested-With": "XMLHttpRequest",
                            "X-CSRF-TOKEN": window.CSRF_TOKEN
                        },
                        method: 'post',
                        credentials: "same-origin",
                        body: JSON.stringify({
                            rol: {{ $roles->id }},
                            perm: e.target.id,
                            
                        })
                    })
                    .then(response => {
                        return response.json();
                    }).then(text => {
                        //return console.log(text);
                    }).catch(error => console.error(error));
            }
        }
    }
</script>
