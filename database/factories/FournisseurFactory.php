<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FournisseurFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nom_complet'   => $this->faker->name,
            'email'         => $this->faker->name,
            'telephone'     => $this->faker->unique()->name,
            'adresse'       => $this->faker->name,
            'alias'         => $this->faker->name,
            'image'         => $this->faker->name,
            'created_at'  => now(),
        ];
    }
}
