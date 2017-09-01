<?php

namespace Tests\Feature;

use App\Tracker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TrackerTest extends TestCase
{
    use DatabaseTransactions, WithoutMiddleware;

    public function testDestroyEndpointRemovesATracker()
    {
        $tracker = factory(Tracker::class)->states(['withUser', 'withBook'])->create();

        $response = $this->deleteJson("/trackers/{$tracker->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('trackers', ['id' => $tracker->id, 'deleted_at' => null]);
    }
}
