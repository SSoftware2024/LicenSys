<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laravel</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @vite(["resources/js/Pages/{$page['component']}.vue"])
    @inertiaHead
    @routes
</head>
<body>
    @inertia
</body>
</html>
