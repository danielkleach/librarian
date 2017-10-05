<?php

use App\VideoReview;
use Illuminate\Database\Seeder;

class VideoReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(VideoReview::class, 500)
            ->states(['withRandomUser', 'withRandomVideo'])
            ->create();
    }
}
