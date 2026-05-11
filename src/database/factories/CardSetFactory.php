<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CardSetFactory extends Factory
{
    public function definition(): array
    {
        $number = fake()->unique()->numberBetween(1, 99);

        return [
            'code' => 'OP'.str_pad($number, 2, '0', STR_PAD_LEFT),
            'name' => fake()->words(3, true),
            'release_date_jp' => fake()->dateTimeBetween('-1 year', '+1 year')->format('Y-m-d'),
            'release_date_global' => fake()->dateTimeBetween('-6 months', '+1 year')->format('Y-m-d'),
            'total_cards' => fake()->numberBetween(50, 200),
        ];
    }
}
