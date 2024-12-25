<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


class ProductFactory extends Factory
{

    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(rand(2,10)),
            'description' => $this->faker->text(),
            'price' => $this->faker->numberBetween(1000, 10000),
        ];
    }
}
