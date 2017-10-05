<?php

namespace Tests\Feature;

use App\User;
use App\Video;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class VideoAuthorizationTest extends TestCase
{
    use DatabaseTransactions;

    public function testStoreRejectsAnUnauthorizedUser()
    {
        $data = ['title' => 'Video Title'];

        $response = $this->actingAs(factory(User::class)->create())
            ->postJson("/videos", $data);

        $response->assertStatus(401);
    }

    public function testUpdateRejectsAnUnauthorizedUser()
    {
        $video = factory(Video::class)->create();

        $data = ['title' => 'New Video Title'];

        $response = $this->actingAs(factory(User::class)->create())
            ->patchJson("/videos/{$video->id}", $data);

        $response->assertStatus(401);
    }

    public function testDestroyRejectsAnUnauthorizedUser()
    {
        $video = factory(Video::class)->create();

        $response = $this->actingAs(factory(User::class)->create())
            ->deleteJson("/videos/{$video->id}");

        $response->assertStatus(401);
    }
}
