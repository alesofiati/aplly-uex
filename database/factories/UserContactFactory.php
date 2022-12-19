<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserContact>
 */
class UserContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "name" => fake()->name, 
            "document_number" => fake()->unique()->randomDigit(11),
            "phone_number" => fake()->unique()->randomDigit(11),
            "street" => fake()->streetName(),
            "street_number" => fake()->numberBetween(0,100),
            "neighborhood" => 'teste',
            "city" => fake()->city(),
            "state" => fake()->state(),
            "latitude" => fake()->latitude(),
            "longitude" => fake()->longitude(),
        ];
    }
}
