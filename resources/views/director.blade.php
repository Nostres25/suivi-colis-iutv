@extends('base')

@section('header')
<h1 class="fw-light mb-0">Signature des bons de commande</h1>
<p class="mb-0 opacity-75">Validation et signature numérique</p>
@endsection

@section('alert')
@if(session('success'))
<div class="alert alert-success mx-4">
    {{ session('success') }}
</div>
@endif
@endsection

@section('content')

<section class="table-section">
    <div class="table-header">
        <h2>Bons de commande à signer ({{ $ordersAwaitingSignature->count() }})</h2>
        <p>Commandes validées par le service financier</p>
    </div>

    @if($ordersAwaitingSignature->count() > 0)
    <table class="table table-hover">
        <thead class="table-dark">
            <tr>
                <th>N° BC</th>
                <th>Département</th>
                <th>Désignation</th>
                <th>Date création</th>
                <th class="text-end">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ordersAwaitingSignature as $order)
            <tr>
                <td><strong>#{{ $order->id }}</strong></td>
                <td>
                    {{ $order->department->name ?? 'N/A' }}<br>
                  <small class="text-muted">  {{-- problème pour récuperer le full name, probleme au niveau de la BD donc j'ai simplifier le temps --}}
    @if($order->user)
        {{ $order->user->firstname }} {{ $order->user->name }}
    @else
        Auteur inconnu
    @endif
</small>
                </td>
                <td>{{ $order->label }}</td>
                <td>{{ $order->created_at->format('d/m/Y') }}</td>
                <td class="text-end">
                    <div class="btn-group">
                        @if($order->path_quote)
                        <a href="{{ asset('storage/' . $order->path_quote) }}" 
                           target="_blank" 
                           class="btn btn-sm btn-outline-secondary">
                            Voir
                        </a>
                        @endif

                        <form action="{{ route('director.sign', $order->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" 
                                    class="btn btn-sm btn-success"
                                    onclick="return confirm('Confirmer la signature de ce bon de commande ?')">
                                Signer
                            </button>
                        </form>

                        <button class="btn btn-sm btn-danger"
                                data-bs-toggle="modal"
                                data-bs-target="#refuseModal{{ $order->id }}">
                            Refuser
                        </button>
                    </div>
                </td>
            </tr>

            <div class="modal fade" id="refuseModal{{ $order->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Refuser le BC #{{ $order->id }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <form action="{{ route('director.refuse', $order->id) }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <p><strong>{{ $order->label }}</strong></p>
                                <div class="mb-3">
                                    <label class="form-label">Motif du refus <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="reason" rows="4" required placeholder="Expliquez la raison du refus..."></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-danger">Confirmer le refus</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="text-center py-5">
        <p class="text-muted fs-5">Aucun bon de commande en attente de signature</p>
    </div>
    @endif
</section>

<section class="table-section">
    <div class="table-header">
        <h2>Historique des signatures</h2>
        <p>Commandes traitées</p>
    </div>

    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>N° BC</th>
                <th>Désignation</th>
                <th>Département</th>
                <th>État</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orderHistory as $order)
            <tr>
                <td><strong>#{{ $order->id }}</strong></td>
                <td>{{ $order->label }}</td>
                <td>
                    {{ $order->department->name ?? 'N/A' }}<br>
                    <small class="text-muted"> {{-- - pareil ici, problème pour récup fullName  --}}
    @if($order->user)
        {{ $order->user->firstname }} {{ $order->user->name }}
    @else
        Auteur inconnu
    @endif
</small>
                </td>
                <td>
                    <span class="badge 
                        @if($order->status === 'BON_DE_COMMANDE_SIGNE') bg-success
                        @elseif($order->status === 'BON_DE_COMMANDE_REFUSE') bg-danger
                        @elseif($order->status === 'COMMANDE') bg-primary
                        @elseif($order->status === 'LIVRE_ET_PAYE') bg-info
                        @else bg-secondary
                        @endif
                    ">
                        {{ str_replace('_', ' ', $order->status) }}
                    </span>
                    @if($order->refusal_reason)
                    <br><small class="text-danger">{{ $order->refusal_reason }}</small>
                    @endif
                </td>
                <td>{{ $order->updated_at->format('d/m/Y H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $orderHistory->links() }}
    </div>
</section>

@endsection