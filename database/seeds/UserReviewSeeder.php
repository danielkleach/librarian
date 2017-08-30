<?php

use App\User;
use App\Book;
use App\Tracker;
use App\UserReview;
use Illuminate\Database\Seeder;

class UserReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(UserReview::class, 100)
            ->states(['withRandomUser', 'withRandomBook'])
            ->create();
    }
}
