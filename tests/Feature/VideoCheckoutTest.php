<?php

namespace Tests\Feature;

use App\User;
use App\Video;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class VideoCheckoutTest extends TestCase
{
    use DatabaseTransactions, WithoutMiddleware;

    public function testStoreEndpointCreatesARentalInTheDatabase()
    {
        $user = factory(User::class)->create();
        $user->api_token = $user->generateToken();

        $video = factory(Video::class)->create();

        $response = $this->actingAs($user)->postJson("/videos/{$video->id}/checkout");

        $response->assertStatus(201);
        $this->assertDatabaseHas('rentals', [
            'user_id' => $user->id,
            'rentable_id' => $video->id,
            'rentable_type' => get_class($video)
        ]);
    }
}
