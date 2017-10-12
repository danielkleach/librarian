<?php

namespace Tests\Feature;

use App\Book;
use App\User;
use App\Favorite;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FavoriteTest extends TestCase
{
    use DatabaseTransactions, WithoutMiddleware;

    public function testStoreEndpointCreatesAFavoriteInTheDatabase()
    {
        $book = factory(Book::class)->create();
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->postJson("/favorites/book/{$book->id}");

        $response->assertStatus(201);
        $this->assertDatabaseHas('favorites', [
            'user_id' => $user->id,
            'favoritable_id' => $book->id,
            'favoritable_type' => get_class($book)
        ]);
    }

    public function testDestroyEndpointRemovesAFavorite()
    {
        $favorite = factory(Favorite::class)->states(['withUser'])->create();

        $response = $this->deleteJson("/favorites/{$favorite->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('favorites', ['id' => $favorite->id, 'deleted_at' => null]);
    }
}
