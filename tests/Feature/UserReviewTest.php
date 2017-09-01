<?php

namespace Tests\Feature;

use App\User;
use App\Book;
use App\UserReview;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserReviewTest extends TestCase
{
    use DatabaseTransactions, WithoutMiddleware;

    public function testShowEndpointReturnsTheSpecifiedUserReview()
    {
        $userReview = factory(UserReview::class)->states(['withUser', 'withBook'])->create();

        $response = $this->getJson("/api/user-reviews/{$userReview->id}");

        $response->assertJsonFragment([
            'id' => (int) $userReview->id,
            'user_id' => (int) $userReview->user_id,
            'user_name' => $userReview->user->full_name,
            'book_id' => (int) $userReview->book_id,
            'book_title' => $userReview->book->title,
            'rating' => $userReview->rating,
            'comments' => $userReview->comments
        ]);
    }

    public function testStoreEndpointCreatesAUserReviewInTheDatabase()
    {
        $user = factory(User::class)->create();
        $book = factory(Book::class)->states(['withCategory', 'withAuthor', 'withUser'])->create();

        $data = [
            'user_id' => (int) $user->id,
            'book_id' => (int) $book->id,
            'rating' => 3,
            'comments' => 'This book is decent.'
        ];

        $response = $this->postJson("/api/user-reviews", $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('user_reviews', $data);
    }

    public function testUpdateEndpointUpdatesAUserReviewInTheDatabase()
    {
        $userReview = factory(UserReview::class)->states(['withUser', 'withBook'])->create();

        $data = [
            'rating' => 4,
            'comments' => 'This book is pretty good.'
        ];

        $response = $this->patchJson("/api/user-reviews/{$userReview->id}", $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('user_reviews', $data);
    }

    public function testDestroyEndpointRemovesAUserReview()
    {
        $userReview = factory(UserReview::class)->states(['withUser', 'withBook'])->create();

        $response = $this->deleteJson("/api/user-reviews/{$userReview->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('user_reviews', ['id' => $userReview->id, 'deleted_at' => null]);
    }
}
