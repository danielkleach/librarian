<?php

namespace Tests\Feature;

use App\User;
use App\Tracker;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserHistoryTest extends TestCase
{
    use DatabaseTransactions, WithoutMiddleware;

    public function testIndexEndpointReturnsCheckoutHistoryForAUser()
    {
        $user = factory(User::class)->create();
        $user->api_token = $user->generateToken();

        $trackers = factory(Tracker::class, 5)->states(['withBook'])->create([
            'user_id' => $user->id
        ]);

        $response = $this->actingAs($user)->getJson("/users/{$user->id}/history");

        $response->assertStatus(200);
        foreach ($trackers as $tracker) {
            $response->assertJsonFragment([
                'id' => (int) $tracker->id,
                'user_id' => (int) $tracker->user_id,
                'book_id' => (int) $tracker->book_id,
                'book_title' => $tracker->book->title,
                'book_description' => $tracker->book->description,
                'category_id' => (int) $tracker->book->category_id,
                'category_name' => $tracker->book->category->name,
                'author_id' => (int) $tracker->book->author_id,
                'author_name' => $tracker->book->author->name,
                'checkout_date' => Carbon::createFromFormat('Y-m-d H:i:s', $tracker->checkout_date)
                    ->toDateTimeString(),
                'due_date' => Carbon::createFromFormat('Y-m-d H:i:s', $tracker->due_date)
                    ->toDateTimeString(),
                'return_date' => $tracker->return_date
                    ? Carbon::createFromFormat('Y-m-d H:i:s', $tracker->return_date)
                        ->toDateTimeString()
                    : null
            ]);
        }
    }
}