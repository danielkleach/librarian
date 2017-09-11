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

    public function testUpdateEndpointUpdatesARentalInTheDatabase()
    {
        $user = factory(User::class)->create();
        $user->api_token = $user->generateToken();

        $rental = factory(Rental::class)->states(['withBook'])->create([
            'user_id' => $user->id,
            'return_date' => null
        ]);

        $data = ['return_date' => Carbon::now()->toDateTimeString()];

        $response = $this->actingAs($user)->postJson("/books/{$rental->book_id}/checkin", $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('rentals', [
            'id' => $rental->id,
            'return_date' => $data['return_date']
        ]);
    }
}
