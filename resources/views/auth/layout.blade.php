<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel cms') }}</title>

    <!-- Styles -->
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <link href='{{asset('vendor/cms/app.css')}}' rel='stylesheet' type='text/css'>
</head>
<body>
<div id="app">
    <main>
        @yield('content')
    </main>
</div>
</body>
</html>
