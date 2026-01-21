<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

/**
 * Cette méthode est utilisée pour afficher sur la page admin, un message d'accueil et 
 * des instructions concernant l'accès à Adminer (SQL).
 * @return string|null Le message d'accueil à afficher sur le tableau de bord.
 */

class Dashboard extends BaseDashboard
{

    public function getSubheading(): ?string
    {
        return "Bienvenue sur la page d'administration ! Ici, tu peux gérer la base de données.
                En rentrant dans la console SQL, il faut se connecter à la base de donnée en utilisant
                les informations de connexion dans le fichier .env.";
    }
}