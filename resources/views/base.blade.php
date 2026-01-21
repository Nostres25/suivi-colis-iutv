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
    <x-alert></x-alert>

    {{--Bannière bleue--}}
<div class="page-header">
    <div class="container d-flex flex-row-reverse align-items-center justify-content-between">
        <img src="{{ asset('217.png') }}" alt="Logo Sorbonne" style="height: 70px; width: auto; margin-left: 20px;">
        <div>
            @yield('header')
        </div>
    </div>
</div>
</header>
<main>
    @yield('content')
    <div id="modal-container"></div>
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
    {{--let modalToOpenId = '{{$modalToOpen}}';--}}
    {{--if (modalToOpenId) {--}}
    {{--    console.debug(modalToOpenId);--}}
    {{--    let modalToOpen = new bootstrap.Modal(document.getElementById(modalToOpenId));--}}
    {{--    modalToOpen.show();--}}
    {{--}--}}

    document.addEventListener('DOMContentLoaded', function () {

        const modalContainer = document.getElementById('modal-container');

        // ============================================================
        // 1. GESTION DE L'OUVERTURE (GET) - Via Délégation Globale
        // ============================================================
        // On écoute les clics sur TOUT le document (body)
        document.body.addEventListener('click', function (e) {

            // On cherche si l'élément cliqué (ou un de ses parents) est un bouton .btn-load-modal
            // .closest() est magique : il remonte l'arbre DOM jusqu'à trouver la classe
            const button = e.target.closest('.btn-load-modal');

            // Si on a trouvé un bouton et qu'il a un data-url
            if (button && button.getAttribute('data-url')) {
                e.preventDefault(); // Empêche le comportement par défaut (lien ou submit)

                const url = button.getAttribute('data-url');

                // --- NETTOYAGE (Important si on vient d'un autre modal) ---
                // Si un modal est déjà ouvert, on le détruit proprement avant de charger le suivant
                // Cela évite d'avoir des conflits de fond gris (backdrop)
                const existingModalEl = modalContainer.querySelector('.modal');
                if (existingModalEl) {
                    const existingInstance = bootstrap.Modal.getInstance(existingModalEl);
                    if (existingInstance) {
                        existingInstance.dispose();
                    }
                }
                // -----------------------------------------------------------

                fetch(url)
                    .then(response => response.text())
                    .then(html => {
                        modalContainer.innerHTML = html;

                        const modalElement = modalContainer.querySelector('.modal');
                        // Initialisation du nouveau modal
                        const myModal = new bootstrap.Modal(modalElement);
                        myModal.show();
                    })
                    .catch(error => console.error('Erreur chargement modal:', error));
            }
        });

        // GESTION DU POST (Formulaire)
        modalContainer.addEventListener('submit', function (e) {
            if (e.target && e.target.classList.contains('ajax-form')) {
                e.preventDefault();

                const form = e.target;
                const url = form.action;
                const formData = new FormData(form);

                const existingModalEl = modalContainer.querySelector('.modal');
                let existingInstance = null;
                if (existingModalEl) {
                    existingInstance = bootstrap.Modal.getInstance(existingModalEl);
                }

                fetch(url, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json, text/html' // On accepte les deux
                    }
                })
                    .then(response => {
                        // On regarde l'entête pour savoir si c'est du JSON ou du HTML
                        const contentType = response.headers.get("content-type");

                        if (contentType && contentType.indexOf("application/json") !== -1) {
                            // C'est du JSON (Succès)
                            return response.json().then(data => {
                                return { type: 'json', data: data };
                            });
                        } else {
                            // C'est du HTML (Erreur / Vue partielle)
                            return response.text().then(html => {
                                return { type: 'html', html: html };
                            });
                        }
                    })
                    .then(result => {
                        // CAS 1 : SUCCÈS (JSON) -> ON RECHARGE LA PAGE
                        if (result.type === 'json' && result.data.status === 'success') {
                            // Comme Laravel a mis un message en session()->flash(),
                            // il s'affichera au rechargement.
                            window.location.reload();
                            return;
                        }

                        // CAS 2 : ERREUR (HTML) -> ON RÉAFFICHE LE MODAL
                        if (result.type === 'html') {
                            const html = result.html;

                            // Sécurité anti page complète
                            if (html.includes('<html') || html.includes('<!DOCTYPE')) {
                                window.location.reload(); // Au cas où
                                return;
                            }

                            // Nettoyage de l'ancien modal
                            if (existingInstance) existingInstance.dispose();
                            document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
                            document.body.classList.remove('modal-open');

                            // Injection
                            modalContainer.innerHTML = html;

                            // Réouverture
                            const newModalEl = modalContainer.querySelector('.modal');
                            if (newModalEl) {
                                const newModal = new bootstrap.Modal(newModalEl);
                                newModal.show();
                            }
                        }
                    })
                    .catch(error => console.error('Erreur AJAX:', error));
            }
        });
    });


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
    document.addEventListener('hidden.bs.modal', () => {
        window.location.reload();
    });

    document.addEventListener('DOMContentLoaded', () => {
        const loginAlert = document.getElementById('login-alert');
        if (loginAlert) {
            setTimeout(() => {
            loginAlert.classList.add('d-none');
            }, 6000); // 6 sec
        }
        });


</script>
</html>
