@use(Database\Seeders\Status)
<div class="modal fade {{ $openPurchaseOrderModal ? 'show' : '' }}" id="addPurchaseOrderModal-{{$orderId}}" data-bs-keyboard="false" tabindex="-1"
     aria-labelledby="addPurchaseOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPurchaseOrderModalLabel-{{$orderId}}">Dépôt d'un bon de commande</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addPurchaseOrder-{{$orderId}}" method="POST" enctype="multipart/form-data" action="{{route('orders.uploadPurchaseOrder')}}" autocomplete="off">
                    <input type="hidden" name="id" value="{{$orderId}}">

                    @csrf
                    <label class="form-label">Sélectionnez un bon de commande :</label><br/>
                    <small>Fichiers acceptés : pdf, doc, docx jusqu'à 10MB</small>
                    <input type="file" name="purchase_order" class="form-control mb-3" accept="*,.pdf,.docx,.doc" required>

                    <div class="d-flex justify-content-start" title="À cocher si le directeur de l'IUT a signé le bon de commande">
                        <input class="form-check-input me-2" type="checkbox" name="signed"
                               id="checkboxSigned-{{$orderId}}" form="addPurchaseOrder-{{$orderId}}" @checked($canSign)>
                        <label class="form-check-label" for="checkboxSigned-{{$orderId}}">
                            Marquer comme signé par le directeur de l'IUT
                        </label>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <div class="d-flex justify-content-start" title="Passer la commande du statut {{ $orderStatus }} au statut de {{ Status::BON_DE_COMMANDE_NON_SIGNE }} ou de {{ Status::BON_DE_COMMANDE_SIGNE }} si le bon de commande est marqué comme signé.">
                    <input class="form-check-input me-2" name="nextStep" type="checkbox"
                           id="checkboxNextStep-{{$orderId}}" form="addPurchaseOrder-{{$orderId}}" checked>
                    <label class="form-check-label" for="checkboxNextStep-{{$orderId}}">
                        Passer au statut suivant
                    </label>
                </div>
                <div class="d-inline">
                    <button type="submit" form="addPurchaseOrder-{{$orderId}}" class="btn btn-primary">Sauvegarder</button>
                </div>
            </div>
        </div>
    </div>
</div>
