<?php

use App\UserReview;
use Illuminate\Database\Seeder;

class UserReviewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(UserReview::class, 100)->create();
    }
}
