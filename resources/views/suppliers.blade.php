@extends('base')

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<style>
    body {
        background-color: #f8f9fa;
    }

    .fournisseurs-page-header {
        background-color: #3170A8;
        padding: 50px 0;
        color: white;
        margin-bottom: 40px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .fournisseurs-page-header h1 {
        margin: 0;
        font-size: 2.2rem;
        font-weight: 400;
    }

    .fournisseurs-page-header .subtitle {
        margin-top: 8px;
        font-size: 1rem;
        opacity: 0.9;
    }

    #fournisseurs-content {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 20px 40px 20px;
    }

    .fournisseurs-action-bar {
        background: white;
        padding: 20px 25px;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        margin-bottom: 25px;
    }

    .fournisseurs-search-container {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 20px;
        justify-content: center;
    }

    .fournisseurs-search-wrapper {
        position: relative;
        flex: 1;
        max-width: 600px;
    }

    .fournisseurs-search-input {
        width: 100%;
        height: 42px;
        border-radius: 6px;
        padding: 0 16px 0 40px !important;
        border: 1px solid #ddd !important;
        font-size: 0.9rem;
    }

    .fournisseurs-search-input:focus {
        outline: none;
        border-color: #3170A8 !important;
        box-shadow: 0 0 0 3px rgba(49, 112, 168, 0.1) !important;
    }

    .fournisseurs-search-icon {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #999;
    }

    .fournisseurs-btn-filter {
        background: white;
        border: 1px solid #3170A8;
        color: #3170A8;
        padding: 10px 22px;
        border-radius: 6px;
        font-weight: 500;
        transition: all 0.2s;
        height: 42px;
    }

    .fournisseurs-btn-filter:hover {
        background: #3170A8;
        color: white;
    }

    .fournisseurs-btn-primary {
        background-color: #3170A8 !important;
        border-color: #3170A8 !important;
        color: white !important;
    }

    .fournisseurs-btn-primary:hover {
        background-color: #255a85 !important;
        border-color: #255a85 !important;
    }

    .fournisseurs-section {
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        margin-top: 30px;
    }

    .fournisseurs-table-header {
        padding: 20px 25px;
        background: #f8f9fa;
        border-bottom: 3px solid #3170A8;
    }

    .fournisseurs-table-header h2 {
        margin: 0;
        font-size: 1.3rem;
        font-weight: 500;
        color: #333;
    }

    .fournisseurs-table-header p {
        margin: 5px 0 0 0;
        font-size: 0.9rem;
        color: #666;
    }

    .fournisseurs-section table {
        margin-bottom: 0;
    }

    .fournisseurs-section table caption {
        caption-side: bottom;
        padding: 15px 25px;
        font-size: 0.85rem;
        color: #6c757d;
        text-align: left;
    }

    .fournisseurs-section thead {
        background-color: #3170A8;
        color: white;
    }

    .fournisseurs-section thead th {
        padding: 14px 16px;
        font-weight: 500;
        font-size: 0.85rem;
        text-transform: uppercase;
        border: none;
    }

    .fournisseurs-section tbody tr {
        border-bottom: 1px solid #e9ecef;
        transition: background-color 0.15s;
    }

    .fournisseurs-section tbody tr:hover {
        background-color: #f8f9fa;
    }

    .fournisseurs-section tbody tr:last-child {
        border-bottom: none;
    }

    .fournisseurs-section tbody th {
        font-weight: 600;
        color: #3170A8;
    }

    .fournisseurs-badge-valid {
        display: inline-block;
        padding: 5px 12px;
        border-radius: 4px;
        font-size: 0.8rem;
        font-weight: 600;
        background-color: #66BB6A;
        color: white;
    }

    .fournisseurs-badge-invalid {
        display: inline-block;
        padding: 5px 12px;
        border-radius: 4px;
        font-size: 0.8rem;
        font-weight: 600;
        background-color: #EF5350;
        color: white;
    }

    .fournisseurs-action-buttons {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
        justify-content: center;
    }

    .fournisseurs-btn-action {
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

    .fournisseurs-btn-details {
        background-color: #3170A8;
        color: white;
    }

    .fournisseurs-btn-details:hover {
        background-color: #255a85;
    }

    .fournisseurs-btn-edit {
        background-color: #f1f3f5;
        color: #495057;
        border: 1px solid #dee2e6;
    }

    .fournisseurs-btn-edit:hover {
        background-color: #e9ecef;
    }

    .fournisseurs-btn-delete {
        background-color: white;
        color: #dc3545;
        border: 1px solid #dc3545;
    }

    .fournisseurs-btn-delete:hover {
        background-color: #dc3545;
        color: white;
    }

    @media (max-width: 768px) {
        .fournisseurs-search-container {
            flex-direction: column;
        }

        .fournisseurs-search-wrapper {
            max-width: 100%;
        }
    }
</style>
@endsection

@section('content')

<!-- Bannière bleue -->
<div class="fournisseurs-page-header">
    <div class="container">
        <h1><i class="fas fa-truck"></i> Gestion des Fournisseurs</h1>
        <div class="subtitle">Liste et gestion des fournisseurs</div>
    </div>
</div>

<x-alert></x-alert>

<div id="fournisseurs-content">
    <div class="fournisseurs-action-bar">
        <div class="row justify-content-center">
            <div class="fournisseurs-search-container">
                <div class="fournisseurs-search-wrapper">
                    <i class="fas fa-search fournisseurs-search-icon"></i>
                    <input type="text" class="form-control fournisseurs-search-input" placeholder="Rechercher un fournisseur...">
                </div>
                <button class="fournisseurs-btn-filter"><i class="fas fa-filter"></i> Filtres</button>
            </div>
        </div>
    </div>

    <!-- Bouton d'ajout de fournisseur -->
    <button type="button" class="btn fournisseurs-btn-primary" data-bs-toggle="modal" data-bs-target="#addFournisseurModal">
        <i class="fas fa-plus-circle"></i> Ajouter un fournisseur
    </button>

    <!-- Tableau des fournisseurs -->
    <section class="fournisseurs-section mx-4">
        <div class="fournisseurs-table-header">
            <h2><i class="fas fa-building"></i> Fournisseurs</h2>
            <p>Liste des fournisseurs référencés</p>
        </div>

        <table class="table">
            <caption>
                Liste des fournisseurs de l'IUT de Villetaneuse
            </caption>
            <thead>
                <tr>
                    <th scope="col">N°</th>
                    <th scope="col">Entreprise</th>
                    <th scope="col">Contact</th>
                    <th scope="col">Spécialité</th>
                    <th scope="col">SIRET</th>
                    <th scope="col">Statut</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($suppliers as $supplier)
                    <tr>
                        <th scope="row">#{{ $supplier['id'] }}</th>
                        <td>
                            <strong>{{ $supplier['company_name'] }}</strong><br>
                            <small style="color: #6c757d;">
                                <i class="fas fa-envelope"></i> {{ $supplier['email'] }}<br>
                                <i class="fas fa-phone"></i> {{ $supplier['phone_number'] }}
                            </small>
                        </td>
                        <td>
                            <strong>{{ $supplier['contact_name'] }}</strong>
                        </td>
                        <td>{{ $supplier['specialite'] }}</td>
                        <td><code>{{ $supplier['siret'] }}</code></td>
                        <td>
                            @if($supplier['is_valid'])
                                <span class="fournisseurs-badge-valid">
                                    <i class="fas fa-check"></i> Validé
                                </span>
                            @else
                                <span class="fournisseurs-badge-invalid">
                                    <i class="fas fa-times"></i> Non validé
                                </span>
                            @endif
                            <br>
                            <small style="color: #6c757d;">{{ $supplier['note'] }}</small>
                        </td>
                        <td>
                            <div class="fournisseurs-action-buttons">
                                <button class="fournisseurs-btn-action fournisseurs-btn-details" title="Voir les détails">
                                    <i class="fas fa-eye"></i> Détails
                                </button>
                                <button class="fournisseurs-btn-action fournisseurs-btn-edit" title="Modifier">
                                    <i class="fas fa-edit"></i> Modifier
                                </button>
                                <button class="fournisseurs-btn-action fournisseurs-btn-delete" title="Supprimer">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </section>
</div>

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
                        <label for="company-name" class="form-label">Nom de l'entreprise <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="company-name" required>
                    </div>
                    <div class="mb-3">
                        <label for="siret" class="form-label">SIRET <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="siret" maxlength="14" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">Téléphone <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control" id="phone" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="contact-name" class="form-label">Nom du contact <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="contact-name" required>
                    </div>
                    <div class="mb-3">
                        <label for="specialite" class="form-label">Spécialité</label>
                        <input type="text" class="form-control" id="specialite" placeholder="Ex: Matériel informatique, Fournitures...">
                    </div>
                    <div class="mb-3">
                        <label for="note" class="form-label">Note / Remarque</label>
                        <textarea class="form-control" id="note" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="submit" form="addFournisseurForm" class="btn fournisseurs-btn-primary">Ajouter</button>
            </div>
        </div>
    </div>
</div>

@endsection