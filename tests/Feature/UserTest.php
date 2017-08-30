<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    use DatabaseTransactions, WithoutMiddleware;

    public function testShowEndpointReturnsTheSpecifiedUser()
    {
        $user = factory(User::class)->create();

        $response = $this->getJson("/api/users/{$user->id}");

        $response->assertJsonFragment([
            'id' => (int) $user->id,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'checked_out' => $user->getCheckedOut(),
            'overdue' => $user->getOverdue(),
            'user_reviews' => $user->userReviews->map(function ($review) {
                return [
                    'id' => (int) $review->id,
                    'book_id' => (int) $review->book_id,
                    'book_title' => $review->book->title,
                    'rating' => $review->rating,
                    'comments' => $review->comments
                ];
            }),
            'trackers' => $user->trackers->map(function ($tracker) {
                return [
                    'id' => (int) $tracker->id,
                    'book_id' => (int) $tracker->book_id,
                    'book_title' => $tracker->book->title,
                    'checkout_date' => $tracker->checkout_date->toDateTimeString(),
                    'due_date' => $tracker->due_date->toDateTimeString(),
                    'return_date' => $tracker->return_date
                        ? $tracker->return_date->toDateTimeString()
                        : null
                ];
            })
        ]);
    }

    public function testStoreEndpointCreatesAUserInTheDatabase()
    {
        $data = [
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test@test.com',
            'password' => 'Tester12'
        ];

        $response = $this->postJson("/api/users", $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('users', $data);
    }

    public function testUpdateEndpointUpdatesAUserInTheDatabase()
    {
        $user = factory(User::class)->create();

        $data = [
            'first_name' => 'New',
            'last_name' => 'Tester',
            'email' => 'tester@tester.com'
        ];

        $response = $this->patchJson("/api/users/{$user->id}", $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('users', $data);
    }

    public function testDestroyEndpointRemovesAUser()
    {
        $user = factory(User::class)->create();

        $response = $this->deleteJson("/api/users/{$user->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('users', ['id' => $user->id, 'deleted_at' => null]);
    }
}
