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

        $response = $this->getJson("/users/{$user->id}");

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'id' => (int) $user->id,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'checked_out' => $user->getCheckedOut()->map(function ($rental) {
                return [
                    'id' => (int) $rental->id,
                    'book_id' => (int) $rental->book_id,
                    'category_id' => (int) $rental->book->category_id,
                    'category_name' => $rental->book->category->name,
                    'author_id' => (int) $rental->book->author_id,
                    'author_name' => $rental->book->author->name,
                    'book_title' => $rental->book->title,
                    'checkout_date' => $rental->checkout_date->toDateTimeString(),
                    'due_date' => $rental->due_date->toDateTimeString()
                ];
            }),
            'overdue' => $user->getOverdue()->map(function ($rental) {
                return [
                    'id' => (int) $rental->id,
                    'book_id' => (int) $rental->book_id,
                    'category_id' => (int) $rental->book->category_id,
                    'category_name' => $rental->book->category->name,
                    'author_id' => (int) $rental->book->author_id,
                    'author_name' => $rental->book->author->name,
                    'book_title' => $rental->book->title,
                    'checkout_date' => $rental->checkout_date->toDateTimeString(),
                    'due_date' => $rental->due_date->toDateTimeString()
                ];
            }),
            'user_reviews' => $user->userReviews->map(function ($review) {
                return [
                    'id' => (int) $review->id,
                    'book_id' => (int) $review->book_id,
                    'book_title' => $review->book->title,
                    'rating' => $review->rating,
                    'comments' => $review->comments
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

        $response = $this->postJson("/users", $data);

        $response->assertStatus(201);
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

        $response = $this->patchJson("/users/{$user->id}", $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('users', $data);
    }

    public function testDestroyEndpointRemovesAUser()
    {
        $user = factory(User::class)->create();

        $response = $this->deleteJson("/users/{$user->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('users', ['id' => $user->id, 'deleted_at' => null]);
    }
}
