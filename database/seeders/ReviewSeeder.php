<?php

namespace Database\Seeders;

use App\Models\Eatery;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $myEatery = Eatery::where('slug', 'carinderia-ni-diaz')->first();
        $tita = User::where('email', 'tita.diaz@kaonta.test')->first();
        $me = User::where('email', 'diaz@kaonta.test')->first();

        // reviews for my eatery, made through the relationship
        $myEatery->reviews()->create([
            'user_id' => $tita->id,
            'rating' => 5,
            'body' => 'Lami kaayo! Balik-balikan ni Tita Diaz.',
        ]);

        $myEatery->reviews()->create([
            'user_id' => $me->id,
            'rating' => 4,
            'body' => 'Sulit ang tinola, init pa jud pag serve.',
        ]);

        // one more review from a random factory user
        Review::factory()->for($myEatery)->create([
            'rating' => 5,
        ]);

        // 0 to 6 reviews for each open factory eatery, closed ones get none
        $otherEateries = Eatery::where('id', '!=', $myEatery->id)
            ->where('is_open', true)
            ->get();

        foreach ($otherEateries as $eatery) {
            Review::factory(rand(0, 6))->for($eatery)->create();
        }
    }
}
