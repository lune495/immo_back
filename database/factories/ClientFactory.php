<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nom_complet'  => $this->faker->name,
            'email'        => $this->faker->name,
            'adresse'      => $this->faker->name,
            'telephone'    => 772009843,
        ];
    }
}
