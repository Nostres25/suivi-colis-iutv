<!-- Bouton d'ajout de fournisseur -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addFournisseurModal">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3z"/>
    </svg> Ajouter un fournisseur
</button>

<!-- Modal d'ajout de fournisseur -->
<div class="modal fade" id="addFournisseurModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addFournisseurModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addFournisseurModalLabel">Ajouter un fournisseur</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addFournisseurForm" class="needs-validation" novalidate>
                    <div class="mb-3">
                        <label for="company-name" class="form-label">Nom de l'entreprise <span title="champ requis" class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="company-name" required>
                    </div>
                    <div class="mb-3">
                        <label for="siret" class="form-label">SIRET <span title="champ requis" class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="siret" maxlength="14" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email <span title="champ requis" class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">Téléphone <span title="champ requis" class="text-danger">*</span></label>
                            <input type="tel" class="form-control" id="phone" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="contact-name" class="form-label">Nom du contact <span title="champ requis" class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="contact-name" required>
                    </div>
                    <div class="mb-3">
                        <label for="speciality" class="form-label">Spécialité</label>
                        <input type="text" class="form-control" id="speciality" placeholder="Ex: Matériel informatique, Fournitures...">
                    </div>
                    <div class="mb-3">
                        <label for="note" class="form-label">Note / Remarque</label>
                        <textarea class="form-control" id="note" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="submit" form="addFournisseurForm" class="btn btn-primary">Ajouter</button>
            </div>
        </div>
    </div>
</div>
