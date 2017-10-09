<?php

namespace Tests\Feature;

use App\User;
use App\Review;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ReviewAuthorizationTest extends TestCase
{
    use DatabaseTransactions;

    public function testDestroyRejectsAnUnauthorizedUser()
    {
        $review = factory(Review::class)->states(['withUser'])->create();

        $response = $this->actingAs(factory(User::class)->create())
            ->deleteJson("/reviews/{$review->id}");

        $response->assertStatus(401);
    }
}
