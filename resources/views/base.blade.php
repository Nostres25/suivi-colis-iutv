<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suivi colis IUTV</title>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script type="text/javascript" src="bootstrap/js/bootstrap.bundle.min.js"></script>
    {{-- <script src="../ressources/js/app.js"></script> --}}
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
<style>
  /* Correction d'un bug visuel Bootstrap 5.3.8 qui décale la page en fond lors de l'ouverture d'un modal sur petits écrans (mobile) */
  .modal-open {
    padding-right: 0 !important;
  }

  html {
    overflow-y: scroll !important;
  }
</style>
</html>