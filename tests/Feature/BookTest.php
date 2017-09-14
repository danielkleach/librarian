<?php

namespace Tests\Feature;

use App\User;
use App\Book;
use App\Category;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BookTest extends TestCase
{
    use DatabaseTransactions, WithoutMiddleware;

    public function testShowEndpointReturnsTheSpecifiedBook()
    {
        $book = factory(Book::class)->states(['withCategory'])->create();

        $response = $this->getJson("/books/{$book->id}");

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'id' => (int) $book->id,
            'category_id' => (int) $book->category_id,
            'owner_id' => $book->owner_id
                ? (int) $book->owner_id
                : null,
            'title' => $book->title,
            'description' => $book->description,
            'isbn' => $book->isbn,
            'publication_year' => (int) $book->publication_year,
            'location' => $book->location,
            'status' => $book->status,
            'featured' => $book->featured,
            'total_rentals' => $book->total_rentals ?? null,
            'rating' => $book->rating
                ? number_format($book->rating, 1)
                : null,
            'cover_image_url' => $book->getFirstMedia('cover_image')
                ? $book->getFirstMedia('cover_image')->getUrl()
                : null,
            'created_at' => $book->created_at->format('F j, Y'),
            'updated_at' => $book->updated_at->format('F j, Y')
        ]);
    }

    public function testStoreEndpointCreatesABookInTheDatabase()
    {
        $category = factory(Category::class)->create();
        $user = factory(User::class)->create();

        $data = [
            'category_id' => $category->id,
            'owner_id' => $user->id,
            'title' => 'Test title',
            'description' => 'Test description.',
            'isbn' => 'abcde12345',
            'publication_year' => 2017,
            'location' => 'Software office'
        ];

        $response = $this->postJson("/books", $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('books', $data);
    }

    public function testUpdateEndpointUpdatesABookInTheDatabase()
    {
        $book = factory(Book::class)->states(['withCategory'])->create();

        $data = [
            'title' => 'New test title',
            'description' => 'New test description.',
            'isbn' => 'abcde12345',
            'publication_year' => 2017,
            'location' => 'Software office'
        ];

        $response = $this->patchJson("/books/{$book->id}", $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('books', $data);
    }
}
