<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Package>
 */
class PackageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $shipping_date = fake()->dateTimeThisYear('+3 years');
        if ($shipping_date->getTimestamp() > now()->getTimestamp()) {
            $shipping_date = null;
        }

        return [
            'name' => fake()->title(),
            'cost' => fake()->randomFloat(2, 0, 12), // TODO S'il y a une erreur à propos du coût c'est que les 12 chiffres sont à prendre dans les négatifs et les positifs
            'date_expected_delivery' => fake()->dateTimeBetween(now(), '+3 years'),
            'shipping_date' => $shipping_date,
        ];
    }
}
