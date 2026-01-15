<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Suivi IUT Villetaneuse') }}</title>
    <link href="{{asset('bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <script type="text/javascript" src="{{asset('bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <link href="{{asset('style.css')}}" rel="stylesheet" type="text/css">
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
</head>
<body>
<header class="mb-5">
    <x-nav></x-nav>
    @yield('alert')

    {{--Bannière bleue--}}
<div class="page-header">
    <div class="container d-flex flex-row-reverse align-items-center justify-content-between">
        <img src="{{ asset('276.png') }}" alt="Logo Sorbonne" style="height: 120px; width: auto; margin-left: 20px;">
        <div>
            @yield('header')
        </div>
    </div>
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

<script>

    // TODO à voir pour ne pas pouvoir sortir des modals sans faire exprès en rechargeant la page par exemple
    // TODO ce serait bien aussi d'ajouter l'avertissement quand on clique sur la croix ou "annuler" MAIS PAS POUR "VALIDER" COMME CE CODE LE FAIT ACTUELLEMENT
    // const buttonsWithErasureAlert = document.querySelectorAll('.erasure-alert');
    // console.debug(buttonsWithErasureAlert)
    // Pour tous les boutons avec la classe d'alerte d'effacement, activer l'alerte avant de décharger la page lorsque cliqué
    // buttonsWithErasureAlert.forEach((button) => {
    //     console.debug(button);
    //     button.addEventListener('click', () => {
    //         window.onbeforeunload = function(){
    //             return 'Êtes-vous sûr de partir ? Si vous déchargez la page, vos modifications seront perdues !';
    //         };
    //     })
    // });
    // for (const button in buttonsWithErasureAlert) {
    //     console.debug(button);
    //     button.addEventListener('click', () => {
    //         window.onbeforeunload = function(){
    //             return 'Êtes-vous sûr de partir ? Si vous déchargez la page, vos modifications seront perdues !';
    //         };
    //     })
    // }
    //
    // // Désactiver le message d'avertissement du déchargement de la page à la fermeture des modals (event bootstrap)
    // document.addEventListener('hidden.bs.modal', () => {
    //     window.onbeforeunload = function(){
    //         return 'Êtes-vous sûr de partir ? Si vous déchargez la page, vos modifications seront perdues !';
    //     };
    //     console.debug('test');
    //     window.onbeforeunload = null;
    // });

</script>
</html>
