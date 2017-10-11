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
        $this->call(CategorySeeder::class);
        $this->call(UserSeeder::class);
        $this->call(BookSeeder::class);
        $this->call(EbookSeeder::class);
        $this->call(VideoSeeder::class);
        $this->call(RentalSeeder::class);
        $this->call(DownloadSeeder::class);
        $this->call(ReviewSeeder::class);
        $this->call(FavoriteSeeder::class);
    }
}
