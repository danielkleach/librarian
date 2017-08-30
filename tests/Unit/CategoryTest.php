<?php

namespace Tests\Unit;

use App\Book;
use App\Category;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CategoryTest extends TestCase
{
    use DatabaseTransactions;

    public function testItCanGetBookCount()
    {
        $category = factory(Category::class)->create();

        factory(Book::class)->states(['withAuthor', 'withUser'])->create([
            'category_id' => $category->id
        ]);

        factory(Book::class)->states(['withAuthor', 'withUser'])->create([
            'category_id' => $category->id
        ]);

        $this->assertEquals(2, $category->getBookCount());
    }
}
