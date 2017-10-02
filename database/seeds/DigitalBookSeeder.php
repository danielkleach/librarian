<?php

use App\Author;
use App\DigitalBook;
use Illuminate\Database\Seeder;

class DigitalBookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(DigitalBook::class, 50)->create()->each(function ($book) {
            $book->authors()->saveMany(factory(Author::class, 2)->make());
        });
    }
}
