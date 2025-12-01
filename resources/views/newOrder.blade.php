<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<header>
    <h1>Enregistrer une commande</h1>
</header>
<body>
    <form action="/orders/new" method="post">
        <!-- @csrf allow to redirect our form on our page with post -->
        @csrf 
        <label for="fournisseur">Fournisseur</label>
        <input type="text" name="fournisseur" placeholder="SCIE"></br>

        <!-- Pouvoir ajouter des "articles" (les colis), définir une quantité, définir un titre, définir une description pour chaque article -->
        <!-- Pouvoir déposer un devis (facultatif) -->

        <button type="submit">Créer</button>


    </form>

    @if (isset($message))
      <p>{{$message}}</p>
    @endif

    
</body>
</html>