<?php

use App\Genre;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Genre::create(['name' => 'Action']);
        Genre::create(['name' => 'Adventure']);
        Genre::create(['name' => 'Animation']);
        Genre::create(['name' => 'Biography']);
        Genre::create(['name' => 'Comedy']);
        Genre::create(['name' => 'Crime']);
        Genre::create(['name' => 'Documentary']);
        Genre::create(['name' => 'Drama']);
        Genre::create(['name' => 'Family']);
        Genre::create(['name' => 'Fantasy']);
        Genre::create(['name' => 'History']);
        Genre::create(['name' => 'Horror']);
        Genre::create(['name' => 'Music']);
        Genre::create(['name' => 'Musical']);
        Genre::create(['name' => 'Mystery']);
        Genre::create(['name' => 'Romance']);
        Genre::create(['name' => 'Sci-Fi']);
        Genre::create(['name' => 'Sports']);
        Genre::create(['name' => 'Thriller']);
        Genre::create(['name' => 'War']);
        Genre::create(['name' => 'Western']);
    }
}
