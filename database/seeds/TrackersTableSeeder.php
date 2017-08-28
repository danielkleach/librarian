<?php

use App\Tracker;
use Illuminate\Database\Seeder;

class TrackersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Tracker::class, 200)->create();
    }
}
