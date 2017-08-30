<?php

namespace Tests\Feature;

use App\Book;
use App\Author;
use App\Category;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BookTest extends TestCase
{
    use DatabaseTransactions, WithoutMiddleware;

    public function testShowEndpointReturnsTheSpecifiedBook()
    {
        $book = factory(Book::class)->states(['withCategory', 'withAuthor'])->create();

        $response = $this->getJson("/api/books/{$book->id}");

        $response->assertJsonFragment([
            'id' => (int) $book->id,
            'category_id' => (int) $book->category_id,
            'author_id' => (int) $book->author_id,
            'title' => $book->title,
            'description' => $book->description,
            'cover_image' => $book->cover_image,
            'isbn' => $book->isbn,
            'publication_year' => (int) $book->publication_year,
            'owner' => $book->owner,
            'location' => $book->location,
            'status' => $book->status,
            'average_rating' => $book->averageRating,
            'user_reviews' => $book->userReviews->map(function ($review) {
                return [
                    'id' => (int) $review->id,
                    'user_id' => (int) $review->user_id,
                    'user_name' => $review->user->first_name,
                    'rating' => $review->rating,
                    'comments' => $review->comments
                ];
            })
        ]);
    }

    public function testStoreEndpointCreatesABookInTheDatabase()
    {
        $category = factory(Category::class)->create();
        $author = factory(Author::class)->create();

        $data = [
            'category_id' => $category->id,
            'author_id' => $author->id,
            'title' => 'Test title',
            'description' => 'Test description.',
            'cover_image' => 'http://lorempixel.com/300/300',
            'isbn' => 'abcde12345',
            'publication_year' => 2017,
            'owner' => 'Daniel Leach',
            'location' => 'Software office'
        ];

        $response = $this->postJson("/api/books", $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('books', $data);
    }

    public function testUpdateEndpointUpdatesAPostInTheDatabase()
    {
        $book = factory(Book::class)->states(['withCategory', 'withAuthor'])->create();

        $data = [
            'title' => 'New test title',
            'description' => 'New test description.',
            'cover_image' => 'http://lorempixel.com/300/300',
            'isbn' => 'abcde12345',
            'publication_year' => 2017,
            'owner' => 'Daniel Leach',
            'location' => 'Software office'
        ];

        $response = $this->patchJson("/api/books/{$book->id}", $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('books', $data);
    }

    public function testDestroyEndpointRemovesABook()
    {
        $book = factory(Book::class)->states(['withCategory', 'withAuthor'])->create();

        $response = $this->deleteJson("/api/books/{$book->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('books', ['id' => $book->id, 'deleted_at' => null]);
    }
}
