<?php

namespace Tests\Feature;

use App\User;
use App\Book;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BookTest extends TestCase
{
    use DatabaseTransactions, WithoutMiddleware;

    public function testShowEndpointReturnsTheSpecifiedBook()
    {
        $book = factory(Book::class)->create();

        $response = $this->getJson("/books/{$book->id}");

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'id' => (int) $book->id,
            'owner_id' => $book->owner_id
                ? (int) $book->owner_id
                : null,
            'title' => $book->title,
            'description' => $book->description,
            'isbn' => $book->isbn,
            'publication_year' => (int) $book->publication_year,
            'tags' => $book->tags,
            'location' => $book->location,
            'featured' => $book->featured,
            'total_rentals' => $book->total_rentals ?? null,
            'rating' => $book->rating
                ? number_format($book->rating, 1)
                : null,
            'cover_image_url' => $book->cover_image_url ?? null,
            'created_at' => $book->created_at->format('F j, Y'),
            'updated_at' => $book->updated_at->format('F j, Y')
        ]);
    }

    public function testStoreEndpointCreatesABookInTheDatabase()
    {
        $user = factory(User::class)->states(['admin'])->create();

        $data = [
            'owner_id' => $user->id,
            'title' => 'New test title',
            'description' => 'New test description.',
            'isbn' => 'abcde12345',
            'publication_year' => 2017,
            'location' => 'Software office',
            'tags' => [
                'tag1',
                'tag2'
            ],
            'authors' => [
                'Author One',
                'Author Two'
            ]
        ];

        $response = $this->actingAs($user)->postJson("/books", $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('books', [
            'title' => 'New test title',
            'description' => 'New test description.',
            'isbn' => 'abcde12345',
            'publication_year' => 2017
        ]);
        $this->assertDatabaseHas('taggables', [
            'taggable_id' => $response->json()['data']['id'],
            'taggable_type' => 'App\Book'
        ]);
    }

    public function testUpdateEndpointUpdatesABookInTheDatabase()
    {
        $book = factory(Book::class)->create();
        $user = factory(User::class)->states(['admin'])->create();

        $data = [
            'title' => 'New test title',
            'description' => 'New test description.',
            'isbn' => 'abcde12345',
            'publication_year' => 2017,
            'location' => 'Software office',
        ];

        $response = $this->actingAs($user)->patchJson("/books/{$book->id}", $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('books', $data);
    }
}
