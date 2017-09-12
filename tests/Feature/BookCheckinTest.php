<?php

namespace Tests\Feature;

use App\User;
use App\Rental;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BookCheckinTest extends TestCase
{
    use DatabaseTransactions, WithoutMiddleware;

    public function testStoreEndpointChecksInARentalInTheDatabase()
    {
        $user = factory(User::class)->create();
        $user->api_token = $user->generateToken();

        $rental = factory(Rental::class)->states(['withBook'])->create([
            'user_id' => $user->id,
            'return_date' => null
        ]);

        $response = $this->actingAs($user)->postJson("/books/{$rental->book_id}/checkin/{$rental->id}");

        $response->assertStatus(200);
        $this->assertDatabaseHas('rentals', [
            'id' => $rental->id,
            'return_date' => Carbon::now()->toDateTimeString()
        ]);
    }
}
