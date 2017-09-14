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
        factory(User::class, 50)->create();
    }
}
