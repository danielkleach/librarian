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
        $book = factory(Book::class)->states(['withCategory', 'withAuthor', 'withUser'])->create();

        $data = [
            'user_id' => (int) $user->id
        ];

        $response = $this->postJson("/books/{$book->id}/checkout", $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('trackers', $data);
    }
}
