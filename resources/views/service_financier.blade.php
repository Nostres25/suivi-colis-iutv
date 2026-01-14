@extends('base')

@section('content')

{{-- EN-TÊTE --}}
<div class="service-financier-header">
    <h1 class="fw-light">💼 Service financier</h1>
    <p class="mb-0">
        Création, validation et transmission des bons de commande
    </p>
</div>

{{-- MESSAGE SUCCÈS --}}
@if(session('success'))
<div class="alert alert-success mx-4">
    {{ session('success') }}
</div>
@endif

{{-- TABLEAU DES COMMANDES --}}
<div class="card mx-4">
    <div class="card-body">

        <h5 class="mb-3">📄 Devis signés / Bons de commande</h5>

        <table class="table align-middle">
            <thead>
                <tr>
                    <th>BC</th>
                    <th>Département</th>
                    <th>Désignation</th>
                    <th>État</th>
                    <th>Date création</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>

            <tbody>
            @foreach($orders as $commande)

                <tr>

                <div class="modal fade" id="uploadQuoteModal-{{ $commande->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Ajouter un devis</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form method="POST" action="{{ route('orders.uploadQuote', $commande->id) }}" enctype="multipart/form-data">
                @csrf

                <div class="modal-body">
                    <label class="form-label">Sélectionner un fichier PDF</label>
                    <input type="file" name="quote" class="form-control" accept="application/pdf" required>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary">Uploader</button>
                </div>
            </form>

        </div>
    </div>
</div>

                    {{-- Numéro BC --}}
                    <td>
                        <strong>{{ $commande->id ?? '—' }}</strong>
                    </td>

                    {{-- Département --}}
                    <td>
                        {{ $commande->department }}<br>
                        <small class="text-muted">{{ $commande->author }}</small>
                    </td>

                    {{-- Désignation --}}
                    <td>{{ $commande->title }}</td>

                    {{-- État --}}
                    <td>
                        <span class="badge
                           @if($commande->states === 'DEVIS_SIGNE') bg-secondary
                            @elseif($commande->states === 'BC_REDIGE') bg-info
                            @elseif($commande->states === 'BC_SIGNE') bg-primary
                            @elseif($commande->states === 'BC_ENVOYE') badge-financier
                            @elseif($commande->states === 'PAYEE') bg-success
                            @elseif($commande->states === 'LIVREE') bg-warning text-dark
                            @elseif($commande->states === 'ANNULEE') bg-danger

                            @endif
                            
                        ">
                        {{ str_replace('_', ' ', $commande->states) }}
                        </span>
                        <br>
                        <small class="text-muted">{{ $commande->stateChangedAt }}</small>
                    </td>

                    {{-- Date création --}}
                    <td>{{ $commande->createdAt }}</td>

                    {{-- Actions --}}
                    <td class="text-end">

                        {{-- Groupe de boutons --}}
                        <div class="btn-group mb-2" role="group">
                            {{-- Voir --}}
                            @if($commande->path_quote)
                            <a href="{{ asset('storage/' . $commande->path_quote) }}"
                            target="_blank"
                            class="btn btn-light btn-sm">
                                👁
                            </a>
                            @else
                            <button class="btn btn-light btn-sm" disabled title="Aucun devis disponible">
                                👁
                            </button>
                             @endif

                            {{-- Créer / modifier le BC --}}
                            @if($commande->states === 'DEVIS_SIGNE')
                                 <button class="btn btn-outline-primary btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#uploadQuoteModal-{{ $commande->id }}">
                                📝 DEVIS
                                </button>


                            @endif

                            {{-- Validation budgétaire --}}
                            @if($commande->states === 'BC_REDIGE')
                                <button class="btn btn-warning btn-sm">✔ Budget</button>
                            @endif

                            {{-- Envoi au fournisseur --}}
                            @if($commande->states === 'BC_SIGNE')
                                <button class="btn btn-sm btn-financier">📤 Fournisseur</button>
                            @endif
                        </div>

                        {{-- FORMULAIRE SORTI DU BTN-GROUP --}}
                        <form method="POST" action="{{ route('orders.changeState', $commande->id) }}">
                            @csrf
                            @method('PUT')

                            <select name="states" class="form-select form-select-sm mb-1">
                                @foreach(\App\Models\Order::STATES as $states)
                                    <option value="{{ $states }}" @selected($commande->states === $states)>
                                        {{ $states }}
                                    </option>
                                @endforeach
                            </select>

                            <button class="btn btn-sm btn-primary w-100">
                                Mettre à jour
                            </button>
                        </form>

                    </td>

                </tr>
            @endforeach
            </tbody>
        </table>

        <small class="text-muted">
            Les commandes affichées proviennent de devis validés par la direction.
        </small>

    </div>
</div>

@endsection

@section('css')
<style>
/* Bannière bleu identique à Orders */
.service-financier-header {
    background-color: #3170A8;
    color: white;
    padding: 50px 20px;
    margin-bottom: 40px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

/* Badge bleu personnalisé */
.badge-financier {
    background-color: #3170A8;
    color: white;
}

/* Bouton bleu personnalisé */
.btn-financier {
    background-color: #3170A8;
    border-color: #3170A8;
    color: white;
}

.btn-financier:hover {
    background-color: #255a85;
    border-color: #255a85;
}
</style>
@endsection