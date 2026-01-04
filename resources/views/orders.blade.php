@extends('base')

@section('header')
    <div class="container">
        <h1 class="h1"><svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-box-seam-fill" preserveAspectRatio="xMidYMid meet" width="32" height="32" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M15.528 2.973a.75.75 0 0 1 .472.696v8.662a.75.75 0 0 1-.472.696l-7.25 2.9a.75.75 0 0 1-.557 0l-7.25-2.9A.75.75 0 0 1 0 12.331V3.669a.75.75 0 0 1 .471-.696L7.443.184l.01-.003.268-.108a.75.75 0 0 1 .558 0l.269.108.01.003zM10.404 2 4.25 4.461 1.846 3.5 1 3.839v.4l6.5 2.6v7.922l.5.2.5-.2V6.84l6.5-2.6v-.4l-.846-.339L8 5.961 5.596 5l6.154-2.461z"/>
            </svg> Mon Espace - Commandes</h1>
        <p class="mb-0 opacity-75">Liste et gestion des commandes</p>
    </div>
@endsection

@section('content')

<section>
    <div class="row justify-content-center">
        <div class="search-container flex-column flex-sm-row">
            <div class="search-wrapper">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search search-icon" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                </svg>
                <input type="text" class="form-control search-input" placeholder="Rechercher une commande...">
            </div>
            <button id="search-filter" class="btn btn-outline-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-funnel-fill" viewBox="0 0 16 16">
                    <path d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5z"/>
                </svg> Filtres
            </button>
        </div>
    </div>
</section>

{{-- TODO Remplir le tableau avec la base de données --}}
{{-- TODO Peut-être afficher un aperçu de ce qu'il y a dans la commande (colis) --}}
{{-- TODO format mobile : afficher les commandes comme la solution 1 ou 2 : https://www.behance.net/gallery/95240691/Responsive-Data-Table-Designs# --}}
<section class="table-section table-responsive">
    <x-orderCreationButton :orderStates="$orderStates" :defaultOrderState="$defaultOrderState"/>
    <div class="table-header mt-4">
        <h2 class="h3"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-list-ul" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M5 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m-3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2m0 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2m0 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2"/>
            </svg> Commandes</h2>
        <p>Devis et bons de commandes</p>
    </div>

    <table class="table table-striped mb-0">
        <caption>
            {{-- TODO Si c'est un département (ex: CRIT) : mettre "liste des commandes du département CRIT" --}}
            Liste des commandes à l'IUT de Villetaneuse
        </caption>
        <thead>
            <tr>
                {{-- TODO Pouvoir trier les différentes colonnes --}}
                {{-- TODO mettre les différentes explications sur les colonnes (quand on survole  avec la souris par exemple) --}}
                <th scope="col">N°</th>
                <th scope="col" class="d-none d-sm-table-cell">Département&nbsp<span title="Explications, différents départements" class="d-none d-md-inline">(?)</span></th>
                <th scope="col" class="ps-0 pe-0">Désignation&nbsp<span title="Explications" class="d-none d-md-inline">(?)</span></th>
                <th scope="col">État&nbsp<span title="Explications, différents états possibles" class="d-none d-md-inline">(?)</span></th>
                <th scope="col" class="d-none d-sm-table-cell">Actions&nbsp<span title="Les actions peuvent dépendre de votre rôle" class="d-none d-md-inline">(?)</span></th>
                <th scope="col" class="d-none d-md-table-cell">Date création&nbsp<span title="Explications" class="d-none d-md-inline">(?)</span></th>
            </tr>
        </thead>
        <tbody>
            {{-- TODO remplir avec les donnée en base de données --}}
            {{-- TODO les couleurs peuvent être mises en fonction de l'état de la commande: https://getbootstrap.com/docs/4.0/content/tables/#contextual-classes --}}
            @foreach ($orders as $order)
                {{-- TODO Pouvoir cliquer sur les commandes pour les détails --}}
                {{-- TODO Pouvoir faire un clique droit sur un élément pour plus d'options --}}
                <tr>
                    <th scope="row" class="text-break">
                        #{{ $order['id'] }}<br/>
                    </th>
                    <td class="d-none d-sm-table-cell"><strong>{{ $order['department'] }}</strong><br>({{ $order['author'] }})</td>
                    <td class="ps-0 pe-0">{{ $order['title'] }} <span class="d-table-cell d-sm-none">({{$order['department']}})</span></td>
                    <td>
                            <span class="orders-status-badge">{{ $order['state'] }}</span><br>
                        <small class="d-none d-lg-inline">{{ $order['stateChangedAt'] }}</small>
                    </td>
                    {{-- Mettre des petties icones --}}
                    <td class="d-none d-sm-table-cell">
                        <div>
                            @if(str_contains($order['state'], "bon de commande"))
                                <button class="btn btn-success btn-action" title="Déposer un bon de commande">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-upload" viewBox="0 0 16 16">
                                        <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5"/>
                                        <path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708z"/>
                                    </svg> Bon réalisé
                                </button>
                            @elseif(str_contains($order['state'], "livraison"))
                                <button class="btn btn-success mb-2 btn-action" title="Déposer un bon de commande">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
                                        <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425z"/>
                                    </svg> Colis&nbsplivré(s)
                                </button>
                                <button class="btn btn-success mb-2 btn-action" title="Déposer un bon de commande">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-upload" viewBox="0 0 16 16">
                                        <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5"/>
                                        <path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708z"/>
                                    </svg> Commande livrée
                                </button>
                            @endif
{{--                                TODO De trop cliquer sur la commande où les petits points suffisent. Quand on voit les détails on aura un bouton pour modifier--}}
{{--                                <button class="btn btn-secondary mb-0" title="Voir les détails">--}}
{{--                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">--}}
{{--                                        <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0"/>--}}
{{--                                        <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7"/>--}}
{{--                                    </svg>--}}
{{--                                </button>--}}
{{--                                <button class="btn btn-outline-primary orders-btn-edit" title="Modifier">--}}
{{--                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">--}}
{{--                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>--}}
{{--                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>--}}
{{--                                    </svg> Modifier--}}
{{--                                </button>--}}
{{--                                <button class="btn btn-light orders-btn-more" title="Plus d'options">--}}
{{--                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots" viewBox="0 0 16 16">--}}
{{--                                        <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3"/>--}}
{{--                                    </svg>--}}
{{--                                </button>--}}
                        </div>
                    </td>
                    <td class="d-none d-md-table-cell">{{ $order['createdAt'] }}</td>
                    <td class="ps-0 pe-0">
                        <button class="btn btn-light btn-more-options">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                                <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0"/>
                            </svg>
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</section>

@endsection
