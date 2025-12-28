<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suivi colis IUTV</title>
    {{-- TODO retirer ça --}}
     {{-- @yield('css') --}}
     {{-- Autre solution, utiliser notre propre CSS --}}
    {{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> --}}
    {{-- Autre solution, installer tailwind sans nodejs : https://tailwindcss.com/blog/standalone-cli --}}

    {{-- Autre solution : utiliser le CDN de tailwind mais pas recommandé pour la production :/ --}}

    {{-- <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style type="text/tailwindcss">
      @theme {
        --color-clifford: #da373d;
      }    
    </style> --}}

    {{-- Bootstrap installé localement avec jquery et popper (intégré à bootstrap.bundle.min.js) nécéssaires pour bootstrap --}}

    {{-- Pour charger la feuille de style bootstrap --}}
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    

    {{-- Pour charger les scripts jquery, nécéssaire à boostrap - c'était nécéssaire avec bootstrap 4 mais plus avec boostrap 5--}}
    {{-- <script type="text/javascript" src="jquery/jquery.min.js"></script> --}}

    {{-- Pour charger jquery popper et bootstrap en même temps, tout est nécéssaire à boostrap --}}
    <script type="text/javascript" src="bootstrap/js/bootstrap.bundle.min.js"></script>

    {{--  Pour charger les scripts boostrap - c'était nécéssaire avec bootstrap 4 mais plus avec boostrap 5--}}
    {{-- <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script> --}}
    
</head>
<body>
<header>
  <x-nav></x-nav>
</header>
<main>
    @yield('content')
</main>
<footer></footer>
</body>
</html>