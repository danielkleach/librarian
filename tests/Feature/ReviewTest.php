<?php

namespace Tests\Feature;

use App\User;
use App\Review;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ReviewTest extends TestCase
{
    use DatabaseTransactions, WithoutMiddleware;

    public function testDestroyEndpointRemovesAReview()
    {
        $user = factory(User::class)->create();
        $review = factory(Review::class)->create([
            'user_id' => $user->id
        ]);

        $response = $this->actingAs($user)->deleteJson("/reviews/{$review->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('reviews', ['id' => $review->id, 'deleted_at' => null]);
    }
}
