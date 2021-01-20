<?php

namespace Database\Seeders;

use App\Models\Draw;
use App\Models\Lot;
use App\Models\UserWin;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        Draw::factory()->has(Lot::factory()->count(3))->create();
    }
}
