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
        $this->call(AuthorSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(BookSeeder::class);
        $this->call(DigitalBookSeeder::class);
        $this->call(RentalSeeder::class);
        $this->call(DownloadSeeder::class);
        $this->call(UserReviewSeeder::class);
        $this->call(FavoriteBookSeeder::class);
    }
}
