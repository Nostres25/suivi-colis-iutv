<?php

namespace Database\Seeders;

enum Status: string
{ // états possibles de la commande (triés dans l'ordre) :

    case BROUILLON = 'BROUILLON'; // enregistré à l'état de brouillon. Affiché seulement pour le demandeur

    case DEVIS = 'DEVIS'; // à l'état de devis ; en attente d'un bon de commande (première étape)

    case DEVIS_REFUSE = 'DEVIS_REFUSE'; // à l'état de devis ; l'éditeur de bon de commande a refusé de faire un bon de commande

    case BON_DE_COMMANDE_NON_SIGNE = 'BON_DE_COMMANDE_NON_SIGNE'; // à l'état de bon de commande ; doit être signé par le directeur

    case BON_DE_COMMANDE_REFUSE = 'BON_DE_COMMANDE_REFUSE'; // à l'état de bon de commande ; le directeur a refusé de signer

    case BON_DE_COMMANDE_SIGNE = 'BON_DE_COMMANDE_SIGNE'; // à l'état de bon de commande signé ; en attente d'envoi du bon signé de commande au fournisseur

    case COMMANDE = 'COMMANDE'; // à l'état de bon de commande signé ; commmandé sans réponse, en attente de réponse du fournisseur

    case COMMANDE_REFUSEE = 'COMMANDE_REFUSEE'; // à l'état de bon de commande signé ; commande refusée par le fournisseur

    case COMMANDE_AVEC_REPONSE = 'COMMANDE_AVEC_REPONSE'; // à l'état de bon de commande signé ; le fournisseur a répondu favorablement à la commande. (Peut fournir le délai de livraison)

    case PARTIELLEMENT_LIVRE = 'PARTIELLEMENT_LIVRE'; // le demandeur à signalé que certains colis ont été livrés, et que d'autres sont manquants.

    case SERVICE_FAIT = 'SERVICE_FAIT'; // = terme utilisé par le demandeur pour signaler que la commande a été totalement livrée ; en attente de paiment par le service financier

    case LIVRE_ET_PAYE = 'LIVRE_ET_PAYE'; // commande payée par le service financié (dernière étape)

    case ANNULE = 'ANNULE'; // La commande a été annulée par le demandeur à n'importe quelle étape
}
