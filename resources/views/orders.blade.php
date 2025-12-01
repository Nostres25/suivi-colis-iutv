@extends('base')

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

<style>

    /* Commandes */
        /* #orders {
            text-align:center
        } */

    /* Table: */

    table {
        border-collapse: collapse;
        border: 2px solid rgb(140 140 140);
        font-family: sans-serif;
        font-size: 0.8rem;
        letter-spacing: 1px;
        margin: 0px auto;
    }

    caption {
        caption-side: bottom;
        padding: 10px;
        font-weight: bold;
    }

    thead,
    tfoot {
        background-color: rgb(228 240 245);
    }

    th,
    td {
    border: 1px solid rgb(160 160 160);
    padding: 8px 10px;
    }

    td:last-of-type {
    text-align: center;
    }

    tbody > tr:nth-of-type(even) {
    background-color: rgb(237 238 242);
    }

    tfoot th {
    text-align: right;
    }

    tfoot td {
    font-weight: bold;
    }

    /* Search bar : */
    .search-container {
        position: relative; 
        text-align:center;
        margin-bottom: 20px;
    }

    .search-input {
        height: 50px;
        width: 50%;
        border-radius: 30px;
        padding-left: 35px;
        border: none;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .search-icon {
        position: relative;
        left: 35px;
        top: 10px;
        transform: translateY(-50%);
        color: #888;
    }

    #search-filter {
        position: relative;
        margin-left: 20px;
        height: 50px;
    }

    /* Create new order button */

    #newOrder {
        position: fixed;
    }

</style>
@endsection

@section('content')

<x-alert></x-alert>

<button id="newOrder">+ Créer une nouvelle commande</button>

<div id="orders">
    <div class="row justify-content-center">
        <div class="search-container">
            <i class="fas fa-search search-icon"></i>
            <input type="text" class="form-control search-input" placeholder="Search...">
            <button id="search-filter">Filtres</button>
        </div>
    </div>

    {{-- TODO Remplir le tableau avec la base de données --}}
    {{-- TODO Peut-être afficher un aperçu de ce qu'il y a dans la commande (colis) --}}
    {{-- TODO format mobile : 4 colonne max  (actions en appuyant desssus ?) --}}
    <table class="sortable">
    <caption>
        {{-- TODO Si c'est un département (ex: CRIT) : mettre "liste des commandes du département CRIT" --}}
        Liste des commandes à l'IUT de Villetaneuse
    </caption>
    <thead>
        <tr>
            {{-- TODO Pouvoir trier les différentes colonnes --}}
        <th scope="col">Numéro</th>
        <th scope="col">Département <span title="Explications, differents départements">(?)</span></th>
        <th scope="col">Désignation  <span title="Explications">(?)</span></th>
        <th scope="col">État  <span title="Explications, differents états possibles">(?)</span></th>
        <th scope="col">Date création  <span title="Explications">(?)</span></th>
        <th scope="col">Actions <span title="Les actions peuvent dépendre de votre rôle">(?)</span></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($orders as $order)
            <tr>
                <th scope="row">{{ $order['id'] }}</th>
                <td><strong>{{ $order['department'] }}</strong></br>({{ $order['author'] }})</td>
                <td>{{ $order['title'] }}</td>
                <td><span style="background-color:orange; border-radius: 30px;">{{ $order['state'] }}</span></br>{{ $order['stateChangedAt'] }}</td>
                <td>{{ $order['createdAt'] }}</td>

                {{-- Mettre des petties icones --}}
                <td><strong>[Déposer un bon de commande]</strong> [Détails] [Modifier] [...]</td>
            </tr>
        @endforeach 
    </tbody>
    </table>
</div> 


@endsection 