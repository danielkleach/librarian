<?php

namespace Tests\Feature;

use App\User;
use App\Video;
use Tests\TestCase;
use App\VideoReview;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class VideoReviewAuthorizationTest extends TestCase
{
    use DatabaseTransactions;

    public function testStoreRejectsAnUnauthorizedUser()
    {
        $user = factory(User::class)->create();
        $video = factory(Video::class)->create();

        $data = [
            'user_id' => (int) $user->id,
            'video_id' => (int) $video->id,
            'rating' => 3,
            'comments' => 'This video is decent.'
        ];

        $response = $this->actingAs(factory(User::class)->create())
            ->postJson("/videos/{$video->id}/video-reviews", $data);

        $response->assertStatus(401);
    }

    public function testUpdateRejectsAnUnauthorizedUser()
    {
        $videoReview = factory(VideoReview::class)->states(['withUser', 'withVideo'])->create();

        $data = [
            'rating' => 4,
            'comments' => 'This video is pretty good.'
        ];

        $response = $this->actingAs(factory(User::class)->create())
            ->patchJson("/video-reviews/{$videoReview->id}", $data);

        $response->assertStatus(401);
    }

    public function testDestroyRejectsAnUnauthorizedUser()
    {
        $videoReview = factory(VideoReview::class)->states(['withUser', 'withVideo'])->create();

        $response = $this->actingAs(factory(User::class)->create())
            ->deleteJson("/video-reviews/{$videoReview->id}");

        $response->assertStatus(401);
    }
}
