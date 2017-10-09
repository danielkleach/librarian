<?php

namespace Tests\Feature;

use App\Review;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BookReviewTest extends TestCase
{
    use DatabaseTransactions, WithoutMiddleware;

    public function testDestroyEndpointRemovesARental()
    {
        $review = factory(Review::class)->states(['withUser'])->create();

        $response = $this->deleteJson("/reviews/{$review->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('rentals', ['id' => $review->id, 'deleted_at' => null]);
    }
}
