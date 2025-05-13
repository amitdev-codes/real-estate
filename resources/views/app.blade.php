<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light scroll-smooth" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title inertia>{{ config('app.name', 'Dream Estate') }}</title>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAvCXIIlgap1yb6TgS_pT2BK_4plxo49fA&libraries=places"></script>

    {{-- links and scripts are loaded from individual layouts --}}
    @stack('head')

    @routes

    @vite(['resources/js/app.js', "resources/js/{$page['component']}.vue"])
    @inertiaHead

    <script>
        window.App = {
            url: "{{ config('app.url') }}"
        };
    </script>

</head>

<body class="dark:bg-slate-900">
    @inertia
</body>

</html>
