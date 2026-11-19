<?php

namespace Database\Seeders;

use App\Models\Dish;
use App\Models\District;
use App\Models\Eatery;
use App\Models\Feature;
use App\Models\Permit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EaterySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // my own eatery, made by hand
        $poblacion = District::where('name', 'Poblacion')->first();

        $myEatery = Eatery::create([
            'district_id' => $poblacion->id,
            'name' => 'Carinderia ni Diaz',
            'slug' => Str::slug('Carinderia ni Diaz'),
            'address' => 'San Pedro St., Poblacion, Davao City',
            'price_range' => 'budget',
            'specialty' => 'Tinolang Manok',
            'is_open' => true,
        ]);

        $myFeatures = Feature::whereIn('name', ['Suki ni Diaz', 'Budget Meal'])->pluck('id');
        $myEatery->features()->sync($myFeatures);

        $myEatery->permit()->create([
            'permit_no' => 'DVO-2026-0123',
            'expires_on' => '2027-01-23',
        ]);

        $myEatery->dishes()->createMany([
            ['name' => 'Tinolang Manok', 'price' => 85.00, 'is_bestseller' => true],
            ['name' => 'Kinilaw na Tuna', 'price' => 120.00],
            ['name' => 'Durian Shake', 'price' => 75.00],
        ]);

        // 14 more eateries from the factory, 3 of them closed
        $openEateries = Eatery::factory(11)->create();
        $closedEateries = Eatery::factory(3)->closed()->create();
        $eateries = $openEateries->concat($closedEateries);

        foreach ($eateries as $index => $eatery) {
            // make the first one expired so there is at least one expired permit
            if ($index == 0) {
                Permit::factory()->expired()->for($eatery)->create();
            } else {
                Permit::factory()->for($eatery)->create();
            }

            // reset unique() so dish names don't repeat inside the same eatery
            fake()->unique(true);

            // the specialty is always on the menu, plus 1 to 4 other dishes (2 to 5 in total)
            Dish::factory()->for($eatery)->create([
                'name' => $eatery->specialty,
                'is_bestseller' => true,
            ]);
            Dish::factory(rand(1, 4))->for($eatery)->create();

            $featureIds = Feature::inRandomOrder()->take(rand(1, 3))->pluck('id');
            $eatery->features()->attach($featureIds);
        }
    }
}
