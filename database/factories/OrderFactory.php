<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $orderStats = [
            'BROUILLON', // enregistré à l'état de brouillon. Affiché seulement pour le demandeur

            'ANNULE', // La commande a été annulée par le demandeur à n'importe quelle étape

            'DEVIS_REFUSE', // à l'état de devis ; l'éditeur de bon de commande a refusé de faire un bon de commande

            'DEVIS', // à l'état de devis ; en attente d'un bon de commande (première étape)

            'BON_DE_COMMANDE_REFUSE', // à l'état de bon de commande ; le directeur a refusé de signer

            'BON_DE_COMMANDE_NON_SIGNE', // à l'état de bon de commande ; doit être signé par le directeur

            'BON_DE_COMMANDE_SIGNE', // à l'état de bon de commande signé ; en attente d'envoi du bon signé de commande au fournisseur

            'COMMANDE_REFUSEE', // à l'état de bon de commande signé ; commande refusée par le fournisseur

            'COMMANDE', // à l'état de bon de commande signé ; commmandé sans réponse, en attente de réponse du fournisseur

            'COMMANDE_AVEC_REPONSE', // à l'état de bon de commande signé ; le fournisseur a répondu favorablement à la commande. (Peut fournir le délai de livraison)

            'PARTIELLEMENT_LIVRE', // le demandeur à signalé que certains colis ont été livrés, et que d'autres sont manquants.

            'SERVICE_FAIT', // = terme utilisé par le demandeur pour signaler que la commande a été totalement livrée ; en attente de paiment par le service financier

            'LIVRE_ET_PAYE', // commande payée par le service financié (dernière étape)
        ];

        $state = fake()->randomElement($orderStats);

        return [
            'order_num' => fake()->unique()->randomNumber(5).fake()->unique()->randomNumber(6),
            'label' => fake()->title(),
            'description' => fake()->sentences(6, true),
            'state' => $state,
            'cost' => array_search($state, $orderStats) > array_search('BON_DE_COMMANDE_SIGNE', $orderStats) ? fake()->randomFloat(2, 0, 999999999) : null, // TODO S'il y a une erreur à propos du coût c'est que les 12 chiffres sont à prendre dans les négatifs et les positifs
            'quote_num' => fake()->randomLetter().fake()->unique()->randomNumber(7),
        ];
    }
}
