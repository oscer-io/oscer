<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel cms') }}</title>

    <script>window.locale = '{{app()->getLocale()}}'</script>
    <!-- Styles -->
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <link href='{{asset('vendor/cms/app.css')}}' rel='stylesheet' type='text/css'>
</head>
<body class="min-w-site bg-40 text-black min-h-full">
<div id="cms"></div>
<script src="{{ mix('app.js', 'vendor/cms') }}"></script>
<script>
    window.Cms = new CreateCms(@json($json))
</script>
<script>
    Cms.start()
</script>
</body>
</html>
