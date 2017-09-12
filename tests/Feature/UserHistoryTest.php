<?php

namespace Tests\Feature;

use App\User;
use App\Rental;
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

        $rentals = factory(Rental::class, 5)->states(['withBook'])->create([
            'user_id' => $user->id
        ]);

        $response = $this->actingAs($user)->getJson("/users/{$user->id}/history");

        $response->assertStatus(200);
        foreach ($rentals as $rental) {
            $response->assertJsonFragment([
                'id' => (int) $rental->id,
                'user_id' => (int) $rental->user_id,
                'book_id' => (int) $rental->book_id,
                'book_title' => $rental->book->title,
                'book_description' => $rental->book->description,
                'category_id' => (int) $rental->book->category_id,
                'category_name' => $rental->book->category->name,
                'checkout_date' => Carbon::createFromFormat('Y-m-d H:i:s', $rental->checkout_date)
                    ->toDateTimeString(),
                'due_date' => Carbon::createFromFormat('Y-m-d H:i:s', $rental->due_date)
                    ->toDateTimeString(),
                'return_date' => $rental->return_date
                    ? Carbon::createFromFormat('Y-m-d H:i:s', $rental->return_date)
                        ->toDateTimeString()
                    : null
            ]);
        }
    }
}
