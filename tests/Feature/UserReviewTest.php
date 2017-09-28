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

    public function testStoreEndpointCreatesAUserReviewInTheDatabase()
    {
        $user = factory(User::class)->create();
        $user->api_token = $user->generateToken();

        $book = factory(Book::class)->create();

        $data = [
            'book_id' => (int) $book->id,
            'rating' => 3,
            'comments' => 'This book is decent.'
        ];

        $response = $this->actingAs($user)->postJson("/books/{$book->id}/user-reviews", $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('user_reviews', $data);
    }

    public function testUpdateEndpointUpdatesAUserReviewInTheDatabase()
    {
        $user = factory(User::class)->create();
        $user->api_token = $user->generateToken();

        $userReview = factory(UserReview::class)->states(['withBook'])->create([
            'user_id' => $user->id
        ]);

        $data = [
            'rating' => 4,
            'comments' => 'This book is pretty good.'
        ];

        $response = $this->actingAs($user)->patchJson("/user-reviews/{$userReview->id}", $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('user_reviews', $data);
    }

    public function testDestroyEndpointRemovesAUserReview()
    {
        $user = factory(User::class)->create();
        $user->api_token = $user->generateToken();

        $userReview = factory(UserReview::class)->states(['withUser', 'withBook'])->create([
            'user_id' => $user->id
        ]);

        $response = $this->actingAs($user)->deleteJson("/user-reviews/{$userReview->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('user_reviews', ['id' => $userReview->id, 'deleted_at' => null]);
    }
}
