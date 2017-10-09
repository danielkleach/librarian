<?php

namespace Tests\Feature;

use App\User;
use App\Book;
use App\BookReview;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BookReviewTest extends TestCase
{
    use DatabaseTransactions, WithoutMiddleware;

    public function testStoreEndpointCreatesABookReviewInTheDatabase()
    {
        $user = factory(User::class)->create();
        $user->api_token = $user->generateToken();

        $book = factory(Book::class)->create();

        $data = [
            'book_id' => (int) $book->id,
            'rating' => 3,
            'comments' => 'This book is decent.'
        ];

        $response = $this->actingAs($user)->postJson("/books/{$book->id}/book-reviews", $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('book_reviews', $data);
    }

    public function testUpdateEndpointUpdatesABookReviewInTheDatabase()
    {
        $user = factory(User::class)->create();
        $user->api_token = $user->generateToken();

        $bookReview = factory(BookReview::class)->states(['withBook'])->create([
            'user_id' => $user->id
        ]);

        $data = [
            'rating' => 4,
            'comments' => 'This book is pretty good.'
        ];

        $response = $this->actingAs($user)
            ->patchJson("/books/{$bookReview->book_id}/book-reviews/{$bookReview->id}", $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('book_reviews', $data);
    }

    public function testDestroyEndpointRemovesABookReview()
    {
        $user = factory(User::class)->create();
        $user->api_token = $user->generateToken();

        $bookReview = factory(BookReview::class)->states(['withUser', 'withBook'])->create([
            'user_id' => $user->id
        ]);

        $response = $this->actingAs($user)
            ->deleteJson("/books/{$bookReview->book_id}/book-reviews/{$bookReview->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('book_reviews', ['id' => $bookReview->id, 'deleted_at' => null]);
    }
}
