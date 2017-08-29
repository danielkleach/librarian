<?php

use Illuminate\Database\Seeder;
use Database\Seeds\StatusTypesTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(AuthorsTableSeeder::class);
        $this->call(StatusTypesTableSeeder::class);
        $this->call(BooksTableSeeder::class);
        $this->call(TrackersTableSeeder::class);
        $this->call(UserReviewsTableSeeder::class);
        $this->call(StatusesTableSeeder::class);
    }
}
