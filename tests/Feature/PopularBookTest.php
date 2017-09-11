<?php

namespace Tests\Feature;

use App\Book;
use App\Rental;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PopularBookTest extends TestCase
{
    use DatabaseTransactions, WithoutMiddleware;

    public function testIndexEndpointReturnsTheMostPopularBooks()
    {
        $book1 = factory(Book::class)->states(['withCategory', 'withAuthor'])->create();
        $book1->rentals()->saveMany(factory(Rental::class, 80)->states(['withUser'])->make());

        $book2 = factory(Book::class)->states(['withCategory', 'withAuthor'])->create();
        $book2->rentals()->saveMany(factory(Rental::class, 100)->states(['withUser'])->make());

        $response = $this->getJson("/popular/books");

        $response->assertStatus(200);
        $responseData = $response->json();

        $this->assertEquals($book2->id, $responseData[0]['id']);
        $this->assertEquals($book1->id, $responseData[1]['id']);
    }
}
