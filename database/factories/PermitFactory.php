<?php

namespace Database\Factories;

use App\Models\Eatery;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Permit>
 */
class PermitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'eatery_id' => Eatery::factory(),
            // 5 digits at the end so it never clashes with my own DVO-2026-0123
            'permit_no' => 'DVO-' . fake()->numberBetween(2024, 2026) . '-' . fake()->unique()->numerify('#####'),
            'expires_on' => fake()->dateTimeBetween('+1 month', '+2 years'),
        ];
    }

    // state for a permit that is already expired
    public function expired(): static
    {
        return $this->state(fn (array $attributes) => [
            'expires_on' => fake()->dateTimeBetween('-1 year', '-1 week'),
        ]);
    }
}
