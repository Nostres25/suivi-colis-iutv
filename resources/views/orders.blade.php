@extends('base')

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<style>
    body {
        background-color: #f8f9fa;
    }

    .orders-page-header {
        background-color: #3170A8;
        padding: 50px 0;
        color: white;
        margin-bottom: 40px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .orders-page-header h1 {
        margin: 0;
        font-size: 2.2rem;
        font-weight: 400;
    }

    .orders-page-header .subtitle {
        margin-top: 8px;
        font-size: 1rem;
        opacity: 0.9;
    }

    #orders {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 20px 40px 20px;
    }

    .orders-action-bar {
        background: white;
        padding: 20px 25px;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        margin-bottom: 25px;
    }

    .orders-search-container {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 20px;
        justify-content: center;
    }

    .orders-search-wrapper {
        position: relative;
        flex: 1;
        max-width: 600px;
    }

    .orders-search-input {
        width: 100%;
        height: 42px;
        border-radius: 6px;
        padding: 0 16px 0 40px !important;
        border: 1px solid #ddd !important;
        font-size: 0.9rem;
    }

    .orders-search-input:focus {
        outline: none;
        border-color: #3170A8 !important;
        box-shadow: 0 0 0 3px rgba(49, 112, 168, 0.1) !important;
    }

    .orders-search-icon {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #999;
    }

    #search-filter {
        background: white;
        border: 1px solid #3170A8;
        color: #3170A8;
        padding: 10px 22px;
        border-radius: 6px;
        font-weight: 500;
        transition: all 0.2s;
        height: 42px;
    }

    #search-filter:hover {
        background: #3170A8;
        color: white;
    }

    .orders-btn-primary {
        background-color: #3170A8 !important;
        border-color: #3170A8 !important;
        color: white !important;
    }

    .orders-btn-primary:hover {
        background-color: #255a85 !important;
        border-color: #255a85 !important;
    }

    .orders-section {
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        margin-top: 30px;
    }

    .orders-table-header {
        padding: 20px 25px;
        background: #f8f9fa;
        border-bottom: 3px solid #3170A8;
    }

    .orders-table-header h2 {
        margin: 0;
        font-size: 1.3rem;
        font-weight: 500;
        color: #333;
    }

    .orders-table-header p {
        margin: 5px 0 0 0;
        font-size: 0.9rem;
        color: #666;
    }

    .orders-section table {
        margin-bottom: 0;
    }

    .orders-section table caption {
        caption-side: bottom;
        padding: 15px 25px;
        font-size: 0.85rem;
        color: #6c757d;
        text-align: left;
    }

    .orders-section thead {
        background-color: #3170A8;
        color: white;
    }

    .orders-section thead th {
        padding: 14px 16px;
        font-weight: 500;
        font-size: 0.85rem;
        text-transform: uppercase;
        border: none;
    }

    .orders-section tbody tr {
        border-bottom: 1px solid #e9ecef;
        transition: background-color 0.15s;
    }

    .orders-section tbody tr:hover {
        background-color: #f8f9fa;
    }

    .orders-section tbody tr:last-child {
        border-bottom: none;
    }

    .orders-section tbody th {
        font-weight: 600;
        color: #3170A8;
    }

    .orders-status-badge {
        display: inline-block;
        padding: 5px 12px;
        border-radius: 4px;
        font-size: 0.8rem;
        font-weight: 600;
        background-color: #FFA726;
        color: white;
    }

    .orders-action-buttons {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
        justify-content: center;
    }

    .orders-btn-action {
        padding: 7px 12px;
        border-radius: 4px;
        border: none;
        font-size: 0.8rem;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: all 0.2s;
        font-weight: 500;
        text-decoration: none;
    }

    .orders-btn-upload {
        background-color: #3170A8;
        color: white;
    }

    .orders-btn-upload:hover {
        background-color: #255a85;
    }

    .orders-btn-details {
        background-color: #f1f3f5;
        color: #495057;
        border: 1px solid #dee2e6;
    }

    .orders-btn-details:hover {
        background-color: #e9ecef;
    }

    .orders-btn-edit {
        background-color: white;
        color: #3170A8;
        border: 1px solid #3170A8;
    }

    .orders-btn-edit:hover {
        background-color: #3170A8;
        color: white;
    }

    .orders-btn-more {
        background-color: white;
        color: #6c757d;
        border: 1px solid #dee2e6;
    }

    .orders-btn-more:hover {
        background-color: #f8f9fa;
    }

    @media (max-width: 768px) {
        .orders-search-container {
            flex-direction: column;
        }

        .orders-search-wrapper {
            max-width: 100%;
        }
    }
</style>
@endsection

@section('content') 

<!-- Bannière bleue -->
<div class="orders-page-header">
    <div class="container">
        <h1><i class="fas fa-box"></i> Mon Espace - Commandes</h1>
        <div class="subtitle">Liste et gestion des commandes</div>
    </div>
</div>

<x-alert></x-alert>

<div id="orders">
    <div class="orders-action-bar">
        <div class="row justify-content-center">
            <div class="orders-search-container">
                <div class="orders-search-wrapper">
                    <i class="fas fa-search orders-search-icon"></i>
                    <input type="text" class="form-control orders-search-input" placeholder="Rechercher une commande...">
                </div>
                <button id="search-filter"><i class="fas fa-filter"></i> Filtres</button>
            </div>
        </div>
    </div>

    {{-- TODO Remplir le tableau avec la base de données --}}
    {{-- TODO Peut-être afficher un aperçu de ce qu'il y a dans la commande (colis) --}}

    <!-- Button trigger modal -->
    <button type="button" class="btn orders-btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
        <i class="fas fa-plus-circle"></i> Ajouter une commande
    </button>


    <!-- Modal de création de commande -->
    {{-- TODO: Ne pas valider s'il n'y a pas de numéro de commande, de fournisseur et de label. Voir https://getbootstrap.com/docs/5.3/forms/validation/ --}}
    {{-- TODO ajouter la petite étoile rouge pour les champs obligatoires (attention le submit est en dehors du formulaire, il faut utiliser l'id) --}}
    {{-- TODO ajouter un message d'avertissement de validation de formulaire --}}
    {{-- TODO si on appuie sur la croix ça garde en brouillon le contenu du formulaire pour la personne (si elle réappuie sur le bouton, elle retrouve ce qu'elle avait précédemment écrit) 
              par contre si on appuie sur "annuler" ça retire bien tout --}}


    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Création d'une commande</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="createOrderForm" class="needs-validation" novalidate>
                        <div class="mb-4">
                            <label for="order-label" class="col-form-label fs-5">Titre de la commande <span title="champ requis" class="text-danger" >*</span></label>
                            <input type="text" class="form-control" id="order-label" placeholder="Ex: Câblage réseau" maxlength="255" required>
                            <div class="invalid-feedback">
                                Le titre est obligatoire. Veuillez renseigner un titre descriptif concis.
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="order-num" class="col-form-label fs-5">Numéro de la commande <span title="champ requis" class="text-danger" >*</span></label>
                            <input type="text" class="form-control" id="order-num" placeholder="Ex: 4500161828" maxlength="255" required>
                            <div class="invalid-feedback">
                                Le numéro de la commande est obligatoire. Veuillez renseigner le numéro de la commande associé au devis ou au bon de commande (numéro en provenance de chorus).
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="order-description" class="col-form-label fs-5">Description:</label>
                            <dl class="fw-light">Ajoutez des détails sur la commmande et son contenu (facultatif).</dl>
                            <textarea class="form-control" id="order-description"></textarea>
                        </div>
                        <div class="mb-4">
                            <label for="selectState" class="col-form-label fs-5">Colis</label>
                            {{-- TODO probablement de trop, autant modifier la commande après l'avoir crée si la commande à une étape avancée. À la première étape de la commande, cette option ne devrait pas exister
                            <div class="mb-3">
                              <input class="form-check-input" type="checkbox" value="" id="checkboxBonDeCommandeSigne">
                              <label class="form-check-label" for="checkboxBonDeCommandeSigne">
                                Marquer les colis comme livrés 
                              </label>
                            </div> --}}
                            {{-- TODO ajouter les colis progressivement quand on clique sur le bouton avec possibilité de définir : titre, cout, date_prevu_livraison et date_reception --}}
                            <div class="newPackages"><p>à suivre</p></div>
                            <div class="input-group mb-3">
                                <button type="button" class="btn btn-outline-primary" disabled>+ Ajoute un colis</button>
                            </div>

                            {{-- TODO ne devrait apparaîte que si on défini les colis comme livrés --}}
                            {{-- <div class="input-group mb-3">
                                <label class="input-group-text" for="inputFichierBonDeLivraison"><strong>Bon de livraison</strong></label>
                                <input type="file" class="form-control" id="inputFichierBonDeLivraison">
                            </div> --}}
                        </div>
                        <div class="mb-3">
                            <label for="order-input-fichiers" class="col-form-label fs-5">Fichiers:</label>
                            <dl class="fw-light">
                                Ajoutez <strong>au format pdf</strong> un devis, un bon de commande ou un bon de livraison si ces documents existent déjà (facultatif)</br>
                                Le contenu présent dans certains fichiers peut permettre de remplir certains champs vides (experimental)
                            </dl>
                            <div id="order-input-fichiers">
                                <div class="input-group mb-3">
                                    <label class="input-group-text" for="inputFichierDevis"><strong>Devis</strong></label>
                                    <input type="file" class="form-control" id="inputFichierDevis">
                                </div>
                                <hr/>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="selectState" class="col-form-label fs-5">État de la commande</label>
                            <select id="selectState" class="form-select">
                                @foreach ($orderStates as $orderState)
                                    <option {{ $orderState === $defaultOrderState ? 'selected="selected"' : '' }}>{{$orderState}}</option>
                                @endforeach 
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="advancedInputs" class="col-form-label"><a class="" data-bs-toggle="collapse" href="#advancedInputs" role="button" aria-expanded="false" aria-controls="collapseExample">Avancé ></a></label>
                            <div class="collapse" id="advancedInputs">
                                <label for="selectState" class="col-form-label fs-5">Bon de commande</label>
                                <div id="inputsBonDeCommande">
                                    <div class="input-group mb-3">
                                        <label class="input-group-text" for="input-group-bon_de_commande"><strong>Bon de commande</strong></label>
                                        <input type="file" class="form-control" id="inputFichierBonDeCommande">
                                    </div>
                                    {{-- TODO Devrait n'apparaîte que si on met un bon de commande (avec bootstrap : https://getbootstrap.com/docs/5.3/utilities/display/#how-it-works (classes d-none et d-block ?)) --}}
                                    <div class="mb-3">
                                        <input class="form-check-input" type="checkbox" value="" id="checkboxBonDeCommandeSigne">
                                        <label class="form-check-label" for="checkboxBonDeCommandeSigne">
                                            Bon de commande signé par le directeur de l'IUT 
                                        </label>
                                    </div> 
                                    <label for="inputCost" class="col-form-label fs-5">Coût total</label>
                                    <dl class="fw-light">
                                        Coût total de la commande en euros (€)
                                    </dl>
                                    {{-- On peut mettre un form group pour indiquer que c'est en € --}}
                                    <input type="number" class="form-control" id="inputCost" maxlength="255">
                                </div>
                            </div>
                        </div>
                        {{-- obselette <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked">
                            <label class="form-check-label" for="flexSwitchCheckChecked">Créer en tant que brouillon</label>
                        </div> --}}
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" form="createOrderForm" class="btn orders-btn-primary">Valider</button>
                </div>
            </div>
        </div>
    </div>

    {{-- TODO format mobile : 4 colonne max  (actions en appuyant desssus ?) --}}
    <section class="orders-section mx-4">
        <div class="orders-table-header">
            <h2><i class="fas fa-list"></i> Commandes</h2>
            <p>Devis et bons de commandes</p>
        </div>

        <table class="table">
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
                {{-- TODO remplir avec les donnée en base de données --}}
                {{-- TODO les couleurs peuvent être mises en fonction de l'état de la commande: https://getbootstrap.com/docs/4.0/content/tables/#contextual-classes --}}
                @foreach ($orders as $order)
                    <tr>
                        <th scope="row">#{{ $order['id'] }}</th>
                        <td><strong>{{ $order['department'] }}</strong><br>({{ $order['author'] }})</td>
                        <td>{{ $order['title'] }}</td>
                        <td>
                            <span class="orders-status-badge">{{ $order['state'] }}</span><br>
                            <small style="color: #6c757d;">{{ $order['stateChangedAt'] }}</small>
                        </td>
                        <td>{{ $order['createdAt'] }}</td>
                        {{-- Mettre des petties icones --}}
                        <td>
                            <div class="orders-action-buttons">
                                <button class="orders-btn-action orders-btn-upload" title="Déposer un bon de commande">
                                    <i class="fas fa-upload"></i> <strong>Bon</strong>
                                </button>
                                <button class="orders-btn-action orders-btn-details" title="Voir les détails">
                                    <i class="fas fa-eye"></i> Détails
                                </button>
                                <button class="orders-btn-action orders-btn-edit" title="Modifier">
                                    <i class="fas fa-edit"></i> Modifier
                                </button>
                                <button class="orders-btn-action orders-btn-more" title="Plus d'options">
                                    <i class="fas fa-ellipsis-h"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach 
            </tbody>
        </table>
    </section>
</div> 

@endsection