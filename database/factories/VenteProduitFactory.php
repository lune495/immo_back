<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class VenteProduitFactory extends Factory
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
            'produit_id'        => 4,
            'vente_id'          => 216,
            'qte'               => 200,
            'prix_vente'        => 2000,
            'created_at'        => now(),
            'updated_at'        => now(),
        ];
    }
}
