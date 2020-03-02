    <!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel cms') }}</title>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.0.1/dist/alpine.js" defer></script>

    <!-- Styles -->
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <script src="{{ mix('app.js','vendor/cms') }}" defer></script>
    <link href='{{mix('app.css', 'vendor/cms')}}' rel='stylesheet' type='text/css'>
</head>
<body>
@inertia
</body>
</html>
