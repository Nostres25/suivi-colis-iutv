<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Suivi IUT Villetaneuse') }}</title>
    <link href="{{asset('bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <script type="text/javascript" src="{{asset('bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <link href="{{asset('style.css')}}" rel="stylesheet" type="text/css">
</head>
<body>
<header class="mb-5">
    <x-nav></x-nav>
    <x-alert></x-alert>

    {{--Bannière bleue--}}
    <div class="page-header">
        @yield('header')
    </div>
</header>
<main>
    @yield('content')
</main>
<footer>
    @yield('footer')
    <div class="bg-gray-50 px-8 py-5 text-center border-t">
        <p class="text-sm font-semibold text-gray-700">BUT2 Informatique - IUT de Villetaneuse</p>
        <p class="text-xs text-gray-500 mt-1">Projet SAE - Suivi de Colis • 2024-2025</p>
    </div>
{{--    <div class="min-h-screen bg-gray-50 py-8">--}}
{{--        <div class="mx-auto max-w-5xl">--}}

{{--            <div class="bg-white shadow-lg rounded-xl overflow-hidden">--}}

{{--                <Ancien contrenu footer>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
</footer>
</body>
</html>
