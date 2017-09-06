<?php

namespace Tests\Feature;

use App\Tracker;
use App\Book;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PopularBookTest extends TestCase
{
    use DatabaseTransactions, WithoutMiddleware;

    public function testIndexEndpointReturnsTheMostPopularBooks()
    {
        $book1 = factory(Book::class)->states(['withCategory', 'withAuthor', 'withUser'])->create();
        $book1->trackers()->saveMany(factory(Tracker::class, 80)->states(['withUser'])->make());

        $book2 = factory(Book::class)->states(['withCategory', 'withAuthor', 'withUser'])->create();
        $book2->trackers()->saveMany(factory(Tracker::class, 100)->states(['withUser'])->make());

        $response = $this->getJson("/popular/books");

        $response->assertStatus(200);
        $responseData = $response->json();

        $this->assertEquals($book2->id, $responseData[0]['id']);
        $this->assertEquals($book1->id, $responseData[1]['id']);
    }
}
