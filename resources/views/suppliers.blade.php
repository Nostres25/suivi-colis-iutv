@extends('base')

@section('header')
    <div class="container">
        <h1 class="h1">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-truck"
                 viewBox="0 0 16 16">
                <path
                    d="M0 3.5A1.5 1.5 0 0 1 1.5 2h9A1.5 1.5 0 0 1 12 3.5V5h1.02a1.5 1.5 0 0 1 1.17.563l1.481 1.85a1.5 1.5 0 0 1 .329.938V10.5a1.5 1.5 0 0 1-1.5 1.5H14a2 2 0 1 1-4 0H5a2 2 0 1 1-3.998-.085A1.5 1.5 0 0 1 0 10.5zm1.294 7.456A2 2 0 0 1 4.732 11h5.536a2 2 0 0 1 .732-.732V3.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .294.456M12 10a2 2 0 0 1 1.732 1h.768a.5.5 0 0 0 .5-.5V8.35a.5.5 0 0 0-.11-.312l-1.48-1.85A.5.5 0 0 0 13.02 6H12zm-9 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2m9 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2"/>
            </svg>
            Gestion des Fournisseurs
        </h1>
        <p class="mb-0 opacity-75">Liste et gestion des fournisseurs</p>
    </div>
@endsection

@section('content')
    @use(Database\Seeders\PermissionValue)
    @use(App\Models\Role)
    @use(App\Models\Supplier)


    <section>
        <div class="row justify-content-center">
            <div class="search-container flex-column flex-sm-row">
                <div class="search-wrapper">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                         class="bi bi-search search-icon" viewBox="0 0 16 16">
                        <path
                            d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                    </svg>
                    <input type="text" class="form-control search-input" placeholder="Rechercher un fournisseur...">
                </div>
                <button id="search-filter" class="btn btn-outline-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                         class="bi bi-funnel-fill" viewBox="0 0 16 16">
                        <path
                            d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5z"/>
                    </svg>
                    Filtres
                </button>
            </div>
        </div>
    </section>

    <!-- Tableau des fournisseurs -->
    <section class="table-section table-responsive">
        {{--Pour pouvoir ajouter un fournisseur il faut avoir la permission de demander l'ajout d'un fournisseur ou de gérer les fournisseur--}}
        @if ($user->hasPermission(PermissionValue::GERER_FOURNISSEURS) || $user->hasPermission(PermissionValue::DEMANDER_AJOUT_FOURNISSEUR) )
            <button type="button" class="btn btn-primary erasure-alert" data-bs-toggle="modal" data-bs-target="#addSupplierModal">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle-fill"
                     viewBox="0 0 16 16">
                    <path
                        d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3z"/>
                </svg>
                Ajouter un fournisseur
            </button>
            <x-supplierCreationModal :user="$user"/>
        @endif
        <div class="table-header mt-4">
            <h2 class="h3">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor"
                     class="bi bi-building-fill" viewBox="0 0 16 16">
                    <path
                        d="M3 0a1 1 0 0 0-1 1v14a1 1 0 0 0 1 1h3v-3.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5V16h3a1 1 0 0 0 1-1V1a1 1 0 0 0-1-1zm1 2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3.5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5M4 5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zM7.5 5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5m2.5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zM4.5 8h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5m2.5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3.5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5"/>
                </svg>
                Fournisseurs
            </h2>
            <p>Liste des fournisseurs référencés</p>
        </div>
        <table class="table table-striped mb-0">
            {{ $suppliers->links()}}
            <caption>
                Liste des fournisseurs de l'IUT de Villetaneuse
            </caption>
            <thead>
            <tr>
                <th scope="col">Entreprise</th>
                <th scope="col" class="d-none d-md-table-cell">Contact</th>
                <th scope="col" class="d-none d-lg-table-cell">Spécialité</th>
                <th scope="col" class="ps-0">SIRET</th>
                <th scope="col">Statut</th>
            </tr>
            </thead>
            <tbody>
            {{-- TODO Pour le service financier faire apparaître en haut les fournisseurs dont il y a une demande de validation (récemment ajoutés)--}}
            @foreach ($suppliers as $supplier)
                <tr>
                    <td class="text-break">
                        <strong>{{ $supplier['company_name'] }}</strong><br>
                        <small>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                 class="bi bi-envelope-fill" viewBox="0 0 16 16">
                                <path
                                    d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414zM0 4.697v7.104l5.803-3.558zM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586zm3.436-.586L16 11.801V4.697z"/>
                            </svg> {{ $supplier['email'] }}<br>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                 class="bi bi-telephone-fill" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                      d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877z"/>
                            </svg> {{ $supplier['phone_number'] }}
                        </small>
                    </td>
                    <td class="d-none d-md-table-cell">
                        <strong>{{ $supplier['contact_name'] }}</strong>
                    </td>
                    <td class="d-none d-lg-table-cell">{{ $supplier['speciality'] }}</td>
                    <td class="text-break ps-0"><code>{{ $supplier['siret'] }}</code></td>
                    <td>
                        @if($supplier['is_valid'])
                            <span class="fournisseurs-badge-valid">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                     class="bi bi-check-lg" viewBox="0 0 16 16">
                                  <path
                                      d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425z"/>
                                </svg> Validé
                            </span>
                        @else
                            <span class="fournisseurs-badge-invalid">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                     class="bi bi-x-lg" viewBox="0 0 16 16">
                                  <path
                                      d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
                                </svg> Non validé
                            </span>
                        @endif
                        <br>
                        <small>{{ Str::limit($supplier['note'], 100) }}</small>
                    </td>
                    <td class="ps-0 pe-0">
                        <button class="btn btn-light btn-more-options">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                 class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                                <path
                                    d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0"/>
                            </svg>
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $suppliers->links()}}
    </section>

@endsection
