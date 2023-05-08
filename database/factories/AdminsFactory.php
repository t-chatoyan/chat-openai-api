<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Admins>
 */
class AdminsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->email(),
            'email_verified_at' => now(),
            'password' => '$2y$10$he3O7G1jGAiAIl/gZ5.FV.QfDKrSdz1Kc16AwW/3WR.AEKO4nuezC', // password
            'remember_token' => Str::random(10),
        ];
    }
}
