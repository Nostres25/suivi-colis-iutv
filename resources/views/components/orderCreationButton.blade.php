@use(Database\Seeders\Status)
    <!-- Button trigger modal -->
<button type="button" class="btn btn-primary erasure-alert" style="display: table-row" data-bs-toggle="modal"
        data-bs-target="#staticBackdrop" id="createOrderButton">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle-fill"
         viewBox="0 0 16 16">
        <path
            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3z"/>
    </svg>
    Ajouter une commande
</button>

<!-- Modal de création de commande -->
{{-- TODO ajouter un message d'avertissement de validation de formulaire --}}
{{--TODO: Il n'est pas possible de définir une langue par défaut bootstrap mais on peut changer la valeur des attribtuts (notamment pour le message qui apparaît quand on valide sans remplir les champs requis : https://stackoverflow.com/questions/23731862/how-can-i-set-bootstrap-language-manually--}}
{{--TODO pour traduire le message "champ requis", la solution de l'attribut "oninvalid="this.setCustomValidity('Veuillez remplir un titre de commande avant de valider !')" sur l'input ne fonctionne pas. Peut-être trouver une solution (pas prioritaire)--}}

<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
     aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Création d'une commande</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <form id="createOrderForm" method="POST" action="{{ route('orders.submitNewOrder') }}" class="needs-validation" autocomplete="off" enctype="multipart/form-data">
                @csrf
                    <div class="mb-4">
                        <label for="order-label" class="col-form-label fs-5">Titre de la commande <span
                                title="champ requis" class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="order-label" name="title" placeholder="Ex: Câblage réseau"
                               maxlength="255" 
                               required/>
                        <div class="invalid-feedback">
                            Le titre est obligatoire. Veuillez renseigner un titre descriptif concis.
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="supplierInput" class="col-form-label fs-5">Fournisseur <span title="champ requis"
                                                                                                 class="text-danger">*</span></label>
                        <input type="text" id="supplierInput" name="supplier_id" class="form-select" list="supplierList"
                               placeholder="Veuillez écrire ou sélectionner un fournisseur" required/>
                        <datalist id="supplierList">
                            @foreach ($validSupplierNames as $supplier)
                                <option>{{$supplier}}</option>
                            @endforeach
                        </datalist>
                        <div class="mt-1" id="askToAddSupplierDiv" style="display: none;">
                            <div class="alert alert-warning" role="alert">
                                <p class="fs-5">Fournisseur invalide !</p>
                                <p>Veuillez sélectionner un fournisseur valide ou s'il s'agit d'un nouveau fournisseur,
                                    vous ne pouvez pas commander auprès d'un fournisseur qui n'a pas été validé au
                                    préalable par le service financier.<br/>
                                    Veuillez d'abord, <strong>demander l'ajout du fournisseur en question</strong>.<br/>
                                    À la validation, la commande sera sauvegardée à l'état de brouillon. C'est seulement
                                    lorsque le fournisseur sera validé que vous pourrez la passer à l'état de devis</p>
                                <input class="form-check-input" type="checkbox" value="" id="askToAddSupplierCheckBox">
                                <label class="form-check-label" for="askToAddSupplierCheckBox">
                                    Demander l'ajout du fournisseur
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="order-num" class="col-form-label fs-5">Numéro de la commande <span
                                title="champ requis" class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="order-num" name="order_num" placeholder="Ex: 4500161828"
                               maxlength="255" required>
                        <div class="invalid-feedback">
                            Le numéro de la commande est obligatoire. Veuillez renseigner le numéro de la commande
                            associé au devis ou au bon de commande (numéro en provenance de chorus).
                        </div>
                    </div>
                    <div class="mb-4">
                    <label for="quote-num" class="col-form-label fs-5">Numéro du devis <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="quote-num" name="quote_num"
                        placeholder="Ex: DV-2026-001" maxlength="255" required>
                    <div class="invalid-feedback">
                        Le numéro du devis est obligatoire.
                    </div>
                </div>
                    {{--                    TODO ne pas oublier de vérifier qu'une option est bien choisie avant de valider--}}
                    {{--                    TODO ajouter une permission "CREER_COMMANDES_POUR_TOUS" qui permet de créer une commande pour d'autres départements--}}
                    @if($userDepartments->count() > 1)
                        <div class="mb-4">
                            <label for="departmentSelect" class="col-form-label fs-5"
                                   title="{{Status::getDescriptions()}}">Département <span title="champ requis"
                                                                                           class="text-danger">*</span></label>
                            <p>
                                Vous êtes membre de plusieurs départements, veuillez choisir pour quel département vous
                                créez cette commande<br/>
                            </p>
                            <select id="departmentSelect" name="department_id" class="form-select" required>
                                <option value="{{ $department->getId() }}">{{ $department->getName() }}</option>
                                @foreach ($userDepartments as $department)
                                    <option>{{$department->getName()}}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    <div class="mb-4">
                        <label for="order-description" class="col-form-label fs-5">Description:</label>
                        <dl class="fw-light">Ajoutez des détails sur la commande et son contenu (facultatif).</dl>
                        <textarea class="form-control" id="order-description" name="description"></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="col-form-label fs-5">Colis <span title="Au moins un colis requis"
                                                                       class="text-danger">*</span></label>
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
                            <button type="button" class="btn btn-outline-primary">+ Ajoute un colis</button>
                        </div>

                        {{-- TODO ne devrait apparaîte que si on défini les colis comme livrés --}}
                        {{-- <div class="input-group mb-3">
                            <label class="input-group-text" for="inputFichierBonDeLivraison"><strong>Bon de livraison</strong></label>
                            <input type="file" class="form-control" id="inputFichierBonDeLivraison">
                        </div> --}}
                    </div>
                    <div class="mb-3">
                        <label for="order-input-devis" class="col-form-label fs-5">Devis:</label>
                        <dl class="fw-light">
                            Ajoutez un devis <strong>au format pdf</strong>
{{--                            TODO pouvoir remplir automatiquement les champs en fonctions des infos du fichier--}}
{{--                            Le contenu présent dans le fichier peut permettre de remplir certains champs vides--}}
{{--                            (experimental)--}}
                        </dl>
                        <div id="order-input-devis">
                            <input type="file" class="form-control mb-3" id="inputFichierDevis" name="path_quote" accept="application/pdf">
                        </div>
                    </div>
                    <hr/>
                    <div class="mb-4">
                        <label for="advancedInputs" class="col-form-label"><a class="" data-bs-toggle="collapse"
                                                                              href="#advancedInputs" role="button"
                                                                              aria-expanded="false"
                                                                              aria-controls="collapseExample">Avancé
                                ></a></label>
                        <div class="collapse" id="advancedInputs">
                            <p>Les options avancées servent lorsque vous souhaitez créer une commande qui est déjà à une
                                étape avancée. Après la rédaction d'un bon de commande par exemple.</p>
                            <div class="mb-4">
                                <label for="statusSelect" class="col-form-label fs-5"
                                       title="{{Status::getDescriptions()}}">Statut de la commande</label>
                                <div id="alertLockedStatusBySupplierValue" class="alert alert-warning pb-0" role="alert"
                                     style="display: none">
                                    <p>
                                        Vous ne pouvez pas passer commande auprès d'un fournisseur non validé au
                                        préalable par le service financier.<br/>
                                        Ainsi, la commande restera à l'état de <span
                                            title="{{Status::BROUILLON->getDescription()}}">brouillon¹</span> tant
                                        qu'elle ne sera pas associée à un fournisseur valide.
                                    </p>
                                </div>
                                <select id="statusSelect" name="status" class="form-select">
                                    @foreach (Status::cases() as $status)
                                        <option
                                            {{ Status::getDefault() == $status ? 'selected="selected"' : '' }} title="{{$status->getDescription()}}">{{$status}}</option>
                                    @endforeach
                                </select>
                                <small id="statusDescription"
                                       class="mt-2">{{ Status::getDefault()->getDescription()}}</small>
                            </div>
                            <label for="inputFichierBonDeCommande" class="col-form-label fs-5">Bon de commande</label>
                            <div id="inputsBonDeCommande">
                                <input type="file" class="form-control mb-3" id="inputFichierBonDeCommande" name="path_purchase_order">
                                {{-- TODO Devrait n'apparaîte que si on met un bon de commande (avec bootstrap : https://getbootstrap.com/docs/5.3/utilities/display/#how-it-works (classes d-none et d-block ?)) --}}
                                <div class="mb-3 d-flex justify-content-start">
                                    <input class="form-check-input me-2" type="checkbox" value=""
                                           id="checkboxBonDeCommandeSigne">
                                    <label class="form-check-label" for="checkboxBonDeCommandeSigne">
                                        Bon de commande signé par le directeur de l'IUT
                                    </label>
                                </div>
                                <label for="inputCost" class="col-form-label fs-5">Coût total</label>
                                <dl class="fw-light">
                                    Coût total de la commande en euros (€)
                                </dl>
                                <div class="input-group w-25">
                                    <input id="inputCost" name="cost" maxlength="12" type="number" class="form-control"
                                           aria-label="Quantité en euros">
                                    <span class="input-group-text">€</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <div class="d-flex justify-content-start" title="{{Status::BROUILLON->getDescription()}}">
                    <input class="form-check-input me-2" type="checkbox" value=""
                           id="checkboxDraft" form="createOrderForm">
                    <label class="form-check-label" for="checkboxDraft">
                        Enregistrer comme brouillon
                    </label>
                </div>
                <div class="d-inline">
                    <button type="reset" class="btn btn-secondary me-1" form="createOrderForm" data-bs-dismiss="modal">
                        Annuler
                    </button>
                    <button type="submit" form="createOrderForm" class="btn btn-primary">Valider</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    const suppliers = {!! json_encode($validSupplierNames) !!};

    const supplierInputs = document.getElementById("supplierInput");
    const askToAddNewSupplierCheckBox = document.getElementById("askToAddSupplierCheckBox");
    const statusSelect = document.getElementById('statusSelect');
    const alertLockedStatusBySupplierValue = document.getElementById('alertLockedStatusBySupplierValue');
    const drawCheckBox = document.getElementById('checkboxDraft');

    supplierInputs.addEventListener("blur", (event) => {
        const askToAddSupplier = document.getElementById("askToAddSupplierDiv");
        if (event.target.value === "" || suppliers.includes(event.target.value)) {
            askToAddSupplier.style.display = "none";
            askToAddNewSupplierCheckBox.required = false;
            statusSelect.disabled = false;
            alertLockedStatusBySupplierValue.style.display = "none";
            drawCheckBox.checked = false;
            drawCheckBox.disabled = false;
            drawCheckBox.parentElement.title = "{{Status::BROUILLON->getDescription()}}";
        } else {
            askToAddSupplier.style.display = "block";
            askToAddNewSupplierCheckBox.required = true;
            statusSelect.disabled = true;
            statusSelect.value = "{{ Status::BROUILLON }}";
            alertLockedStatusBySupplierValue.style.display = "block";
            drawCheckBox.checked = true;
            drawCheckBox.disabled = true;
            drawCheckBox.parentElement.title = "{{Status::BROUILLON->getDescription()}}\n /!\\ Vous ne pouvez pas passer commande auprès d'un fournisseur non validé au préalable par le service financier.\nAinsi, la commande restera à l'état de brouillon tant qu'elle ne sera pas associée à un fournisseur valide.";
        }
    });


    const statusDescriptions = {!! json_encode(Status::getDescriptionsDict()) !!};
    const statusDescriptionP = document.getElementById('statusDescription');

    statusSelect.addEventListener('change', (event) => {
        statusDescriptionP.textContent = statusDescriptions[event.target.value];
        drawCheckBox.checked = event.target.value === "{{Status::BROUILLON}}" && !drawCheckBox.checked;
    });

    drawCheckBox.addEventListener('click', (event) => {
        statusSelect.value = event.target.checked ? "{{Status::BROUILLON}}" : "{{Status::getDefault()}}"
        statusDescriptionP.textContent = statusDescriptions[statusSelect.value];
    });


</script>
