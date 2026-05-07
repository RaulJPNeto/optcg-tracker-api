<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class InvitationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'email' => fake()->unique()->safeEmail(),
            'token' => Str::uuid(),
            'invited_by' => User::factory()->admin(),
            'expires_at' => now()->addDays(7),
            'used_at' => null,
        ];
    }

    public function used(): static
    {
        return $this->state([
            'used_at' => now()->subHour()->toDateTimeString(),
            'expires_at' => now()->addDays(7)->toDateTimeString(),
        ]);
    }

    public function expired(): static
    {
        return $this->state([
            'expires_at' => now()->subDay()->toDateTimeString(),
            'used_at' => null,
        ]);
    }

    public function valid(): static
    {
        return $this->state([
            'expires_at' => now()->addDays(7)->toDateTimeString(),
            'used_at' => null,
        ]);
    }
}
