<?php

namespace Tests\Feature;

use App\User;
use App\Actor;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ActorAuthorizationTest extends TestCase
{
    use DatabaseTransactions;

    public function testStoreRejectsAnUnauthorizedUser()
    {
        $data = ['name' => 'Actor Name'];

        $response = $this->actingAs(factory(User::class)->create())
            ->postJson("/actors", $data);

        $response->assertStatus(401);
    }

    public function testUpdateRejectsAnUnauthorizedUser()
    {
        $actor = factory(Actor::class)->create();

        $data = ['name' => 'New Actor Name'];

        $response = $this->actingAs(factory(User::class)->create())
            ->patchJson("/actors/{$actor->id}", $data);

        $response->assertStatus(401);
    }

    public function testDestroyRejectsAnUnauthorizedUser()
    {
        $actor = factory(Actor::class)->create();

        $response = $this->actingAs(factory(User::class)->create())
            ->deleteJson("/actors/{$actor->id}");

        $response->assertStatus(401);
    }
}
