<?php

namespace Tests\Feature;

use App\Book;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PopularBookTest extends TestCase
{
    use DatabaseTransactions, WithoutMiddleware;

    public function testIndexEndpointReturnsTheMostPopularBooks()
    {
        $book1 = factory(Book::class)->states(['withCategory'])->create(['total_rentals' => 5]);
        $book2 = factory(Book::class)->states(['withCategory'])->create(['total_rentals' => 10]);
        $book3 = factory(Book::class)->states(['withCategory'])->create(['total_rentals' => 6]);

        $response = $this->getJson("/popular/books");

        $response->assertStatus(200);
        $responseData = $response->json();

        $this->assertEquals($book2->id, $responseData['data'][0]['id']);
        $this->assertEquals($book3->id, $responseData['data'][1]['id']);
        $this->assertEquals($book1->id, $responseData['data'][2]['id']);
    }
}
