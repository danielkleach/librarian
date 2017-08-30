<?php

namespace Tests\Feature;

use App\Tracker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TrackerTest extends TestCase
{
    use DatabaseTransactions, WithoutMiddleware;

    public function testShowEndpointReturnsTheSpecifiedTracker()
    {
        $tracker = factory(Tracker::class)->states(['withUser', 'withBook'])->create();

        $response = $this->getJson("/api/trackers/{$tracker->id}");

        $response->assertJsonFragment([
            'id' => (int) $tracker->id,
            'user_id' => (int) $tracker->user_id,
            'user_name' => $tracker->user->first_name,
            'book_id' => (int) $tracker->book_id,
            'book_title' => $tracker->book->title,
            'checkout_date' => $tracker->checkout_date->toDateTimeString(),
            'due_date' => $tracker->due_date->toDateTimeString(),
            'return_date' => $tracker->return_date
                ? $tracker->return_date->toDateTimeString()
                : null
        ]);
    }

    public function testDestroyEndpointRemovesATracker()
    {
        $tracker = factory(Tracker::class)->states(['withUser', 'withBook'])->create();

        $response = $this->deleteJson("/api/trackers/{$tracker->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('trackers', ['id' => $tracker->id, 'deleted_at' => null]);
    }
}
