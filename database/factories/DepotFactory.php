<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DepotFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'produit_id'  => 5,
            'stock'        => 120,
            'pa'      => 200000,
            'limite'    => 1000,
            'created_at'    => now(),
            'fournisseur_id'    => 10,
        ];
    }
}
