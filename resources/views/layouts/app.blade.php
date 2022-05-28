<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name') }}</title>

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        {{-- Icons --}}
        <link rel="apple-touch-icon" href="{{url('192x192.png')}}" />
        <link rel="manifest" href="{{url('mix-manifest.json')}}" />

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
    </head>
    <body class="body--offwhite">
        {{-- <x-navigation /> --}}

        @yield('content')

    </body>
</html>
