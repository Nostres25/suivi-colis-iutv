<?php

namespace Database\Seeders;

// Permissions
// - Consulter toutes les commandes      => Pouvoir voir et rechercher toutes les commandes dans le système.
// - Consulter ses commandes             => Pouvoir voir uniquement les commandes appartenant au même département/service.
// - Créer des commandes                 => Pouvoir créer des commandes à l'état de devis.
// - Modifier des commandes              => Pouvoir modifier les informations principales d'une commande.
// - Ajouter un bon de livraison         => Pouvoir marquer les colis respectifs comme livrés et ajouter un bon de livraison.
// - Notes et commentaires               => Pouvoir ajouter des commentaires et modifier la note pour les commandes et les fournisseurs.
// - Demander l'ajout d'un fournisseur   => Pouvoir demander l'ajout d'un fournisseur au service financier.
// - Consulter la liste des fournisseurs => Pouvoir consulter la liste des fournisseurs valides.
// - Gérer les fournisseurs              => Pouvoir ajouter, modifier et valider ou invalider les fournisseurs.
// - Gérer les bons de commande          => Pouvoir ajouter, refuser, modifier et supprimer des bons de commande.
// - Payer les fournisseurs              => Pouvoir marquer les commandes comme payées.
// - Admin                               => Avoir tous les accès et pouvoir gérer la base de données.
enum PermissionValue: int
{
    case CONSULTER_COMMANDES = 2;
    case CONSULTER_SES_COMMANDES = 3;
    case CREER_COMMANDES = 4;
    case MODIFIER_COMMANDES = 5;
    case AJOUTER_BON_DE_LIVRAISON = 6;

    case NOTES_ET_COMMENTAIRES = 7;
    case DEMANDER_AJOUT_FOURNISSEUR = 8;
    case CONSULTER_LISTE_FOURNISSEURS = 9;
    case GERER_FOURNISSEUR = 10;
    case GERER_BONS_DE_COMMANDES = 11;
    case PAYER_FOURNISSEUR = 12;

    case ADMIN = 1;
}
