<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class VenteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'montant'           => 120000,
            'qte'               => 100,
            'user_id'           => 2,
            'montantencaisse'   => 50000,
            'monnaie'           => 12000,
            'client_id'         => 6,
            'created_at'        => now(),
            'updated_at'        => now(),
        ];
    }
}
