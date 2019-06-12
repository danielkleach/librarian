<?php

use App\Actor;
use App\Video;
use Illuminate\Database\Seeder;

class VideoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Video::class, 50)->states(['withRandomUser'])->create()->each(function ($video) {
            $video->actors()->saveMany(factory(Actor::class, 2)->make());
        });
    }
}
