{{-- TODO Faire en sorte que la navbar soit dynamique (que si on change de page l'élément actif change) --}}
{{-- TODO faire en sorte que le menu hamburger fonctionne dès 1400px de largeur --}}


<nav class="navbar navbar-expand-xl  navbar-light bg-light">
  <a class="navbar-brand" href="/">Suivi des colis IUTV </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item dropdown active">
        <a class="nav-link dropdown-toggle" href="/" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Commandes <span class="sr-only">(current)</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item active" href="/">Voir les commandes</a>
          <a class="dropdown-item" href="/orders?type=devis">Voir les devis</a>
          <a class="dropdown-item" href="/orders?type=bon_commande">Voir les bons de commandes</a>
          <a class="dropdown-item" href="/colis">Voir les colis</a>   
          <a class="dropdown-item" href="/orders/new">+ Ajouter une commande</a>
          <div class="dropdown-divider"></div>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/suppliers">Fournisseurs</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/about">À propos</a>
      </li> 
      {{-- Exemple de lien désactivé --}}
      {{-- <li class="nav-item">
        <a class="nav-link disabled" href="#">Disabled</a>
      </li> --}}
    </ul>
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control" type="search" placeholder="Search" aria-label="Search"/>
      <button class="btn my-2 mr-sm-2 my-sm-0 btn-primary" type="submit"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16"><path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/></svg></button>
    </form>
    <button class="btn btn-outline-success my-2 mr-sm-2 my-sm-0 d-block d-xl-none"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-qr-code-scan" viewBox="0 0 16 16">
        <path d="M0 .5A.5.5 0 0 1 .5 0h3a.5.5 0 0 1 0 1H1v2.5a.5.5 0 0 1-1 0zm12 0a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0V1h-2.5a.5.5 0 0 1-.5-.5M.5 12a.5.5 0 0 1 .5.5V15h2.5a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5v-3a.5.5 0 0 1 .5-.5m15 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1 0-1H15v-2.5a.5.5 0 0 1 .5-.5M4 4h1v1H4z"/>
        <path d="M7 2H2v5h5zM3 3h3v3H3zm2 8H4v1h1z"/>
        <path d="M7 9H2v5h5zm-4 1h3v3H3zm8-6h1v1h-1z"/>
        <path d="M9 2h5v5H9zm1 1v3h3V3zM8 8v2h1v1H8v1h2v-2h1v2h1v-1h2v-1h-3V8zm2 2H9V9h1zm4 2h-1v1h-2v1h3zm-4 2v-1H8v1z"/>
        <path d="M12 9h2V8h-2z"/></svg> Scan</button>
    <button class="btn btn-outline-success my-2 mr-sm-2 my-sm-0"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cloud-upload" viewBox="0 0 16 16">
      <path fill-rule="evenodd" d="M4.406 1.342A5.53 5.53 0 0 1 8 0c2.69 0 4.923 2 5.166 4.579C14.758 4.804 16 6.137 16 7.773 16 9.569 14.502 11 12.687 11H10a.5.5 0 0 1 0-1h2.688C13.979 10 15 8.988 15 7.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 2.825 10.328 1 8 1a4.53 4.53 0 0 0-2.941 1.1c-.757.652-1.153 1.438-1.153 2.055v.448l-.445.049C2.064 4.805 1 5.952 1 7.318 1 8.785 2.23 10 3.781 10H6a.5.5 0 0 1 0 1H3.781C1.708 11 0 9.366 0 7.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383"/>
      <path fill-rule="evenodd" d="M7.646 4.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707V14.5a.5.5 0 0 1-1 0V5.707L5.354 7.854a.5.5 0 1 1-.708-.708z"/>
      </svg> Déposer</button>
    <div class="btn-group">
      <a class="btn btn-secondary" href="/account" role="button" aria-expanded="false">Mon compte</a>
    {{-- Problème avec le dropdown qui fait qu'on doit appuyer deux fois sur le bouton pour ouvrir le menu --}}
    <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-expanded="false">
        <span class="sr-only">Toggle Dropdown</span>
    </button>
        <div class="dropdown-menu dropdown-menu-lg-right">
            <a class="dropdown-item" href="/account#settings">Mes paramètres</a>
            <a class="dropdown-item" href="/account#email">Gérer mon email</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item text-danger" href="/logout">Se déconnecter</a>
        </div>
    </div>
  </div>
</nav>