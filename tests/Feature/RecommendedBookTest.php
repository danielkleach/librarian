<?php

namespace Tests\Feature;

use App\Book;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RecommendedBookTest extends TestCase
{
    use DatabaseTransactions, WithoutMiddleware;

    public function testIndexEndpointReturnsTheBestRatedBooks()
    {
        $book1 = factory(Book::class)->states(['withCategory'])->create(['rating' => 4.35]);
        $book2 = factory(Book::class)->states(['withCategory'])->create(['rating' => 4.22]);
        $book3 = factory(Book::class)->states(['withCategory'])->create(['rating' => 4.95]);

        $response = $this->getJson("/recommended/books");

        $response->assertStatus(200);
        $responseData = $response->json();

        $this->assertEquals($book3->id, $responseData['data'][0]['id']);
        $this->assertEquals($book1->id, $responseData['data'][1]['id']);
        $this->assertEquals($book2->id, $responseData['data'][2]['id']);
    }
}
