<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Oscer - Default Theme</title>

</head>
<body>
<x-menu location="main"/>
@yield('content')
<x-menu location="footer"/>
</body>
</html>
