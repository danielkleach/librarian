<?php

use App\Book;
use App\Author;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Book::class, 50)->states(['withRandomCategory', 'withRandomUser'])->create()->each(function ($book) {
            $book->authors()->saveMany(factory(Author::class, 2)->make());
        });
    }
}
