@extends('base')

{{-- TODO voué à disparaitre suite à l'arrivée de bootstrap
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
@endsection--}}

@section('content') 
<x-alert></x-alert>

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

           <!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
  + Ajouter une commande
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
            <label for="order-label" class="col-form-label fs-5">Numéro de la commande <span title="champ requis" class="text-danger" >*</span></label>
            <input type="text" class="form-control" id="order-label" placeholder="Ex: 4500161828" maxlength="255" required>
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
                   <input type="number" class="form-control" id="order-label" maxlength="255">
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
        <button type="submit" form="createOrderForm"class="btn btn-primary">Valider</button>
      </div>
    </div>
  </div>
</div>
    {{-- TODO format mobile : 4 colonne max  (actions en appuyant desssus ?) --}}
    <section class="mx-4">
        <h2>Commandes</h2>
        <p>Devis et bons de commandes</p>


    <table class="table">
    <caption>
        {{-- TODO Si c'est un département (ex: CRIT) : mettre "liste des commandes du département CRIT" --}}
        Liste des commandes à l'IUT de Villetaneuse
    </caption>
    <thead>
        <tr class="table-active">
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
            <tr class="table-primary">
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
    </section>
</div> 


@endsection 