<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" style="display: table-row" data-bs-toggle="modal"
        data-bs-target="#staticBackdrop">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle-fill"
         viewBox="0 0 16 16">
        <path
            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3z"/>
    </svg>
    Ajouter une commande
</button>

<!-- Modal de création de commande -->
{{-- TODO: Ne pas valider s'il n'y a pas de numéro de commande, de fournisseur et de label. Voir https://getbootstrap.com/docs/5.3/forms/validation/ --}}
{{-- TODO ajouter un message d'avertissement de validation de formulaire --}}
{{-- TODO si on appuie sur la croix ça garde en brouillon le contenu du formulaire pour la personne (si elle réappuie sur le bouton, elle retrouve ce qu'elle avait précédemment écrit)
          par contre si on appuie sur "annuler" ça retire bien tout, coder le vidage des inputs --}}
{{--TODO: Il n'est pas possible de définir une langue par défaut bootstrap mais on peut changer la valeur des attribtuts (notamment pour le message qui apparaît quand on valide sans remplir les champs requis : https://stackoverflow.com/questions/23731862/how-can-i-set-bootstrap-language-manually--}}
{{--TODO pour traduire le message "champ requis", la solution de l'attribut "oninvalid="this.setCustomValidity('Veuillez remplir un titre de commande avant de valider !')" sur l'input ne fonctionne pas. Peut-être trouver une solution (pas prioritaire)--}}
{{--TODO si l'utilisateur a plusieurs départements, devoir choisir le département de la commande--}}

<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
     aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Création d'une commande</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createOrderForm" class="needs-validation" autocomplete="off">
                    <div class="mb-4">
                        <label for="order-label" class="col-form-label fs-5">Titre de la commande <span
                                title="champ requis" class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="order-label" placeholder="Ex: Câblage réseau"
                               maxlength="255"
                               required/>
                        <div class="invalid-feedback">
                            Le titre est obligatoire. Veuillez renseigner un titre descriptif concis.
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="supplierInput" class="col-form-label fs-5">Fournisseur <span title="champ requis" class="text-danger">*</span></label>
                        <input type="text" id="supplierInput" class="form-select" list="supplierList" placeholder="Veuillez écrire ou sélectionner un fournisseur" required/>
                        <datalist id="supplierList">
                            @foreach ($validSupplierNames as $supplier)
                                <option>{{$supplier}}</option>
                            @endforeach
                        </datalist>
                        <div class="mt-1" id="askToAddSupplierDiv" style="display: none;">
                            <div class="alert alert-warning" role="alert">
                                <p class="fs-5">Fournisseur invalide !</p>
                                <p>Veuillez sélectionner un fournisseur valide ou s'il s'agit d'un nouveau fournisseur, vous ne pouvez pas commander auprès d'un fournisseur qui n'a pas été validé au préalable par le service financier.<br/>
                                    Veuillez d'abord, <strong>demander l'ajout du fournisseur en question</strong>.<br/>
                                    À la validation, la commande sera sauvegardée à l'état de brouillon. C'est seulement lorsque le fournisseur sera validé que vous pourrez la passer à l'état de devis</p>
                                <input class="form-check-input" type="checkbox" value="" id="askToAddSupplierCheckBox" >
                                <label class="form-check-label" for="askToAddSupplierCheckBox">
                                    Demander l'ajout du fournisseur
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="order-num" class="col-form-label fs-5">Numéro de la commande <span
                                title="champ requis" class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="order-num" placeholder="Ex: 4500161828"
                               maxlength="255" required>
                        <div class="invalid-feedback">
                            Le numéro de la commande est obligatoire. Veuillez renseigner le numéro de la commande
                            associé au devis ou au bon de commande (numéro en provenance de chorus).
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="order-description" class="col-form-label fs-5">Description:</label>
                        <dl class="fw-light">Ajoutez des détails sur la commande et son contenu (facultatif).</dl>
                        <textarea class="form-control" id="order-description"></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="col-form-label fs-5">Colis <span title="Au moins un colis requis" class="text-danger">*</span></label>
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
                            <button type="button" class="btn btn-outline-primary" >+ Ajoute un colis</button>
                        </div>

                        {{-- TODO ne devrait apparaîte que si on défini les colis comme livrés --}}
                        {{-- <div class="input-group mb-3">
                            <label class="input-group-text" for="inputFichierBonDeLivraison"><strong>Bon de livraison</strong></label>
                            <input type="file" class="form-control" id="inputFichierBonDeLivraison">
                        </div> --}}
                    </div>
                    <div class="mb-3">
                        <label for="order-input-fichiers" class="col-form-label fs-5">Devis:</label>
                        <dl class="fw-light">
                            Ajoutez un devis <strong>au format pdf</strong></br>
                            Le contenu présent dans le fichier peut permettre de remplir certains champs vides
                            (experimental)
                        </dl>
                        <div id="order-input-fichiers">
                            <input type="file" class="form-control mb-3" id="inputFichierDevis">
                        </div>
                    </div>
                    <div class="mb-4">
{{--                    TODO mettre le sélecteur de statut dans "avancé" et à la place mettre un checkbox "créer en tant que brouillon"
                        + décocher le checkbox si un autre statut est seléctionné
                        + mettre le sélecteur à "brouillon" si le checkbox est décoché et à "devis" sinon--}}
                        <label for="statusSelect" class="col-form-label fs-5" title="{{\Database\Seeders\Status::getDescriptions()}}">Statut de la commande</label>
                        <div id="alertLockedStatusBySupplierValue" class="alert alert-warning pb-0" role="alert" style="display: none">
                            <p>
                                Vous ne pouvez pas passer commande auprès d'un fournisseur non validé au préalable par le service financier.<br/>
                                Ainsi, la commande restera à l'état de <span title="{{\Database\Seeders\Status::BROUILLON->getDescription()}}">brouillon¹</span> tant qu'elle ne sera pas associée à un fournisseur valide.
                            </p>
                        </div>
                        <select id="statusSelect" class="form-select">
                            @foreach (\Database\Seeders\Status::cases() as $status)
                                <option {{ \Database\Seeders\Status::getDefault() == $status ? 'selected="selected"' : '' }} title="{{$status->getDescription()}}">{{$status}}</option>
                            @endforeach
                        </select>
                        <small id="statusDescription" class="mt-2">{{ \Database\Seeders\Status::getDefault()->getDescription()}}</small>
                    </div>
                    <hr/>
                    <div class="mb-4">
                        <label for="advancedInputs" class="col-form-label"><a class="" data-bs-toggle="collapse"
                                                                              href="#advancedInputs" role="button"
                                                                              aria-expanded="false"
                                                                              aria-controls="collapseExample">Avancé
                                ></a></label>
                        <div class="collapse" id="advancedInputs">
                            <label for="inputFichierBonDeCommande" class="col-form-label fs-5">Bon de commande</label>
                            <div id="inputsBonDeCommande">
                                <input type="file" class="form-control mb-3" id="inputFichierBonDeCommande">
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
                <button type="reset" class="btn btn-secondary" form="createOrderForm" data-bs-dismiss="modal">Annuler</button>
                <button type="submit" form="createOrderForm" class="btn btn-primary">Valider</button>
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

    supplierInputs.addEventListener("blur", (event) => {
        const askToAddSupplier = document.getElementById("askToAddSupplierDiv");
        if (event.target.value === "" || suppliers.includes(event.target.value)) {
            askToAddSupplier.style.display = "none";
            askToAddNewSupplierCheckBox.required = false;
            statusSelect.disabled = false;
            alertLockedStatusBySupplierValue.style.display = "none";
        } else {
            askToAddSupplier.style.display = "block";
            askToAddNewSupplierCheckBox.required = true;
            statusSelect.disabled = true;
            statusSelect.value = "{{ \Database\Seeders\Status::BROUILLON }}";
            alertLockedStatusBySupplierValue.style.display = "block";

        }
    });



    const statusDescriptions = {!! json_encode(\Database\Seeders\Status::getDescriptionsDict()) !!};
    const statusDescriptionP = document.getElementById('statusDescription');

    statusSelect.addEventListener('change', (event) => {
       statusDescriptionP.textContent = statusDescriptions[event.target.value];
    });
</script>
