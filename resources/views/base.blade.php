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
</footer>
</body>
</html>
