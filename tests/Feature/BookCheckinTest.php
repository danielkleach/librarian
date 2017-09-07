<?php

namespace Tests\Feature;

use App\Tracker;
use App\User;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BookCheckinTest extends TestCase
{
    use DatabaseTransactions, WithoutMiddleware;

    public function testUpdateEndpointUpdatesATrackerInTheDatabase()
    {
        $user = factory(User::class)->create();
        $user->api_token = $user->generateToken();

        $tracker = factory(Tracker::class)->states(['withBook'])->create([
            'user_id' => $user->id,
            'return_date' => null
        ]);

        $data = ['return_date' => Carbon::now()->toDateTimeString()];

        $response = $this->actingAs($user)->postJson("/books/{$tracker->book_id}/checkin", $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('trackers', [
            'id' => $tracker->id,
            'return_date' => $data['return_date']
        ]);
    }
}
