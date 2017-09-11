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
                'book_id' => (int) $favorite->book_id,
                'category_id' => (int) $favorite->book->category_id,
                'category_name' => $favorite->book->category->name,
                'author_id' => (int) $favorite->book->author_id,
                'author_name' => $favorite->book->author->name,
                'title' => $favorite->book->title,
                'description' => $favorite->book->description,
                'isbn' => $favorite->book->isbn,
                'publication_year' => (int) $favorite->book->publication_year,
                'location' => $favorite->book->location,
                'status' => $favorite->book->status,
                'featured' => $favorite->book->featured,
                'average_rating' => $favorite->book->getAverageRating(),
                'cover_image_url' => $favorite->book->getFirstMedia('cover_image')
                    ? $favorite->book->getFirstMedia('cover_image')->getUrl()
                    : null
            ]);
        }
    }

    public function testStoreEndpointCreatesAFavoriteBookInTheDatabase()
    {
        $user = factory(User::class)->create();
        $user->api_token = $user->generateToken();

        $book = factory(Book::class)->states(['withCategory', 'withAuthor', 'withUser'])->create();

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

        $response->assertStatus(204);
        $this->assertDatabaseMissing('favorite_books', ['id' => $favorite->id, 'deleted_at' => null]);
    }
}