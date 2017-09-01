<?php

namespace Tests\Feature;

use App\Tracker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BookCheckinTest extends TestCase
{
    use DatabaseTransactions, WithoutMiddleware;

    public function testUpdateEndpointUpdatesATrackerInTheDatabase()
    {
        $tracker = factory(Tracker::class)->states(['withUser', 'withBook'])->create([
            'return_date' => null
        ]);

        $data = [
            'user_id' => $tracker->user_id
        ];

        $response = $this->postJson("/api/books/{$tracker->book_id}/checkin", $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('trackers', $data);
    }
}
