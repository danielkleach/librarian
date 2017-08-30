<?php

namespace Tests\Feature;

use App\User;
use App\Book;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BookCheckoutTest extends TestCase
{
    use DatabaseTransactions, WithoutMiddleware;

    public function testStoreEndpointCreatesATrackerInTheDatabase()
    {
        $user = factory(User::class)->create();
        $book = factory(Book::class)->states(['withCategory', 'withAuthor'])->create();

        $data = [
            'user_id' => (int) $user->id,
            'book_id' => (int) $book->id
        ];

        $response = $this->postJson("/api/books/checkout", $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('trackers', $data);
    }
}
