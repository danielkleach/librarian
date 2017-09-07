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
        $user->api_token = $user->generateToken();

        $book = factory(Book::class)->states(['withCategory', 'withAuthor', 'withUser'])->create();

        $response = $this->actingAs($user)->postJson("/books/{$book->id}/checkout");

        $response->assertStatus(201);
        $this->assertDatabaseHas('trackers', [
            'user_id' => $user->id,
            'book_id' => $book->id
        ]);
    }
}
