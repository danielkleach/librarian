<?php

namespace Tests\Feature;

use App\User;
use App\Book;
use Tests\TestCase;
use App\FavoriteBook;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FavoriteBookTest extends TestCase
{
    use DatabaseTransactions, WithoutMiddleware;

    public function testIndexEndpointReturnsAUsersFavoriteBooks()
    {
        $user = factory(User::class)->create();
        $user->api_token = $user->generateToken();

        $favorites = factory(FavoriteBook::class, 3)->states(['withBook'])
            ->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->getJson("/users/{$user->id}/favorites");

        $response->assertStatus(200);
        foreach ($favorites as $favorite) {
            $response->assertJsonFragment([
                'id' => (int) $favorite->id,
                'user_id' => (int) $favorite->user_id,
                'book_id' => (int) $favorite->book_id,
                'created_at' => $favorite->created_at->format('F j, Y'),
                'updated_at' => $favorite->updated_at->format('F j, Y')
            ]);
        }
    }

    public function testStoreEndpointCreatesAFavoriteBookInTheDatabase()
    {
        $user = factory(User::class)->create();
        $user->api_token = $user->generateToken();

        $book = factory(Book::class)->create();

        $data = [
            'book_id' => (int) $book->id
        ];

        $response = $this->actingAs($user)->postJson("/users/{$user->id}/favorites", $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('favorite_books', $data);
    }

    public function testDestroyEndpointRemovesAFavoriteBook()
    {
        $user = factory(User::class)->create();
        $user->api_token = $user->generateToken();

        $favorite = factory(FavoriteBook::class)->states(['withBook'])->create([
            'user_id' => $user->id
        ]);

        $response = $this->actingAs($user)->deleteJson("/users/{$user->id}/favorites/{$favorite->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('favorite_books', ['id' => $favorite->id, 'deleted_at' => null]);
    }
}
