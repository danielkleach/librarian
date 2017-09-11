<?php

namespace Tests\Feature;

use App\User;
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

        $response = $this->getJson("/books/{$book->id}");

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'id' => (int) $book->id,
            'category_id' => (int) $book->category_id,
            'category_name' => $book->category->name,
            'author_id' => (int) $book->author_id,
            'author_name' => $book->author->name,
            'owner_id' => (int) $book->owner_id ?? null,
            'owner_name' => $book->owner
                ? $book->owner->full_name
                : null,
            'title' => $book->title,
            'description' => $book->description,
            'isbn' => $book->isbn,
            'publication_year' => (int) $book->publication_year,
            'location' => $book->location,
            'status' => $book->status,
            'featured' => $book->featured,
            'average_rating' => $book->averageRating,
            'cover_image_url' => $book->getFirstMedia('cover_image')
                ? $book->getFirstMedia('cover_image')->getUrl()
                : null,
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
        $user = factory(User::class)->create();

        $data = [
            'category_id' => $category->id,
            'author_id' => $author->id,
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
        $book = factory(Book::class)->states(['withCategory', 'withAuthor'])->create();

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
