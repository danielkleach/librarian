<?php

namespace Tests\Feature;

use App\Video;
use App\Actor;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class VideoActorTest extends TestCase
{
    use DatabaseTransactions, WithoutMiddleware;

    public function testStoreEndpointAddsAnActorToAVideo()
    {
        $actor = factory(Actor::class)->create();
        $video = factory(Video::class)->create();

        $data = [
            'actor_id' => $actor->id
        ];

        $response = $this->postJson("/videos/{$video->id}/actors", $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('video_actors', [
            'video_id' => $video->id,
            'actor_id' => $actor->id
        ]);
    }

    public function testDestroyEndpointRemovesAnActorFromAVideo()
    {
        $actor = factory(Actor::class)->create();
        $video = factory(Video::class)->create();
        $video->actors()->attach($actor->id);

        $response = $this->deleteJson("/videos/{$video->id}/actors/{$actor->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('video_actors', [
            'video_id' => $video->id,
            'actor_id' => $actor->id
        ]);
    }
}
