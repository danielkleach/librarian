<?php

namespace Tests\Feature;

use App\User;
use App\Tracker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BookCheckinAuthorizationTest extends TestCase
{
    use DatabaseTransactions;

    public function testStoreRejectsAnUnauthorizedUser()
    {
        $tracker = factory(Tracker::class)->states(['withUser', 'withBook'])->create([
            'return_date' => null
        ]);

        $response = $this->actingAs(factory(User::class)->create())
            ->postJson("/books/{$tracker->book_id}/checkin");

        $response->assertStatus(401);
    }
}
