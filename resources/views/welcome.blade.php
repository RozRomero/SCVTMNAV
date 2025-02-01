<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'SCV-TMNAV') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="{{asset('css/fontgoogle.css')}}">

        <!-- Scripts -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    </head>
    <body>
        <div class="relative flex items-top justify-center min-h-screen bg-gray-800 sm:items-center py-4 sm:pt-0">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <h1 class="font-bold text-4xl text-white">SISTEMA DE ADMINISTRACI&Oacute;N</h1>
                @if (Route::has('login'))
                    <div class="block px-6 py-4 mx-auto w-fit">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-sm text-white p-2 rounded bg-gray-600">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm text-white p-2 rounded bg-gray-600">Log in</a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="ml-4 text-sm text-white p-2 rounded bg-gray-600">Register</a>
                            @endif
                        @endauth
                    </div>
                @endif
            </div>
        </div>
    </body>
</html>
