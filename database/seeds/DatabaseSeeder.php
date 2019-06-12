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

        $this->call(CategorySeeder::class);
        $this->call(BookSeeder::class);
        $this->call(EbookSeeder::class);

        $this->call(GenreSeeder::class);
        $this->call(VideoSeeder::class);

        $this->call(DownloadSeeder::class);
        $this->call(RentalSeeder::class);
        $this->call(ReviewSeeder::class);
        $this->call(FavoriteSeeder::class);
    }
}
