<?php

namespace Tests\Feature;

use App\Book;
use App\User;
use App\UserReview;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserReviewAuthorizationTest extends TestCase
{
    use DatabaseTransactions;

    public function testStoreRejectsAnUnauthorizedUser()
    {
        $user = factory(User::class)->create();
        $book = factory(Book::class)->states(['withCategory'])->create();

        $data = [
            'user_id' => (int) $user->id,
            'book_id' => (int) $book->id,
            'rating' => 3,
            'comments' => 'This book is decent.'
        ];

        $response = $this->actingAs(factory(User::class)->create())
            ->postJson("/books/{$book->id}/user-reviews", $data);

        $response->assertStatus(401);
    }

    public function testUpdateRejectsAnUnauthorizedUser()
    {
        $userReview = factory(UserReview::class)->states(['withUser', 'withBook'])->create();

        $data = [
            'rating' => 4,
            'comments' => 'This book is pretty good.'
        ];

        $response = $this->actingAs(factory(User::class)->create())
            ->patchJson("/user-reviews/{$userReview->id}", $data);

        $response->assertStatus(401);
    }

    public function testDestroyRejectsAnUnauthorizedUser()
    {
        $userReview = factory(UserReview::class)->states(['withUser', 'withBook'])->create();

        $response = $this->actingAs(factory(User::class)->create())
            ->deleteJson("/user-reviews/{$userReview->id}");

        $response->assertStatus(401);
    }
}
