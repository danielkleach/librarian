<?php

namespace Tests\Feature;

use App\Book;
use App\User;
use App\BookReview;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BookReviewAuthorizationTest extends TestCase
{
    use DatabaseTransactions;

    public function testStoreRejectsAnUnauthorizedUser()
    {
        $user = factory(User::class)->create();
        $book = factory(Book::class)->create();

        $data = [
            'user_id' => (int) $user->id,
            'book_id' => (int) $book->id,
            'rating' => 3,
            'comments' => 'This book is decent.'
        ];

        $response = $this->actingAs(factory(User::class)->create())
            ->postJson("/books/{$book->id}/book-reviews", $data);

        $response->assertStatus(401);
    }

    public function testUpdateRejectsAnUnauthorizedUser()
    {
        $bookReview = factory(BookReview::class)->states(['withUser', 'withBook'])->create();

        $data = [
            'rating' => 4,
            'comments' => 'This book is pretty good.'
        ];

        $response = $this->actingAs(factory(User::class)->create())
            ->patchJson("/books/{$bookReview->book_id}/book-reviews/{$bookReview->id}", $data);

        $response->assertStatus(401);
    }

    public function testDestroyRejectsAnUnauthorizedUser()
    {
        $bookReview = factory(BookReview::class)->states(['withUser', 'withBook'])->create();

        $response = $this->actingAs(factory(User::class)->create())
            ->deleteJson("/books/{$bookReview->book_id}/book-reviews/{$bookReview->id}");

        $response->assertStatus(401);
    }
}
