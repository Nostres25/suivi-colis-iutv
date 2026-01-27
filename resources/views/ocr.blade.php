@extends('base')

@section('header')
    <div class="container d-block">
        <h1 class="h1">OCR - Extraction d’étiquette</h1>
        <p class="mb-0 opacity-75">Upload JPG/PNG et extraction automatique</p>
    </div>
@endsection

@section('content')
<div class="container">

    {{-- Bloc upload --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="POST" action="{{ route('ocr.extract') }}" enctype="multipart/form-data">
                @csrf

                <div class="row g-2 align-items-end">
                    <div class="col-12 col-md-8">
                        <label class="form-label mb-1">Document (JPG / PNG)</label>
                        <input type="file" class="form-control" name="document" accept=".jpg,.jpeg,.png" required>
                        <div class="form-text">Max 10MB.</div>
                    </div>

                    <div class="col-12 col-md-4 d-grid">
                        <button class="btn btn-primary">Lancer l’extraction</button>
                    </div>
                </div>

                {{-- Debug discret dans public/test.jpg --}}
                <div class="mt-2">
                    <small class="text-muted">
                        Debug : <a href="{{ route('ocr.auto') }}">mode auto</a> (utilise public/test.jpg ou public/test.png)
                    </small>
                </div>
            </form>

            @if ($errors->any())
                <div class="alert alert-danger mt-3 mb-0">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>

    {{-- Résultat --}}
    @if (!empty($result))
        @if (($result['success'] ?? false) === true)
            @php $ex = $result['extracted'] ?? []; @endphp

            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <h5 class="mb-0">Extraction réussie</h5>
                        <div class="d-flex gap-2">
                            <span class="badge text-bg-success">Confiance : {{ $result['confidence'] ?? 0 }}%</span>
                            <span class="badge text-bg-secondary">Temps : {{ $result['processing_time'] ?? '—' }} ms</span>
                        </div>
                    </div>

                    <hr class="my-3">

                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <div><strong>N° colis :</strong> {{ $ex['numero_colis'] ?: '—' }}</div>
                            <div><strong>Réf client :</strong> {{ $ex['reference_client'] ?: '—' }}</div>
                            <div><strong>Destinataire :</strong> {{ $ex['destinataire_nom'] ?: '—' }}</div>
                            <div><strong>Adresse :</strong> {{ $ex['destinataire_adresse'] ?: '—' }}</div>
                            <div><strong>CP / Ville :</strong> {{ $ex['destinataire_cp_ville'] ?: '—' }}</div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div><strong>Expéditeur :</strong> {{ $ex['expediteur_nom'] ?: '—' }}</div>
                            <div><strong>Poids :</strong> {{ $ex['poids'] ?: '—' }}</div>
                            <div><strong>Date :</strong> {{ $ex['date_livraison'] ?: '—' }}</div>
                            <div><strong>Nombre colis :</strong> {{ $ex['nombre_colis'] ?: '—' }}</div>
                        </div>
                    </div>

                    @if (!empty($result['text']))
                        <hr class="my-3">
                        <details>
                            <summary>Voir le texte OCR brut</summary>
                            <pre class="mt-2 mb-0" style="white-space: pre-wrap;">{{ $result['text'] }}</pre>
                        </details>
                    @endif
                </div>
            </div>

        @else
            <div class="alert alert-danger">
                <h5 class="mb-2">Erreur d’extraction</h5>
                <div><strong>Message :</strong> {{ $result['error'] ?? 'Erreur inconnue' }}</div>
                <div class="mt-2">
                    Conseil : essayez une image plus nette (PNG), bien cadrée et en bonne résolution.
                </div>
            </div>
        @endif
    @endif

</div>
@endsection
