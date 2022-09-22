<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProduitFactory extends Factory
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
            'designation' => $this->faker->name,
            'code'        => $this->faker->name,
            'description' => $this->faker->name,
            'image'       => $this->faker->name,
            'pa'          => 12000,
            'pv'          => 15000,
            'limite'      => 100,
            'famille_id'  => 1,
            'created_at'  => now(),
        ];
    }
}
