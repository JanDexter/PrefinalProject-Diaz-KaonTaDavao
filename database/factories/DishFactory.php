<?php

namespace Database\Factories;

use App\Models\Eatery;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Dish>
 */
class DishFactory extends Factory
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
            'name' => fake()->randomElement([
                'Tinolang Manok', 'Pork Adobo', 'Chicken Adobo', 'Sinigang na Baboy', 'Lechon Kawali',
                'Pancit Bihon', 'Ginataang Gulay', 'Pinakbet', 'Fried Bangus', 'Kinilaw na Tuna',
                'Inihaw na Liempo', 'Halo-Halo', 'Mango Shake', 'Durian Shake', 'Turon',
            ]),
            'price' => fake()->randomFloat(2, 30, 350),
            'is_bestseller' => fake()->boolean(25),
        ];
    }
}
