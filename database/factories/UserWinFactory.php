<?php

namespace Database\Factories;

use App\Models\Draw;
use App\Models\User;
use App\Models\UserWin;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserWinFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserWin::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $type = ([
            UserWin::TYPE_SCORE,
            UserWin::TYPE_CURRENCY
        ])[rand(0,1)];
        $faker = \Faker\Factory::create();
        return [
            'name'      => $faker->word,
            'type'      => $type,
            'status'    => UserWin::STATUS_WIN,
            'user_id'   => User::factory(),
            'count'     => rand(1,1000),
            'draw_id'   => Draw::factory()
        ];
    }
}
