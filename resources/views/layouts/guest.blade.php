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
        {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    </head>
    <body>
        <div class="font-sans text-gray-900 antialiased">
            {{ $slot }}
        </div>

        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
