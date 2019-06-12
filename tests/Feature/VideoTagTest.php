<?php

namespace Tests\Feature;

use App\Video;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class VideoTagTest extends TestCase
{
    use DatabaseTransactions, WithoutMiddleware;

    public function testStoreEndpointAddsATagToAVideo()
    {
        $video = factory(Video::class)->create();

        $data = [
            'tag' => 'php'
        ];

        $response = $this->postJson("/videos/{$video->id}/tags", $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('taggables', [
            'taggable_id' => $video->id,
            'taggable_type' => 'App\Video'
        ]);
    }

    public function testDestroyEndpointRemovesATagFromAVideo()
    {
        $tag = 'php';

        $video = factory(Video::class)->create();
        $video->attachTag($tag);

        $response = $this->deleteJson("/videos/{$video->id}/tags/{$tag}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('taggables', [
            'taggable_id' => $video->id,
            'taggable_type' => 'App/Video'
        ]);
    }
}
