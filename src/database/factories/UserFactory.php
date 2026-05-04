<?php

namespace Database\Factories;

use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'       => fake()->name(),
            'email'      => fake()->unique()->safeEmail(),
            'password'   => Hash::make('password'),
            'role'       => UserRole::VIEWER,
            'invited_by' => null,
        ];
    }

    public function admin(): static
    {
        return $this->state([
            'role' => UserRole::ADMIN,
        ]);
    }

    public function editor(): static
    {
        return $this->state([
            'role' => UserRole::EDITOR,
        ]);
    }

    public function viewer(): static
    {
        return $this->state([
            'role' => UserRole::VIEWER,
        ]);
    }
}
