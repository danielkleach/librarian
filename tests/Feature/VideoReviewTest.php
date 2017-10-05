<?php

namespace Tests\Feature;

use App\User;
use App\Video;
use Tests\TestCase;
use App\VideoReview;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class VideoReviewTest extends TestCase
{
    use DatabaseTransactions, WithoutMiddleware;

    public function testStoreEndpointCreatesAVideoReviewInTheDatabase()
    {
        $user = factory(User::class)->create();
        $user->api_token = $user->generateToken();

        $video = factory(Video::class)->create();

        $data = [
            'video_id' => (int) $video->id,
            'rating' => 3,
            'comments' => 'This video is decent.'
        ];

        $response = $this->actingAs($user)->postJson("/videos/{$video->id}/video-reviews", $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('video_reviews', $data);
    }

    public function testUpdateEndpointUpdatesAVideoReviewInTheDatabase()
    {
        $user = factory(User::class)->create();
        $user->api_token = $user->generateToken();

        $videoReview = factory(VideoReview::class)->states(['withVideo'])->create([
            'user_id' => $user->id
        ]);

        $data = [
            'rating' => 4,
            'comments' => 'This video is pretty good.'
        ];

        $response = $this->actingAs($user)->patchJson("/video-reviews/{$videoReview->id}", $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('video_reviews', $data);
    }

    public function testDestroyEndpointRemovesAVideoReview()
    {
        $user = factory(User::class)->create();
        $user->api_token = $user->generateToken();

        $videoReview = factory(VideoReview::class)->states(['withUser', 'withVideo'])->create([
            'user_id' => $user->id
        ]);

        $response = $this->actingAs($user)->deleteJson("/video-reviews/{$videoReview->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('video_reviews', ['id' => $videoReview->id, 'deleted_at' => null]);
    }
}
