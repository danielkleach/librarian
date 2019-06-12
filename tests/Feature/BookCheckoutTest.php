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

    public function testStoreEndpointCreatesARentalInTheDatabase()
    {
        $user = factory(User::class)->create();
        $user->api_token = $user->generateToken();

        $book = factory(Book::class)->states(['withCategory'])->create();

        $response = $this->actingAs($user)->postJson("/books/{$book->id}/checkout");

        $response->assertStatus(201);
        $this->assertDatabaseHas('rentals', [
            'user_id' => $user->id,
            'rentable_id' => $book->id,
            'rentable_type' => get_class($book)
        ]);
    }
}
