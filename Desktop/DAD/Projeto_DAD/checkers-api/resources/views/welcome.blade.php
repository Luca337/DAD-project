<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Esta linha liga o Laravel aos teus ficheiros Vue/CSS -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased">
        <!-- É dentro desta div que a tua aplicação Vue vai aparecer -->
        <div id="app"></div>
    </body>
</html>