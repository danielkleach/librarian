<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(BookSeeder::class);
        $this->call(DigitalBookSeeder::class);
        $this->call(VideoSeeder::class);
        $this->call(RentalSeeder::class);
        $this->call(DownloadSeeder::class);
        $this->call(BookReviewSeeder::class);
        $this->call(VideoReviewSeeder::class);
        $this->call(FavoriteSeeder::class);
    }
}
