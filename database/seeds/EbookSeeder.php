<?php

use App\Ebook;
use App\Author;
use Illuminate\Database\Seeder;

class EbookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Ebook::class, 50)->create()->each(function ($book) {
            $book->authors()->saveMany(factory(Author::class, 2)->make());
        });
    }
}
