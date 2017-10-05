<?php

use App\BookReview;
use Illuminate\Database\Seeder;

class BookReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(BookReview::class, 500)
            ->states(['withRandomUser', 'withRandomBook'])
            ->create();
    }
}
