<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/scss/app.scss', 'resources/js/app.js'])
    </head>
    <body class="bg-secondary bg-opacity-25">
        <div class="min-vh-100 d-flex align-items-center flex-column justify-content-center">
            <div>
                <a href="/">
                    <x-application-logo class="text-secondary" width="5rem" style="fill: currentColor;" />
                </a>
            </div>

            {{ $slot }}
        </div>
    </body>
</html>
