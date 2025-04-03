<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SCV-TMNAV') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="{{asset('css/fontgoogle.css')}}">

    <!-- Scripts -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    {{-- <script src="{{ asset('js/jquery-3.7.0.js') }}"></script> --}}
    <script src="{{ asset('js/jquery-3.6.4.min.js') }}"></script>
    {{-- select --}}
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('js/select2.min.js') }}"></script>
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
</head>

<body>
    <div class="font-sans text-gray-900 antialiased">
        <div class=" bg-gray-800 flex flex-row text-white">
            {{-- Menu --}}
            <div id="search_menu"
                class="
                fixed top-10 -left-52 h-h_90 w-52 p-2 z-50
                flex flex-col justify-center items-center
                rounded-b bg-gray-700 
                md:sticky md:h-screen md:w-56 md:top-0 md:left-0  
                transition-all duration-1000 ease-in-out
            ">
                <div class="w-full mt-4 my-10 grid justify-center items-center">
                    <p class="mb-4 block text-center">Hola, {{ Auth::user()->name }} !</p>
                    {{-- <p class="mb-4 block text-center p-2 bg-gray-500 rounded">Auth::user()->currentGroup->name</p> --}}
                    <a class="grid justify-center" href="{{-- route('home') --}}">
                        <img class="block" src="{{ asset('/img/logo.webp') }}" alt="Transporte Multimodal">
                    </a>
                    <p class="text-center" id="local-time"></p>
                </div>
                <nav class="overflow-auto overflow-x-hidden">

                    <ul class="grid grid-cols-1 gap-2 relative"> {{-- Ul Principal --}}
                        <li class=" relative">
                            <a class="flex flex-row justify-start items-center hover:bg-gray-800 rounded-sm p-2
                                    gap-2 m-2" href="{{ route('dashboard') }}">
                                <img id="arrow_img" class=" w-8 h-8" src="{{ asset('/img/svg/home.svg') }}">
                                <p class="w-full text-center">Home</p>
                            </a>
                        </li>
                        <li>
                            <a class="flex flex-row justify-start items-center hover:bg-gray-800 rounded-sm p-2 gap-2 m-2"
                                href="{{ route('vistaPerfil') }}">
                                <img class=" w-8 h-8" src="{{ asset('/img/svg/reading_ebook.svg') }}">
                                <p class="w-full text-center">Mi Perfil</p>
                            </a>
                        </li>
                        <li>
                            <a class="flex flex-row justify-start items-center hover:bg-gray-800 rounded-sm p-2 gap-2 m-2"
                                href="{{ route('catalogo_empleados') }}">
                                <img class=" w-8 h-8" src="{{ asset('/img/svg/conference_call.svg') }}">
                                <p class="w-full text-center">Usuarios</p>
                            </a>
                        </li>

                        <li>
                            <a class="flex flex-row justify-start items-center hover:bg-gray-800 rounded-sm p-2 gap-2 m-2"
                                href="{{ route('vistaSolicitudVacaciones') }}">
                                <img class=" w-8 h-8" src="{{ asset('/img/svg/rules.svg') }}">
                                <p class="w-full text-center">Solicitar</p>
                            </a>
                        </li>

                        <li>
                            <a class="flex flex-row justify-start items-center hover:bg-gray-800 rounded-sm p-2 gap-2 m-2"
                                href="{{ route('alimentarSistema') }}">
                                <img class=" w-8 h-8" src="{{ asset('/img/svg/add_database.svg') }}">
                                <p class="w-full text-center">Alimentar Sistema</p>
                            </a>
                        </li>

                        <li>
                            <a class="flex flex-row justify-start items-center hover:bg-gray-800 rounded-sm p-2 gap-2 m-2"
                                href="{{ route('aprobarVacaciones') }}">
                                <img class=" w-8 h-8" src="{{ asset('/img/svg/approval.svg') }}">
                                <p class="w-full text-center">Autorizar </p>
                            </a>
                        </li>
                        <ul class="grid grid-cols-1 gap-2 relative">
                            <li>
                                <a class="flex flex-row justify-start items-center hover:bg-gray-800 rounded-sm p-2 gap-2 m-2"
                                    href="{{ route('departamentos.index') }}">
                                    <img class=" w-8 h-8" src="{{ asset('/img/svg/department.svg') }}">
                                    <p class="w-full text-center">Departamentos</p>
                                </a>
                            </li>
                        </ul>
                        <li>
                            <a class="flex flex-row justify-start items-center hover:bg-gray-800 rounded-sm p-2 gap-2 m-2"
                                href="{{ route('tickets.index') }}">
                                <img class=" w-8 h-8" src="{{ asset('/img/svg/ticket.svg') }}">
                                <p class="w-full text-center">Sistema de Tickets</p>
                            </a>
                        </li>

                    </ul> {{-- End Ul Principal --}}
                </nav>
            </div>
            <div class="hamburger-menu">
                <span></span>
                <span></span>
                <span></span>
            </div>

            <div class="min-h-h_90 w-screen ">
                <div class="flex justify-end items-center h-10 bg-gray-700">
                    {{-- LogOut --}}
                    <form method="POST" action="{{ route('logout') }}" x-data>
                        @csrf

                        <x-responsive-nav-link title="Log Out" href="{{ route('logout') }}"
                            @click.prevent="$root.submit();">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z" />
                                <path fill-rule="evenodd"
                                    d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z" />
                            </svg>
                        </x-responsive-nav-link>
                    </form>
                    {{-- End LogOut --}}
                </div>

                <div class="px-6">
                    {{-- Contenido --}}
                    @yield('content')
                </div>
                


        </div>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/horaMain.js') }}"></script>
</body>

</html>
