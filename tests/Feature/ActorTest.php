<?php

namespace Tests\Feature;

use App\Actor;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ActorTest extends TestCase
{
    use DatabaseTransactions, WithoutMiddleware;

    public function testShowEndpointReturnsTheSpecifiedActor()
    {
        $actor = factory(Actor::class)->create();

        $response = $this->getJson("/actors/{$actor->id}");

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'id' => (int) $actor->id,
            'name' => $actor->name
        ]);
    }

    public function testStoreEndpointCreatesAnActorInTheDatabase()
    {
        $data = [
            'name' => 'Actor Name'
        ];

        $response = $this->postJson("/actors", $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('actors', $data);
    }

    public function testUpdateEndpointUpdatesAnActorInTheDatabase()
    {
        $actor = factory(Actor::class)->create();

        $data = [
            'name' => 'New Actor Name'
        ];

        $response = $this->patchJson("/actors/{$actor->id}", $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('actors', $data);
    }

    public function testDestroyEndpointRemovesAnActor()
    {
        $actor = factory(Actor::class)->create();

        $response = $this->deleteJson("/actors/{$actor->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('actors', ['id' => $actor->id, 'deleted_at' => null]);
    }
}
