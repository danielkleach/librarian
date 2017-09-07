<?php

namespace Tests\Feature;

use App\User;
use App\Tracker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TrackerAuthorizationTest extends TestCase
{
    use DatabaseTransactions;

    public function testDestroyRejectsAnUnauthorizedUser()
    {
        $tracker = factory(Tracker::class)->states(['withUser', 'withBook'])->create();

        $response = $this->actingAs(factory(User::class)->create())
            ->deleteJson("/trackers/{$tracker->id}");

        $response->assertStatus(401);
    }
}
