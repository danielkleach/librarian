<?php

namespace Tests\Feature;

use App\Book;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FeaturedBookTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    public function testIndexEndpointReturnsOnlyFeaturedBooks()
    {
        $book1 = factory(Book::class)->states(['withCategory'])->create(['featured' => true]);
        $book2 = factory(Book::class)->states(['withCategory'])->create(['featured' => false]);

        $response = $this->getJson("/featured/books");

        $response->assertStatus(200);
        $response->assertJsonFragment(['id' => $book1->id]);
        $response->assertJsonMissing(['id' => $book2->id]);
    }
}
