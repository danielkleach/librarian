<?php

namespace Tests\Feature;

use App\Book;
use App\UserReview;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RecommendedBookTest extends TestCase
{
    use DatabaseTransactions, WithoutMiddleware;

    public function testIndexEndpointReturnsTheBestRatedBooks()
    {
        $book1 = factory(Book::class)->states(['withCategory', 'withAuthor'])->create();
        $book1->userReviews()->saveMany(factory(UserReview::class, 8)->states(['withUser'])->make(['rating' => 5]));
        $book1->userReviews()->saveMany(factory(UserReview::class, 2)->states(['withUser'])->make(['rating' => 4]));

        $book2 = factory(Book::class)->states(['withCategory', 'withAuthor'])->create();
        $book2->userReviews()->saveMany(factory(UserReview::class, 10)->states(['withUser'])->make(['rating' => 5]));

        $response = $this->getJson("/recommended/books");

        $response->assertStatus(200);
        $responseData = $response->json();

        $this->assertEquals($book2->id, $responseData[0]['id']);
        $this->assertEquals($book1->id, $responseData[1]['id']);
    }
}
