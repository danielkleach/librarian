<?php

use App\User;
use App\Book;
use App\Tracker;
use App\UserReview;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 50)->create()->each(function ($user) {
            $user->trackers()->saveMany(factory(Tracker::class, rand(5, 20))
                ->states(['withRandomBook'])
                ->make());

            $user->userReviews()->saveMany(factory(UserReview::class, rand(1, 10))
                ->states(['withRandomBook'])
                ->make());
        });
    }
}
