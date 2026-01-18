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

        const clickables = document.querySelectorAll('.btn-load-modal');
        const modalContainer = document.getElementById('modal-container');

        // Partie Chargement du modal (GET) - Inchangé, ça fonctionne bien
        clickables.forEach(button => {
            button.addEventListener('click', function (event) {
                if (event.target !== button && event.target.nodeName === "BUTTON") return;
                const url = this.getAttribute('data-url');
                fetch(url)
                    .then(response => response.text())
                    .then(html => {
                        modalContainer.innerHTML = html;
                        const modalElement = modalContainer.querySelector('.modal');
                        const myModal = new bootstrap.Modal(modalElement);
                        myModal.show();
                    })
                    .catch(error => console.error('Erreur:', error));
            });
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

</script>
</html>
