<?php

use App\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create(['name' => 'Action']);
        Category::create(['name' => 'Adventure']);
        Category::create(['name' => 'Anthology']);
        Category::create(['name' => 'Art']);
        Category::create(['name' => 'Autobiographies']);
        Category::create(['name' => 'Biographies']);
        Category::create(['name' => 'Business']);
        Category::create(['name' => 'Children']);
        Category::create(['name' => 'Comics']);
        Category::create(['name' => 'Computers']);
        Category::create(['name' => 'Cookbooks']);
        Category::create(['name' => 'Crime']);
        Category::create(['name' => 'Diaries']);
        Category::create(['name' => 'Dictionaries']);
        Category::create(['name' => 'Drama']);
        Category::create(['name' => 'Education']);
        Category::create(['name' => 'Encyclopedias']);
        Category::create(['name' => 'Entertainment']);
        Category::create(['name' => 'Fantasy']);
        Category::create(['name' => 'Guide']);
        Category::create(['name' => 'Health']);
        Category::create(['name' => 'History']);
        Category::create(['name' => 'Horror']);
        Category::create(['name' => 'Journals']);
        Category::create(['name' => 'Math']);
        Category::create(['name' => 'Medical']);
        Category::create(['name' => 'Mystery']);
        Category::create(['name' => 'Poetry']);
        Category::create(['name' => 'Prayer']);
        Category::create(['name' => 'Religion']);
        Category::create(['name' => 'Romance']);
        Category::create(['name' => 'Satire']);
        Category::create(['name' => 'Science']);
        Category::create(['name' => 'Science Fiction']);
        Category::create(['name' => 'Self-Help']);
        Category::create(['name' => 'Series']);
        Category::create(['name' => 'Sports']);
        Category::create(['name' => 'Technology']);
        Category::create(['name' => 'Travel']);
    }
}
