<?php

namespace Database\Factories;

use App\Models\Draw;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class DrawFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Draw::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = \Faker\Factory::create();
        return [
            'name' => $faker->word,
            'currency_fund' => rand(10000,5000000),
            'currency_random_from' => 1000,
            'currency_random_to' => 500000,
            'score_random_from' => 10,
            'score_random_to' => 1000,
            'currency_slot_count' => rand(3,10),
            'score_slot_count' => rand(3,10),
            'start_date' => Carbon::now()->subDay(),
            'end_date' => Carbon::now()->addDays(5),
        ];
    }
}
