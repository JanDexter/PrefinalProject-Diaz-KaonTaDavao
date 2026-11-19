<?php

namespace Database\Factories;

use App\Models\District;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Eatery>
 */
class EateryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->lastName() . "'s Kainan";

        return [
            'district_id' => District::inRandomOrder()->first()->id,
            'name' => $name,
            'slug' => Str::slug($name),
            'address' => fake()->streetAddress() . ', Davao City',
            'price_range' => fake()->randomElement(['budget', 'mid', 'splurge']),
            'specialty' => fake()->randomElement(['Pork Adobo', 'Sinigang na Baboy', 'Lechon Manok', 'Pancit Canton', 'Inihaw na Panga', 'Bulalo', 'Sisig']),
            'is_open' => true,
        ];
    }

    // state for an eatery that is closed
    public function closed(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_open' => false,
        ]);
    }
}
